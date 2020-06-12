<?php

namespace Niaz\DBpanel\Http\Controllers;

use ReflectionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Niaz\DBpanel\Http\Filters\Filter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Arr;

class DBpanelController extends Controller
{
    protected $parameters;

    public function index()
    {
        $tables = DB::select('SHOW TABLES');

        return view('dbpanel::index')->with(['tables' => $tables]);
    }

    public function data($table)
    {
        $filter = new Filter;
        $filtered = $filter->loadTable($table);
        
        if(request()->has('delete')){
            $filtered_query = $filtered->getQuery();
            $row=$filtered_query->get();
            $filtered_query->delete();
            return [
                'result' => ['data'=>$row],
                'filter_status' => 'deleted successfully'
            ];
        }
        $filtered_data = $filtered->getData();

        $count = ! is_string($filtered_data) ? count($filtered_data) : 'Error';

        return ['result' => $filtered_data, 'filter_status' => $filter->status(), 'request' => request()->all(), 'total' => $count];
    }

    public function checkController(Request $request, $controller)
    {
        $user = auth()->user();
        if (request()->has('dbpanel_auth_id')) {
            $user = $this->login();
            $request->request->remove('dbpanel_auth_id');
        }
        $parameters = $this->setParameters();

        DB::connection()->enableQueryLog();

        $controller = explode('@', $controller);
        $controller_namespace = config('dbpanel.controller').str_replace('.', '\\', $controller[0]);
        $method = $controller[1];

        // get class information
        // https://www.php.net/manual/en/reflectionclass.getmethod.php
        // $r = new ReflectionClass(new $controller_namespace);
        // dd($r->getConstants($method)->getParameters());

        $controller_class = app($controller_namespace);
        $appRouteMiddleware = app('\App\Http\Kernel')->getRouteMiddleware();
        $appMiddlewareGroups = app('\App\Http\Kernel')->getMiddlewareGroups();
        // $middlewareUsed = $this->getThroughControllerMiddleware($request,$controller_class,$method);
        $middlewareUsed = [];

        $actionString = $controller_namespace.'@'.$method;
        $route = \Route::getRoutes();
        $routeByAction = $route->getByAction($actionString);
        $routeInfo = [];

        if ($routeByAction) {
            $routeInfo = [
                'Http Method' => $routeByAction->methods,
                'uri' => $routeByAction->uri,
                'action' => $routeByAction->action,
                'route Name' => $routeByAction->getName(),
            ];

            $routeMiddlewares = $routeByAction->action['middleware'];
            $routeParam = $parameters->toArray();
            $url = action(str_replace('.', '\\', $controller[0]).'@index',[45,12]);
            $crequest = Request::create($url, $routeByAction->methods[0]);
            $response = app()->handle($crequest);
            // dd ($response->status());
            foreach ($routeMiddlewares as $routeMiddleware) {
                if (array_key_exists($routeMiddleware, $appRouteMiddleware)) {
                    $m = explode(':', $appRouteMiddleware[$routeMiddleware]);
                    $p = count($m) > 1 ? explode(',', $m[1]) : [];
                    resolve($m[0])->handle($request, function ($next) {
                        return $next;
                    }, ...$p);
                }

                if (array_key_exists($routeMiddleware, $appMiddlewareGroups)) {
                    $j = explode(':', $appMiddlewareGroups[$routeMiddleware][0]);
                    // dd(get_class($request),$request);
                    if (count($j) > 1 && $j[0]=='throttle') {
                        resolve($appRouteMiddleware[$j[0]])->handle($request, function ($next) {
                            
                            return app('\Symfony\Component\HttpFoundation\Response');
                        }, ...explode(',', $j[1]));
                    } else {
                        resolve($appRouteMiddleware['auth'])->handle($request, function ($next) {
                            return $next;
                        });
                    }
                }
            }
            // run method by route action calling
            // $routeParam = $parameters->toArray();
            // $url = action(str_replace('.', '\\', $controller[0]).'@index',$routeParam);
            // $request = Request::create($url, $routeByAction->methods[0]);
            // $response = app()->handle($request);
            // return ['response' => $this->getReturnData($response->getOriginalContent()), 'Database log' => DB::getQueryLog(), 'route' => $routeInfo, 'Controller middleware' => $route, 'Auth User' => $user];
        }

        if (request()->has('hadRequest')) {
            $this->setRequest($request);
            
            if ($request->has('dbpanel_custom_namespace')) {
                $customR = app($request->input('dbpanel_custom_namespace'));
                $data = $controller_class->$method($customR, ...$parameters);

                return ['response' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'route' => $routeInfo, 'Controller middleware' => $middlewareUsed, 'Auth User' => $user];
            }
            $data = $controller_class->$method($request, ...$parameters);

            return ['response' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'route' => $routeInfo, 'Controller middleware' => $middlewareUsed, 'Auth User' => $user];
        }
        $this->removeParameters($request);
        $data = $parameters ? $controller_class->$method(...$parameters) : $controller_class->$method();

        return ['response' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'route' => $routeInfo, 'Controller middleware' => $middlewareUsed, 'Auth User' => $user];
    }

    protected function getView($view)
    {
        return [
            'name' => $view->name(),
            'path' => str_replace('/', '\\', $view->getPath()),
            'with' => $view->getData(),
        ];
    }

    protected function getThroughControllerMiddleware($request, $controller_class, $method)
    {
        $middlewareUsed = [];
        $getThroughMiddlewares = collect($controller_class->middleware);
        $appRouteMiddleware = app('\App\Http\Kernel')->getRouteMiddleware();
        $appMiddlewareGroups = app('\App\Http\Kernel')->getMiddlewareGroups();

        if (! empty($getThroughMiddlewares)) {
            foreach ($getThroughMiddlewares as $getThroughMiddleware) {
                $middlewareArr = explode(':', $getThroughMiddleware['middleware']);
                $middlewareKey = $middlewareArr[0];

                if (count($middlewareArr) > 1) {
                    $middlewareParams = explode(',', $middlewareArr[1]);
                }
                $methods = array_key_exists('except', $getThroughMiddleware['options']) ? $getThroughMiddleware['options']['except'] : null;

                if (! $methods) {
                    $methods = array_key_exists('only', $getThroughMiddleware['options']) ? $getThroughMiddleware['options']['only'] : $getThroughMiddleware['options'];
                }
                $checkForMethodToBeMiddlewared = array_key_exists('except', $getThroughMiddleware['options']) ? ! in_array($method, $methods) : in_array($method, $methods);

                if ($checkForMethodToBeMiddlewared) {
                    $mClassNameSpace = $appRouteMiddleware[$middlewareKey];
                    $middlewareClass = resolve($mClassNameSpace);

                    if (count($middlewareArr) > 1) {
                        $middlewareClass->handle($request, function ($next) {
                            return $next;
                        }, ...$middlewareParams);
                    } else {
                        $middlewareClass->handle($request, function ($next) {
                            return $next;
                        });
                    }
                    $middlewareUsed[] = $middlewareKey;
                }
            }
        }

        return $middlewareUsed;
    }

    /**
     * @param mixed data
     * @return collection
     */

    protected function getReturnData($data)
    {
        if (gettype($data) == 'array') {
            return collect(['data' => $data, 'type' => 'array']);
        } 
        
        if (class_basename($data) == 'View') {
            return collect(['Blade' => $this->getView($data), 'type' => get_class($data)]);
        } 
        
        if (class_basename($data) == 'Response') {
            return collect(['data' => collect($data)->get('original'), 'type' => get_class($data)]);
        }
        
        if (class_basename($data) == 'JsonResponse') {
            return collect(['data' => collect($data)->get('original'), 'type' => get_class($data)]);
        } 
        
        if (gettype($data) == 'object') {
            return collect(['data' => $data, 'type' => get_class($data)]);
        }

        return collect(['data' => e($data), 'type' => 'HTML or string']);
    }

    public function checkModel(Request $request, $model)
    {
        $user = auth()->user();

        if (request()->has('dbpanel_auth_id')) {
            $user = $this->login();
            $request->request->remove('dbpanel_auth_id');
        }
        $parameters = $this->setParameters();

        DB::connection()->enableQueryLog();

        $model = explode('@', $model);
        $model_namespace = config('dbpanel.model').str_replace('.', '\\', $model[0]);
        $model_class = app($model_namespace);
        $method = $model[1];

        if (request()->has('hadRequest')) {
            $this->setRequest($request);
            $data = $model_class->$method($request, ...$parameters);

            return ['return' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'Auth User' => $user];
        }

        $this->removeParameters($request);
        $data = $parameters ? $model_class->$method(...$parameters) : $model_class->$method();

        return ['return' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'Auth User' => $user];
    }

    /**
     * check any method of any namespace.
     * 
     * @param Request $request
     * @param string $other
     * 
     * @return mixed
     */
    public function checkOther(Request $request, $other)
    {
        $user = auth()->user();

        if (request()->has('dbpanel_auth_id')) {
            $user = $this->login();
            $request->request->remove('dbpanel_auth_id');
        }

        $parameters = $this->setParameters();

        if (request()->has('hadRequest')) {
            $this->setRequest($request);
        }
        DB::connection()->enableQueryLog();

        if ($other == 'request@dd') {
            return $this->dd($request, $parameters);
        }
        $other = explode('@', trim($other));
        $other_namespace = config('dbpanel.other').str_replace('.', '\\', $other[0]);
        $method = $other[1];

        if (request()->has('hadRequest')) {
            $other_class = app($other_namespace);
            $data = $other_class->$method($request, ...$parameters);

            return ['return' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'Auth User' => $user];
        }
        $this->removeParameters($request);
        $other_class = app($other_namespace);
        $data = $parameters ? $other_class->$method(...$parameters) : $other_class->$method();

        return ['return' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'Auth User' => $user];
    }

    /**
     * run artisan command.
     * 
     * @param string $command
     * @return Artisan command output
     */

    public function run($command)
    {
        Artisan::call($command);

        return Artisan::output();
    }

    /**
     * log in with ID.
     * @return authinicate user
     */
    public function login()
    {
        $user = explode('@', request()->input('dbpanel_auth_id'));
        Auth::loginUsingId($user[0]);

        if (count($user) > 1) {
            $userCols = $user[1];
            $cols = explode(',', $userCols);

            return auth()->user()->only(...$cols);
        }

        return auth()->user();
    }

    /**
     * set Request.
     * 
     * @param request 
     * @return void
     * 
     */

    public function setRequest($request)
    {
        $r = trim(request('hadRequest'));
        $checkJson = strpos($r, '{') > -1 ? true : false;

        if ($checkJson) {
            $r = str_replace('|', '', $r);
            $arr = json_decode($r, true);
            $demo = '{"key":"value"}';
            $arr ? $request->merge($arr) : dd('your json is not in correct format', $demo, $r);
        } else {
            if (strlen($r) < 2) {
                $this->removeParameters($request);
                return;
            }
            $pairs =
             collect(explode('|', $r))->map(function ($i) {
                 $keyValue = explode('@', $i);

                 if (strpos($keyValue[1], ',') > -1) {
                     $c = collect(explode(',', $keyValue[1]))->map(function ($j) {
                         return is_numeric($j) ? (int) $j : $j;
                     });

                     return  [$keyValue[0] => $c];
                 }

                 return  [$keyValue[0] => is_numeric($keyValue[1]) ? (int) $keyValue[1] : $keyValue[1]];
             });

            foreach ($pairs as $pair) {
                foreach ($pair as $key => $value) {
                    $arr = [];
                    $keys = explode('.', $key);
                    data_set($arr, $key, $value);
                    $in = count($keys) > 0 ? $keys[0] : null;
                    $se = count($keys) > 1 ? $keys[1] : null;
                    $th = count($keys) > 2 ? $keys[2] : null;
                    $fo = count($keys) > 3 ? $keys[3] : null;

                    if (request()->has($in)) {
                        if (request()->has($in.'.'.$se)) {
                            if (request()->has($in.'.'.$se.'.'.$th)) {
                                if (request()->has($in.'.'.$se.'.'.$th.'.'.$fo)) {
                                    $a[$in][$se][$th][$fo] = array_merge($arr[$in][$se][$th][$fo], request()->input($in.'.'.$se.'.'.$th.'.'.$fo));
                                    $request->merge($a);
                                } else {
                                    $a[$in][$se][$th] = array_merge($arr[$in][$se][$th], request()->input($in.'.'.$se.'.'.$th));
                                    $request->merge($a);
                                }
                            } else {
                                $a[$in][$se] = array_merge($arr[$in][$se], request()->input($in.'.'.$se));
                                $request->merge($a);
                            }
                        } else {
                            $a[$in] = array_merge($arr[$in], request()->input($in));
                            $request->merge($a);
                        }
                    } else {
                        $request->merge($arr);
                    }
                }
            }
        }
        $this->parameters = $request->parameters;
        $this->removeParameters($request);
    }

    /**
     * set parameters for the class which need to called
     * 
     * @return mixed  Array|Collect
     */

    public function setParameters()
    {
        return ! empty(request()->input('parameters')) ?
            collect(explode('|', request('parameters')))->map(function ($i) {
                if (strpos($i, ',') > -1) {
                    return collect(explode(',', $i))->map(function ($j) {
                        return is_numeric($j) ? (int) $j : $j;
                    });
                } elseif (strpos($i, '\\') > -1) {
                    $c = explode(' ', $i);
                    $n = '\\'.$c[0];
                    $cl = new $n;

                    return count($c) > 1 ? $cl::find($c[1]) : $cl::first();
                } else {
                    return is_numeric($i) ? (int) $i : $i;
                }
            }) : [];
    }

    public function removeParameters($request){

        $request->request->remove('parameters');
        $request->request->remove('hadRequest');
    }
    /**
     * dump request object, parameters, authinticate user info on console of dbpanel application
     * 
     * @param Request  $request
     * @param array  $parameters
     * 
     * @return array
     */
    public function dd(Request $request, $parameters)
    {
        $user = $this->login();
        $this->removeParameters($request);

        return [
            'request' => $request->all(),
            'parameters' => $parameters ? $parameters : null,
            'Auth User' => $user,
        ];
    }

    public function openFile()
    {
        //check base_path is already in file path
        $file_path = strpos(request('file'), base_path()) !== false ? '"'.request('file').'"' : '"'.base_path().'/'.request('file').'"';
        exec('code --goto '.$file_path);
    }

    public function save(Request $request)
    {
        $request->merge(['controller_prefix_namespace'=>config('dbpanel.controller')]);
        $request->merge(['created_at'=>time()]);
        config()->push('dbpanel_collections.'.str_replace('\\','.',$request->input('controller')),$request->all());
        $fp = fopen(base_path() .'/config/dbpanel_collections.php' , 'w');
        $str = str_replace(')',']',str_replace('array (','[',var_export(config('dbpanel_collections'), true)));
        fwrite($fp, '<?php return ' . $str . ';');
        fclose($fp);
        return ['message'=>"saved",'collection'=> config('dbpanel_collections')];
    }

    public function load(Request $request){
        $i=$request->input('controller');
        $c = config('dbpanel_collections');

        return data_get($c,$i);
    }
}

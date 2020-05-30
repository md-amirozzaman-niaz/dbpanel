<?php

namespace Niaz\DBpanel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Niaz\DBpanel\Http\Filters\Filter;
use Illuminate\Support\Facades\Artisan;

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
        // $filtered_query = $filtered->query();

        $filtered_data = $filtered->getData();

        $count = ! is_string($filtered_data) ? count($filtered_data) : 'Error';

        return ['result' => $filtered_data, 'filter_status' => $filter->status(), 'request' => request()->all(), 'total' => $count];
    }

    public function checkController(Request $request, $controller)
    {
        $user = 'None';

        if (request()->has('dbpanel_auth_id')) {
            $user = $this->login();
            $request->request->remove('dbpanel_auth_id');
        }
        $parameters = $this->setParameters();

        DB::connection()->enableQueryLog();

        $controller = explode('@', $controller);
        $controller_namespace = config('dbpanel.controller').str_replace('.', '\\', $controller[0]);
        $controller_class = app($controller_namespace);
        $method = $controller[1];

        $middlewareUsed = [];
        $getThroughMiddlewares = collect($controller_class->middleware);
        $appRouteMiddleware = app('\App\Http\Kernel')->getRouteMiddleware();

        if (! empty($$getThroughMiddlewares)) {
            foreach ($getThroughMiddlewares as $getThroughMiddleware) {
                $middlewareArr = explode(':', $getThroughMiddleware['middleware']);
                $middlewareKey = $middlewareArr[0];
                $middlewareParams = explode(',', $middlewareArr[1]);
                $methods = $getThroughMiddleware['options']['only'];
                $mClassNameSpace = $appRouteMiddleware[$middlewareKey];
                $middlewareClass = resolve($mClassNameSpace);

                if (in_array($method, $methods)) {
                    $middlewareClass->handle($request, function ($next) {
                        return $next;
                    }, ...$middlewareParams);
                    $middlewareUsed[] = $middlewareKey;
                }
            }
        }
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
        }
        $routeMiddlewares = $routeByAction->action['middleware'];
        foreach ($routeMiddlewares as $routeMiddleware) {
            if ($routeMiddleware !== 'api' && $routeMiddleware !== 'web') {
                resolve($appRouteMiddleware[$routeMiddleware])->handle($request, function ($next) {
                    return $next;
                });
            }
        }

        if (request()->has('hadRequest')) {
            $this->setRequest($request);

            $data = $controller_class->$method($request, ...$parameters);

            return ['response' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'route' => $routeInfo, 'Controller middleware' => $middlewareUsed, 'Auth User' => $user];
        }
        $request->request->remove('parameters');
        $request->request->remove('hadRequest');
        $data = $parameters ? $controller_class->$method(...$parameters) : $controller_class->$method();

        return ['response' => $this->getReturnData($data), 'Database log' => DB::getQueryLog(), 'route' => $routeInfo, 'Controller middleware' => $route, 'Auth User' => $user];
    }

    protected function getView($view)
    {
        return [
            'name' => $view->name(),
            'path' => str_replace('/', '\\', $view->getPath()),
            'with' => $view->getData(),
        ];
    }

    protected function getReturnData($data)
    {
        if (gettype($data) == 'array') {
            return collect(['data' => $data, 'type' => 'array']);
        } elseif (class_basename($data) == 'View') {
            return collect(['Blade' => $this->getView($data), 'type' => get_class($data)]);
        } elseif (class_basename($data) == 'Response') {
            return collect(['data' => collect($data)->get('original'), 'type' => get_class($data)]);
        } elseif (class_basename($data) == 'JsonResponse') {
            return collect(['data' => collect($data)->get('original'), 'type' => get_class($data)]);
        } elseif (gettype($data) == 'object') {
            return collect(['data' => $data, 'type' => get_class($data)]);
        }

        return collect(['data' => $data, 'type' => 'string']);
    }

    public function checkModel(Request $request, $model)
    {
        $user = 'None';

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

            return ['return' => $this->getReturnData($data),'Database log' => DB::getQueryLog(), 'Auth User' => $user];
        }

        $request->request->remove('parameters');
        $request->request->remove('hadRequest');
        $data = $parameters ? $model_class->$method(...$parameters) : $model_class->$method();

        return ['return' => $this->getReturnData($data),'Database log' => DB::getQueryLog(), 'Auth User' => $user];
    }

    public function checkOther(Request $request, $other)
    {
        $user = 'None';

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
            return ['return' => $this->getReturnData($data),'Database log' => DB::getQueryLog(), 'Auth User' => $user];
        }
        $request->request->remove('dbpanel_auth_id');
        $request->request->remove('parameters');
        $request->request->remove('hadRequest');
        $other_class = app($other_namespace);
        $data = $parameters ? $other_class->$method(...$parameters) : $other_class->$method();

        return ['return' => $this->getReturnData($data),'Database log' => DB::getQueryLog(), 'Auth User' => $user];
    }

    public function run($command)
    {
        Artisan::call($command);

        return Artisan::output();
    }

    public function login()
    {
        $user = explode('@', request()->input('dbpanel_auth_id'));
        Auth::loginUsingId($user[0]);
        // request()->merge(['user'=>auth()->user()]);
        if (count($user) > 1) {
            $userCols = $user[1];
            $cols = explode(',', $userCols);

            return auth()->user()->only(...$cols);
        }

        return auth()->user();
    }

    public function setRequest($request)
    {
        $r = trim(request('hadRequest'));
        $checkJson = strpos($r, '{') >-1? true : false;

        if($checkJson){
            $r = str_replace('|','',$r);
            $arr = json_decode($r,true);
            $demo ='{"key":"value"}';
            $arr ? $request->merge($arr) : dd('your json is not in correct format',$demo,$r);
        }else{
            if(strlen($r) < 2) {
                $request->request->remove('parameters');
                $request->request->remove('hadRequest');
                return ;
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
        $request->request->remove('parameters');
        $request->request->remove('hadRequest');
    }

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

    public function dd(Request $request, $parameters)
    {
        $user = $this->login();
        $request->request->remove('parameters');
        $request->request->remove('dbpanel_auth_id');
        return [
            'request' => $request->all(),
            'parameters' => $parameters ? $parameters : null,
            'Auth User' => $user
        ];
    }

    public function openFile()
    {
        //check base_path is already in file path
        $file_path = strpos(request('file'), base_path()) !== false ? '"'.request('file').'"' : '"'.base_path().'/'.request('file').'"';
        exec('code --goto '.$file_path);
    }
}

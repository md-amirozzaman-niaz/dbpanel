<?php

namespace Niaz\DBpanel\Http\Controllers;

use Niaz\DBpanel\Http\Filters\Filter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class DBpanelController extends Controller
{
    //

    public function index(){
        $tables= DB::select('SHOW TABLES');
        return view('dbpanel::index')->with(['tables'=>$tables]);
            
    }

    public function data($table,$joinTable=null  ){
        $filter = new Filter;
        $filtered= $filter->loadTable($table);
        // $filtered_query = $filtered->query();
        
        
        $filtered_data = $filtered->getData();

        $count = !is_string($filtered_data) ? count($filtered_data) : 'Error';
        return ['result'=> $filtered_data , 'filter_status' => $filter->status(), 'request' => request()->all(),'total' => $count ];
    }

    public function checkController(Request $request,$controller){

        $parameters=$this->setParameters();
        
        DB::connection()->enableQueryLog();
        
        $controller = explode('@',$controller);
        $controller_namespace =config('dbpanel.controller').str_replace('.','\\',$controller[0]);
        $controller_class = app($controller_namespace);
        $method = $controller[1];

        if(request()->has('hadRequest') && strpos(request('hadRequest'),'@') > 0){
            $this->setRequest($request);
            
            $data = $controller_class->$method($request,...$parameters);
            
            return ['log'=> DB::getQueryLog(),'data'=>$data];
        }
        $request->request->remove('parameters');
        $request->request->remove('hadRequest');
        $data = $controller_class->$method(...$parameters);
        
        return ['log'=> DB::getQueryLog(),'data'=>$data];
    }

    public function checkModel(Request $request,$model){

        $parameters=$this->setParameters();

        DB::connection()->enableQueryLog();

        $model = explode('@',$model);
        $model_namespace =config('dbpanel.model').str_replace('.','\\',$model[0]);
        $model_class = app($model_namespace);
        $method = $model[1];

        if(request()->has('hadRequest') && strpos(request('hadRequest'),'@') > 0){
            $this->setRequest($request);
            $data = $model_class->$method($request,...$parameters);
            return ['log'=> DB::getQueryLog(),'data'=>$data];
        }

        $request->request->remove('parameters');
        $request->request->remove('hadRequest');
        $data = $model_class->$method(...$parameters);
        return ['log'=> DB::getQueryLog(),'data'=>$data];
    }

    public function checkOther(Request $request,$other){

        $parameters=$this->setParameters();

        DB::connection()->enableQueryLog();

        $other = explode('@',$other);
        $other_namespace =config('dbpanel.other').str_replace('.','\\',$other[0]);
        $other_class = app($other_namespace);
        $method = $other[1];

        if(request()->has('hadRequest') && strpos(request('hadRequest'),'@') > 0){
            $this->setRequest($request);
            $data = $other_class->$method($request,...$parameters);
            return ['log'=> DB::getQueryLog(),'data'=> $data];
        }
        $request->request->remove('parameters');
        $request->request->remove('hadRequest');
        $data = $other_class->$method(...$parameters);
        return ['log'=> DB::getQueryLog(),'data'=>$data];
    } 

    public function setRequest($request){
        $pairs =
             collect(explode(':',request('hadRequest')))->map(function($i){
                $keyValue = explode('@',$i);
                if(strpos($keyValue[1],',') > -1){
                    $c = collect(explode(',',$keyValue[1]))->map(function($j){
                        return is_numeric($j) ? (int)$j : $j;
                    });
                    return  [$keyValue[0]=>$c];
                }
                else{
                    return  [$keyValue[0]=>is_numeric($keyValue[1]) ? (int)$keyValue[1] : $keyValue[1]];
                }
            });
            foreach($pairs as $pair){
                $request->merge($pair);
            }
            $request->request->remove('parameters');
            $request->request->remove('hadRequest');
    }

    public function setParameters(){
        return collect(explode(':',request('parameters')))->map(function($i){
            if(strpos($i,',') > -1){
                return collect(explode(',',$i))->map(function($j){
                    return is_numeric($j) ? (int)$j : $j;
                });
            }
            else{
                return is_numeric($i) ? (int)$i : $i;
            }
        }); 
    }
}

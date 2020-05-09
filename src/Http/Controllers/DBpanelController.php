<?php

namespace Niaz\DBpanel\Http\Controllers;

use Niaz\DBpanel\Http\Filters\Filter;
use Illuminate\Support\Facades\DB;

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

    public function checkController($controller){

        $parameters= collect(explode(':',request('parameters')))->map(function($i){
            if(strpos($i,',') > -1){
                return collect(explode(',',$i))->map(function($j){
                    return is_numeric($j) ? (int)$j : $j;
                });
            }
            else{
                return is_numeric($i) ? (int)$i : $i;
            }
        });
        DB::connection()->enableQueryLog();
        $controller = explode('@',$controller);
        $controller_namespace =config('dbpanel.controller').'\\'.str_replace('.','\\',$controller[0]);
        $controller_class = new $controller_namespace;
        $method = $controller[1];
        
        $data = $controller_class->$method(...$parameters);
        return ['log'=> DB::getQueryLog(),'data'=>$data];
    }

    public function checkModel($model){

        $parameters= collect(explode(':',request('parameters')))->map(function($i){
            if(strpos($i,',') > -1){
                return collect(explode(',',$i))->map(function($j){
                    return is_numeric($j) ? (int)$j : $j;
                });
            }
            else{
                return is_numeric($i) ? (int)$i : $i;
            }
        });
        DB::connection()->enableQueryLog();
        $model = explode('@',$model);
        $model_namespace =config('dbpanel.model').'\\'.str_replace('.','\\',$model[0]);
        $model_class = new $model_namespace;
        $method = $model[1];
        
        $data = $model_class->$method(...$parameters);
        return ['log'=> DB::getQueryLog(),'data'=>$data];
    } 
}

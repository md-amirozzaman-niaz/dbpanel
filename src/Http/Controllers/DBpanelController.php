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

        DB::connection()->enableQueryLog();
        $controller = explode('@',$controller);
        $controller_namespace ='\\App\\Http\\Controllers\\'.str_replace('.','\\',$controller[0]);
        $controller_class = new $controller_namespace;
        $method = $controller[1];
        $parameter= request('parameters');
        $data = $controller_class->$method($parameter);
        return ['log'=> DB::getQueryLog(),'data'=>$data];
    }
}

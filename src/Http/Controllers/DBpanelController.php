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
}

<?php

namespace Niaz\DBpanel\Http\Filters;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class Filter
{
    protected $model;
    protected $status;
    protected $filter = false;
    protected $table;
    protected $database;
    protected $joinTable;

    public function loadTable($table=null){
        

            // $tableName = Str::plural($model);
            if($this->hasTable($table)){
                session(['filter_table'=>$table]);

                // $modelClass= Str::studly(Str::singular($tableName));
                // $modelNamespace = config('dbpanel.model').'\\'.$modelClass;
                $this->table=$table;
                $this->database = DB::table($table);
                $this->filter=true;
            }
        return $this;
    }

    public function query(){
        if($this->filter){
            $pipe = app(Pipeline::class);
            $query = $pipe->send($this->database)->through([
                \Niaz\DBpanel\Http\Filters\Type\Sort::class,
                \Niaz\DBpanel\Http\Filters\Type\Active::class,
                \Niaz\DBpanel\Http\Filters\Type\Lookup::class,
                \Niaz\DBpanel\Http\Filters\Type\Id::class,
                \Niaz\DBpanel\Http\Filters\Type\Date::class
                ])->thenReturn();
            $this->status =['filter' => session('filters'),'Columns' =>Schema::getColumnListing($this->table)];
                session()->forget('filters');
                session()->forget('status');

            return $query;
        }
    }

    public function status(){
        return $this->status;
    }

    public function getData(){
        if($this->filter){
            if(request()->has('per_page') && request()->has('return_col')){

                return $this->query()->paginate(request('per_page'), $this->checkReturnColumnExist());

            }else if(request()->has('per_page')){

                return $this->query()->paginate(request('per_page'));

            }else if(request()->has('return_col')){

                return $this->query()->get($this->checkReturnColumnExist());
                
            }else{

                return $this->query()->get();
            }
        }else{
            return 'Table Not found';
        }
    }

    protected function checkReturnColumnExist(){
        $return_col_arr = explode(',',request('return_col'));
        $qualify_col_arr = [];
        foreach($return_col_arr as $col){
            if(Schema::hasColumn(session('filter_table'),$col)) $qualify_col_arr[]=$col;
        }
        return $qualify_col_arr ? $qualify_col_arr : '*';
    }

    protected function hasTable($tableName){

        return Schema::hasTable($tableName);
        
    }

}
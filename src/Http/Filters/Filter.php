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
    protected $totalRows;
    protected $lastID;
    protected $indexes=[];
    protected $retrieveRows;

    public function loadTable($table=null){
        

            // $tableName = Str::plural($model);
            if($this->hasTable($table)){
                session(['filter_table'=>$table]);

                // $modelClass= Str::studly(Str::singular($table));
                // $modelNamespace = config('dbpanel.model').'\\'.$modelClass;
                // $model = new $modelNamespace;
                $indexes= Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($table);
                foreach($indexes as $indexType => $value){
                    $this->indexes[$indexType] = $value->getColumns();
                }
                // $this->keys $indexes[ 'primary' ]->getColumns()[0];
                $this->table=$table;
                $this->totalRows = DB::table($table)->get()->count();
                $this->lastID= $this->totalRows > 0 ? DB::table($table)->orderBy($indexes[ 'primary' ]->getColumns()[0],'desc')->first()->id : '';
                $this->database = DB::table($table);
                $this->filter=true;
            }
        return $this;
    }

    public function query(){
        if($this->filter){
            $pipe = app(Pipeline::class);
            $total_rows = $this->totalRows;
            $query = $pipe->send($this->database)->through([
                \Niaz\DBpanel\Http\Filters\Type\Sort::class,
                \Niaz\DBpanel\Http\Filters\Type\Is::class,
                \Niaz\DBpanel\Http\Filters\Type\Lookup::class,
                \Niaz\DBpanel\Http\Filters\Type\Id::class,
                \Niaz\DBpanel\Http\Filters\Type\Date::class,
                \Niaz\DBpanel\Http\Filters\Type\Where::class
                ])->thenReturn();
                $columnsWithType = [];
                $columns = Schema::getColumnListing($this->table);

                foreach($columns as $column){
                    $columnsWithType[$column] = Schema::getColumnType($this->table,$column);

                }
            $this->status =[
                'FilterUsed' => session('filters'),
                'TotalRows'=> $total_rows,
                'indexes'=>$this->indexes,
                'lastID'=>$this->lastID,
                'Columns' => $columnsWithType,
                'Connection' => class_basename($this->database->getConnection()),
                'Database' => $this->database->getConnection()->getDatabaseName(),
            ];
                session()->forget('filters');
                session()->forget('status');

            return $query;
        }
    }

    public function status(){
        $this->status['retrieveRows'] = $this->retrieveRows;
        return $this->status;
    }

    public function getData(){
        if($this->filter){
            $this->retrieveRows=count($this->query()->get());
            $this->status['retrieveRows'] = count($this->query()->get());
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
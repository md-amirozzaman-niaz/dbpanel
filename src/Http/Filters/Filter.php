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
    protected $columns;
    protected $database;
    protected $joinTable;
    protected $totalRows;
    protected $lastID;
    protected $indexes=[];
    protected $retrieveRows;
    protected $sql;
    protected $bindings;
    protected $query;

    /*
    * load table information 
    * set some property 
    *
    * @param string $table
    * @return $this
    *
    **/
    public function loadTable($table=null){       

            if($this->hasTable($table)){
                session(['filter_table'=>$table]);

                $indexes= Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($table);
                foreach($indexes as $indexType => $value){
                    $this->indexes[$indexType] = $value->getColumns();
                }

                $this->table=$table;
                $this->database = DB::table($table);
                if(array_key_exists('primary',$indexes)){ 
                    $primaryKey = $indexes[ 'primary' ]->getColumns()[0];
                    $reverseTable = DB::table($table)->orderBy($primaryKey,'desc');
                    $this->totalRows = $reverseTable->get()->count();
                    $this->lastID= $this->totalRows > 0 ? $reverseTable->first()->$primaryKey : '';
                }
                
                $columnsWithType = [];
                $columns = Schema::getColumnListing($this->table);

                foreach($columns as $column){
                    $this->columns[]=$column;
                    $columnsWithType[$column] = Schema::getColumnType($this->table,$column);

                }
                session(['filter_column'=>$this->columns]);

                $this->status =[
                    'Table' => $table,
                    'TotalRows'=> $this->totalRows,
                    'indexes'=>$this->indexes,
                    'lastID'=>$this->lastID,
                    'Columns' => $columnsWithType,
                    'Version' => $this->database->getConnection()->getPdo()->query('select version()')->fetchColumn(),
                    'Database' => $this->database->connection->getDoctrineConnection()->getParams(),
                    // 'Table' => collect($this->database->connection->getDoctrineConnection()->getSchemaManager()->listTableDetails($table)),
                ];
                $this->filter=true;
            }
        return $this;
    }
    /*
    * set filter
    * 
    * @param void
    * @return Query Builder
    *
    **/

    public function setQuery(){

        if($this->filter){

            $pipe = app(Pipeline::class);
            $query = $this->database;

            if($this->hasParam('join')){ 
                $query = $this->joinTable($query);
            }
            $query = $pipe->send($query)->through([
                \Niaz\DBpanel\Http\Filters\Type\Sort::class,
                \Niaz\DBpanel\Http\Filters\Type\Lookup::class,
                \Niaz\DBpanel\Http\Filters\Type\Id::class,
                \Niaz\DBpanel\Http\Filters\Type\Is::class,
                \Niaz\DBpanel\Http\Filters\Type\Date::class,
                \Niaz\DBpanel\Http\Filters\Type\Where::class
                ])->thenReturn();
       
            $this->query = $query->select(DB::raw($this->checkReturnColumnExist()));
        }
    }
    public function getQuery(){
        $this->setQuery();
        return $this->query;
    }
    /*
    * set some status 
    * 
    * @param void
    * @return status property
    *
    **/
    public function status(){
        $this->status['FilterUsed'] = session('filters');
        $this->status['retrieveRows'] = $this->retrieveRows;
        // $this->status['SQL']=$this->sql;
        // $this->status['Bindings']=$this->bindings;
        // $this->status['Log']=DB::getQueryLog();
        session()->forget('filters');
        session()->forget('status');
    
        return $this->status;
    }

    /*
    * set Query as requested as follows
    * get final SQL & Bindings which is used on query
    * 
    * @param void
    * @return paginate
    *
    **/
    public function getData(){

        $this->setQuery();
        // DB::connection()->enableQueryLog();
        $paginateData = $this->query->paginate($this->parameters('per_page'));

        $this->sql = $this->query->toSql();
        $this->bindings = $this->query->getBindings();
        
        $this->retrieveRows = $paginateData->total();

        return $paginateData;
     
    }

    /*
    * check for return columns are existing or have to made some alias
    *
    * @param void
    * @return array
    *
    **/

    protected function checkReturnColumnExist(){

        $qualify_col_arr = [];

        if($this->hasParam('join')){
            if($this->hasParam('return_only')){
                $return_only_arr = explode(',',$this->parameters('return_only'));
                foreach($return_only_arr as $col){       
                    $alias= str_replace('@',' as ',$col);
                    $qualify_col_arr[]=$alias;
                    
                }
                return $qualify_col_arr;
            }
            if($this->hasParam('return')){
                return str_replace('@',' as ',$this->parameters('return'));
                }
             return '*';
        }
        if($this->hasParam('return_only')){
            $return_only_arr =explode(',',$this->parameters('return_only'));
            foreach($return_only_arr as $col){
                $c = explode('@',$col) ? explode('@',$col)[0]:$col;
                if(in_array($c,$this->columns)) 
                {
                    $alias= str_replace('@',' as ',$col);
                    $qualify_col_arr[]=$alias;
                }
            }
            return $qualify_col_arr ? implode(',',$qualify_col_arr) : '*';
        }
        if($this->hasParam('return_except')){
            $return_except_arr = explode(',',$this->parameters('return_except'));
            foreach($return_except_arr as $col){
                if(in_array($col,$this->columns)) $qualify_col_arr[]=$col;
            }
            $qualify_col_arr=array_diff($this->columns,$qualify_col_arr);
            return implode(',',$qualify_col_arr);
        }
        if($this->hasParam('return')){
            return str_replace('@',' as ',$this->parameters('return'));
        }
        return '*';
    }

    /*
    * check table existing or not 
    * 
    * @param string $tableName
    * @return boolean
    *
    **/
    protected function hasTable($tableName){
        return Schema::hasTable($tableName);
        
    }

    protected function joinTable($query){
        $joinTables = explode(',',$this->parameters('join'));
        foreach($joinTables as $joinTable){
            $joinTableName = explode(':',$joinTable);
            $columns = Schema::getColumnListing($joinTableName[2]);
            foreach($columns as $column){
                $this->columns[]=$column;
                $columnsWithType[$column] = Schema::getColumnType($joinTableName[2],$column);

            }
            session(['filter_column'=>$this->columns]);
            $query->join($joinTableName[2], $joinTableName[0].'.'.$joinTableName[1], '=', $joinTableName[2].'.'.$joinTableName[3]);
            
        }
        return $query;
    }

    protected function parameters($param){
        return request($param);
    }

    protected function hasParam($param){
        return request()->has($param);
    }

}
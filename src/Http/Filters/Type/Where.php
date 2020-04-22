<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Where extends BaseFilter
{
    protected function applyFilter($builder){
        $columns = explode(',',request('where'));
        $values = explode(',',request('where_val'));
        $opKey = ['>','<','!','~'];
        $operator = ['>'=>'>','<' => '<','!' => '!=','~'=>'<>'];
        foreach($columns as $column){
        if ((request()->has('where') && !Schema::hasColumn(session('filter_table'), $column))) {
            session(['filters.'.$column=> $column.' is not exist!']);
            return $builder;
            }
        }
        for($i=0;$i< count($columns);$i++){
            $op = in_array(substr($values[$i],0,1),$opKey) ? $operator[substr($values[$i],0,1)] : '=';
            $searchString = in_array(substr($values[$i],0,1),$opKey) ? substr($values[$i],1) : $values[$i];
            session()->push('filters.where',[$columns[$i], $op,$searchString]);
            $builder->where($columns[$i], $op,$searchString);
        }

        return $builder;
    }
}
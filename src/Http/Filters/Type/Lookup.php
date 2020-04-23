<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Lookup extends BaseFilter
{
    protected function applyFilter($builder){
        $lookup = explode(':',request('lookup'));
        $column = $lookup [0];
        if ((request()->has('lookup') && !Schema::hasColumn(session('filter_table'), $column))) {
            session()->push('status.lookup', $column.' is not exist!');
            return $builder;
        }
        $st = $lookup[1];
        $op = strpos($st,'!') === 0 ? 'not like' : 'like';
        
        $searchString = strpos($st,'!') === 0 ? str_replace('!','',$st) : $st;
        
        $searchString = strpos($searchString,'$') === 0 ? substr_replace($searchString,'%',0,1) : $searchString;

        $searchString = strpos($searchString,'$') === strlen($searchString)-1 ? substr_replace($searchString,'%',-1,1) : $searchString;
        
        $searchString = strpos($searchString,'%') === 0 || strpos($searchString,'%') === strlen($searchString)-1 ? $searchString : "%".$searchString."%";
        session()->push('filters.lookup',[$column, $op,$searchString]);
           
        return $builder->where($column, $op,$searchString);
    }
}
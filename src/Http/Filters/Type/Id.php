<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;
class Id extends BaseFilter
{
    protected function applyFilter($builder){
        $range=explode('-',request($this->filterName()));
        $check = strpos(request($this->filterName()),'-')>-1 ? true:false;
        $method = $check ? 'whereBetween' : 'where';
        $constraint = $check ? $range  : request($this->filterName());
        
        
 
        if(!in_array('id',session('filter_column'))){
            session(['filters.id'=>['error' => 'there is no id column']]);
            return $builder;
        }
        $msg = $check ? ['from' => $range[0],'to'=>$range[1]] : ['is' => request($this->filterName())];
        session(['filters.id'=>[$msg]]);
        return $builder->$method('id', $constraint);
 
    }
}
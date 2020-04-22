<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;
class Id extends BaseFilter
{
    protected function applyFilter($builder){
        $range=explode('-',request($this->filterName()));
        $check = strpos(request($this->filterName()),'-');
        $method = $check>-1 ? 'whereBetween' : 'where';
        $constraint = $check>-1 ? $range  : request($this->filterName());
        session(['filters.id'=>request($this->filterName())]);

        //if table has 
        if(Schema::hasColumn(session('filter_table'),'id')){
            return $builder->$method('id', $constraint);
        }
        else{
            return $builder;
        }
    }
}
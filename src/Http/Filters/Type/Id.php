<?php
namespace App\Http\Filters\Type;

use App\Http\Filters\BaseFilter;

class Id extends BaseFilter
{
    protected function applyFilter($builder){
        $range=explode('-',request($this->filterName()));
        $check = strpos(request($this->filterName()),'-');
        $method = $check>-1 ? 'whereBetween' : 'where';
        $constraint = $check>-1 ? $range  : request($this->filterName());
        session()->push('filters',$this->filterName());
        return $builder->$method('id', $constraint);
    }
}
<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;

class Active extends BaseFilter
{
    protected function applyFilter($builder){
        session()->push('filters',$this->filterName());
        return $builder->where($this->filterName(), request($this->filterName()));
    }
}
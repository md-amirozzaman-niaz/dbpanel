<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;

class Is extends BaseFilter
{
    protected function applyFilter($builder){
        session()->push('filters.is',[request('is_col')=>request('is')]);
        return $builder->where(request('is_col'), request($this->filterName()));
    }
}
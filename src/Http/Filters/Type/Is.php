<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;

class Is extends BaseFilter
{
    protected function applyFilter($builder){
        $is=explode(':',request('is'));
        $column = $is[0];
        $value = $is[1] == 'null' ? null : $is[1];
        if (!in_array($column,session('filter_column'))) {
            session()->push('filters.is', ['error'=>$column.' not valid column']);
            return $builder;
        }
        session(['filters.is'=>[$column=>$value]]);
        return $builder->where($column, $value);
    }
}
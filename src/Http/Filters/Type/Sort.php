<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Sort extends BaseFilter
{
    protected function applyFilter($builder){
        $sort = explode(':',request('sort'));
        $column = count($sort)>1 ? $sort[0] : 'id';
        $order = count($sort)>1 ? $sort[1] : $sort[0] ;
        if (!in_array($column,session('filter_column'))) {
            session()->push('filters.sort', ['error' => $column.' is not exist']);
            return $builder;
        }
        $rule = 'orderBy('.$column.','.$order.')';
        session(['filters.sort'=>['column' => $column, 'order'=> $order]]);
        return $builder->orderBy($column, $order);
    }
}
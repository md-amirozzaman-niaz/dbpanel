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
        if ((request()->has('sort') && !Schema::hasColumn(session('filter_table'), $column))) {
            session()->push('status.sort', 'Task was not successful!');
            return $builder;
        }
        session(['filters.sort'=>[$column, $order]]);
        return $builder->orderBy($column, $order);
    }
}
<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Sort extends BaseFilter
{
    protected function applyFilter($builder){
        $column = request()->has('sort_column') ? request('sort_column') : 'id';

        if ((request()->has('sort_column') && !Schema::hasColumn(session('filter_table'), request('sort_column')))) {
            session()->push('status.sort', 'Task was not successful!');
            return $builder;
        }
        session()->push('filters',$this->filterName());
        return $builder->orderBy($column, request($this->filterName()));
    }
}
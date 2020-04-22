<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Sort extends BaseFilter
{
    protected function applyFilter($builder){
        $column = request()->has('sort_col') ? request('sort_col') : 'id';

        if ((request()->has('sort_col') && !Schema::hasColumn(session('filter_table'), request('sort_col')))) {
            session()->push('status.sort', 'Task was not successful!');
            return $builder;
        }
        session(['filters.sort'=>request('sort')]);
        return $builder->orderBy($column, request($this->filterName()));
    }
}
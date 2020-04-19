<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class Date extends BaseFilter
{
    protected function applyFilter($builder){
        
        if ((request()->has('date_column') && !Schema::hasColumn(session('filter_table'), request('date_column')))) {
            session()->flash('status.date', 'Task was not successful!');
            return $builder;
        }

        $method = request()->has('end_date') ? 'whereBetween' : 'whereDate';

        $column = request()->has('date_column') ? request('date_column') : 'created_at';

        $contraints = request()->has('end_date') ? [request($this->filterName()),request('end_date')] : request($this->filterName());
        session()->push('filters',$this->filterName());
        return $builder->$method($column, $contraints);
    }
}
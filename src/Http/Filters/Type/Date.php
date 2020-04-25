<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class Date extends BaseFilter
{
    protected function applyFilter($builder){
        $date = explode(':',request('date'));
        $column = $date[0];
        $startDate = $date[1];
        $endDate = count($date) > 2 ?$date[2] : null;
        
        if (!in_array($column,session('filter_column'))) {
            session()->flash('status.date', 'Task was not successful!');
            return $builder;
        }

        $method = count($date)>2 ? 'whereBetween' : 'whereDate';

        $contraints = count($date)>2 ? [$startDate,$endDate] : $startDate;
        session()->push('filters.date',[$column, $contraints]);
        return $builder->$method($column, $contraints);
    }
}
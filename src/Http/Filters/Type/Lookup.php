<?php
namespace App\Http\Filters\Type;

use App\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Lookup extends BaseFilter
{
    protected function applyFilter($builder){
        $column = request()->has('lookup_column') ? request('lookup_column') : 'title';
        if ((request()->has('lookup_column') && !Schema::hasColumn(session('filter_table'), request('lookup_column')))) {
            session()->push('status.lookup', request('lookup_column').' is not exist!');
            return $builder;
        }
        $op = strpos(request($this->filterName()),'!') === 0 ? 'not like' : 'like';
        $searchString = strpos(request($this->filterName()),'!') == 0 ? str_replace('!','',request($this->filterName())) : request($this->filterName());
        session()->push('filters',$this->filterName());
        return $builder->where($column, $op,$searchString);
    }
}
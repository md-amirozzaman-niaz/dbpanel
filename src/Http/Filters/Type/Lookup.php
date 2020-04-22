<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Lookup extends BaseFilter
{
    protected function applyFilter($builder){
        $column = request()->has('lookup_col') ? request('lookup_col') : 'title';
        if ((request()->has('lookup_col') && !Schema::hasColumn(session('filter_table'), request('lookup_col')))) {
            session()->push('status.lookup', request('lookup_col').' is not exist!');
            return $builder;
        }
        $op = strpos(request($this->filterName()),'!') === 0 ? 'not like' : 'like';
        $searchString = strpos(request($this->filterName()),'!') == 0 ? str_replace('!','',request($this->filterName())) : request($this->filterName());
        session()->push('filters',$this->filterName());
        return $builder->where($column, $op,$searchString);
    }
}
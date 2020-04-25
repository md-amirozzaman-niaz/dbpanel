<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Lookup extends BaseFilter
{
    protected function applyFilter($builder){
        $separator = strpos(request('lookup'),'|') > -1 ? '|': ',';
        $method = strpos(request('lookup'),'|') > -1 ? 'orWhere': 'where';
        $where = explode($separator,request('lookup'));
        $columns=[];
        $values = [];
        $methods = [];
        for($i=0;$i< count($where);$i++){

                $methods[] = $i > 0 ? $method : 'where';
                if(strpos($where[$i],',')>0){
                    $column = explode(',',$where[$i]);
                    for($j=0;$j<count($column);$j++){
                        if($j>0) $methods[] = 'where';
                        $columns[] = explode(':',$column[$j])[0];
                        $values[] = explode(':',$column[$j])[1];
                    }
                }else{
                    $columns[] = explode(':',$where[$i])[0];
                    $values[] = explode(':',$where[$i])[1];
                }
            
        }
        // session()->push('filters.methods',$methods);
        $opKey = ['!'];
        $operator = ['!'=> 'not like'];
        foreach($columns as $column){
        if (!in_array($column,session('filter_column'))) {
            session(['filters.lookup.error'=> $column.' is not exist!']);
            return $builder;
            }
        }
        for($i=0;$i< count($columns);$i++){
            $currentMethod = $methods[$i];
            $op = in_array(substr($values[$i],0,1),$opKey) ? $operator[substr($values[$i],0,1)] : 'like';
            $searchString = in_array(substr($values[$i],0,1),$opKey) ? substr($values[$i],1) : $values[$i];
            
            $searchString = strpos($searchString,'$') === 0 ? substr_replace($searchString,'%',0,1) : $searchString;

            $searchString = strpos($searchString,'$') === strlen($searchString)-1 ? substr_replace($searchString,'%',-1,1) : $searchString;
            
            $searchString = strpos($searchString,'%') === 0 || strpos($searchString,'%') === strlen($searchString)-1 ? $searchString : "%".$searchString."%";

            $rule = $currentMethod.'('.$columns[$i].','.$op.','.$searchString.')';
            session()->push('filters.lookup.rules',['method'=>$currentMethod,'column' =>$columns[$i],'oparator'=>$op,'value' => $searchString ]);
            $builder->$currentMethod($columns[$i], $op,$searchString);
        }

        return $builder;
    }
}
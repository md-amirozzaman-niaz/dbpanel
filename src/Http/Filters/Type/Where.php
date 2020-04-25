<?php
namespace Niaz\DBpanel\Http\Filters\Type;

use Niaz\DBpanel\Http\Filters\BaseFilter;
use Illuminate\Support\Facades\Schema;

class Where extends BaseFilter
{
    // protected $column;
    // public function __construct($columns){
    //     $this->columns=$columns;
    // }
    protected function applyFilter($builder){
        $separator = strpos(request('where'),'|') > -1 ? '|': ',';
        $method = strpos(request('where'),'|') > -1 ? 'orWhere': 'where';
        $where = explode($separator,request('where'));
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
        $opKey = ['>','<','!','~'];
        $operator = ['>'=>'>','<' => '<','!' => '!=','~'=>'<>'];
        foreach($columns as $column){
        if (!in_array($column,session('filter_column'))) {
            session(['filters.where.error'=> $column.' is not exist!']);
            return $builder;
            }
        }
        for($i=0;$i< count($columns);$i++){
            $currentMethod = $methods[$i];
            $op = in_array(substr($values[$i],0,1),$opKey) ? $operator[substr($values[$i],0,1)] : '=';
            $searchString = in_array(substr($values[$i],0,1),$opKey) ? substr($values[$i],1) : $values[$i];
            
            $rule = $currentMethod.'('.$columns[$i].','.$op.','.$searchString.')';
            session()->push('filters.where.rules',['method'=>$currentMethod,'column' =>$columns[$i],'oparator'=>$op,'value' => $searchString ]);
            $builder->$currentMethod($columns[$i], $op,$searchString);
        }

        return $builder;
    }
}
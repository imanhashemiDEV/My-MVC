<?php

namespace Core\Database\Traits;

use Core\Database\DBConnection\DBConnection;

trait HasQueryBuilder
{
    private $sql = '';
    private $where = [];
    private $orderBy = [];
    private $limit = [];
    private $values=[];
    private $bindingValues=[];

    // SELECT * FROM users WHERE ---- OrderBy --- ASC LIMIT 3

    protected function getSql(): string
    {
        return $this->sql;
    }

    protected function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

    protected function resetSql()
    {
        $this->sql = "";
    }

    protected function setWhere($operator , $condition)
    {
        $q=['operator'=>$operator, 'condition'=>$condition];
        array_push($this->where, $q);
    }

    protected function resetWhere(){
        $this->where=[];
    }

    protected function setOrderBy($key, $expression){
        array_push($this->orderBy, $key . ' ' . $expression);
    }

    protected function resetOrderBy(){
        $this->orderBy=[];
    }

    protected function setLimit($from , $number){
        $this->limit['from'] = (int) $from;
        $this->limit['number'] = (int) $number;
    }

     protected function resetLimit(){
         unset($this->limit['from']);
         unset($this->limit['number']);
     }

     protected function setValue($attribute, $value){
        $this->values[$attribute]=$value;
        array_push($this->bindingValues, $value);

     }

     protected function resetValues(){
         $this->values = [];
         $this->bindingValues=[];
     }

     protected function resetQuery(){
        $this->resetSql();
        $this->resetWhere();
        $this->resetValues();
        $this->resetLimit();
        $this->resetOrderBy();
     }



}
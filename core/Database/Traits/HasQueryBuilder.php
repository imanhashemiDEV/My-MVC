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

    protected function setLimit($offset , $number){
        $this->limit['offset'] = (int) $offset;
        $this->limit['number'] = (int) $number;
    }

     protected function resetLimit(){
         unset($this->limit['offset']);
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

     protected function executeQuery(){
        $query="";
        $query .= $this->sql;

        if(!empty($this->where)){

            // WHERE id=10 AND cat_id=12
            // WHERE id=10
            $whereQuery = "";
            foreach($this->where as $where){
                $whereQuery == "" ? $whereQuery .= $where['condition'] : $whereQuery .=' '. $where['operator']." ".$where['condition'];
            }

            $query .= " WHERE ". $whereQuery;

        }

        // ORDER BY id , DESC
        if(!empty($this->orderBy)){
            $query .= ' ORDER BY '. implode(', ',$this->orderBy);
        }

        // LIMIT 10 OFFSET 4
        if(!empty($this->limit)){
            $query .= ' LIMIT '.$this->limit['number'].' OFFSET '.$this->limit['offset'];
        }

        $query .=" ;";

        $pdoInstance = DBConnection::getDBConnectionInstance();
         $statement = $pdoInstance->prepare($query);

         // WHERE id>10 AND id=20 AND cat_id =2
        // $this->values = [id=>20 , cat_id=>2]
        // $this->bindingValues = [ 0=>11 ,1=>20, 2=>2 ]

         if(sizeof($this->bindingValues ) > sizeof($this->values)){
             sizeof($this->bindingValues) > 0 ? $statement->execute($this->bindingValues): $statement->execute();
         }else{
             sizeof($this->values) > 0 ? $statement->execute($this->values): $statement->execute();
         }

         return $statement;

     }



}
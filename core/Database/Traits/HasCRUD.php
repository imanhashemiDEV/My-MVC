<?php

// CRUD => create read update delete

namespace Core\Database\Traits;

use Core\Database\DBConnection\DBConnection;

trait HasCRUD{

    protected function setFillabels(){
        $fillables = [];
        foreach($this->fillable as $attribute){
            if(isset($this->$attribute)){
                array_push($fillables, $attribute." = ?");
                $this->setValue($attribute, $this->$attribute);
            }
        }

        return implode(', ' ,$fillables);
    }

    protected function insert(){
        $this->setSql("INSERT INTO {$this->table} SET ". $this->setFillables() . $this->createdAt."=Now();");
        $this->executeQuery();
        $this->resetQuery();
    }

    protected function update(){
        $this->setSql("INSERT INTO {$this->table} SET ". $this->setFillables() . $this->updatedAt."=Now();");
        $this->setWhere("AND " , $this->primaryKey." = ?");
        $this->setValue($this->primaryKey, $this->{$this->primaryKey});
        $this->executeQuery();
        $this->resetQuery();
    }


}
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
        // name age default
        // is_admin status
        $object = $this->find(DBConnection::newInsertedId());
        $defaultVariables = get_class_vars(get_called_class());
        $allVariables = get_object_vars($object);
         $differentVariables = array_diff(array_keys($allVariables),array_keys($defaultVariables));
         foreach ($differentVariables as $attribute){
             $this->$attribute = $object->$attribute;
         }
        $this->resetQuery();
         return $this;

    }

    protected function update(){
        $this->setSql("INSERT INTO {$this->table} SET ". $this->setFillables() . $this->updatedAt."=Now();");
        $this->setWhere("AND " , $this->primaryKey." = ?");
        $this->setValue($this->primaryKey, $this->{$this->primaryKey});
        $this->executeQuery();
        $this->resetQuery();
        return $this;
    }

    protected function find($id){
        $this->setSql("SELECT * FROM ".$this->table);
        $this->setWhere("AND" , $this->primaryKey . " = ? ");
        $this->setValue($this->primaryKey, $id);
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        if($data){
            return $this->setAttributes($data);
        }else{
            return null;
        }
    }

    protected function get(){
        $this->setSql(" SELECT * FROM " .$this->table);
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if($data){
            $this->setObject($data);
            return $this->collection;
        }else{
            return [];
        }
    }

    protected function delete($id){
        $object = $this;
        $this->resetQuery();
        if($id){
            $object = $this->find($id);
            $this->resetQuery();
        }
        $object->setSql("DELETE FROM ".$this->table);
        $object->setWhere("AND" , $this->primaryKey . " = ? ");
        $this->setValue($this->primaryKey, $object->{$object->primaryKey});
        return $object->executeQuery();
    }


}
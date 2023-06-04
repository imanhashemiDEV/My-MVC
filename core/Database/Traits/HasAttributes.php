<?php

namespace Core\Database\Traits;

trait  HasAttributes {

      protected function setAttributes(array $array , $object=null){

          // class User extends Model
          if(!$object){
              $class = get_called_class();
              $object= new $class;
          }

          foreach($array as $attribute => $value){
              $object->$attribute = $value;
          }

          return $object;

        }


}

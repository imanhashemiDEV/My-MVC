<?php

namespace Core\Router;

use ReflectionMethod;

class Router
{
  private $current_route;
  private $method_field;
  private $routes;
  private $params=[];

 public function __construct()
 {
     $this->current_route = explode('/', CURRENT_ROUT);
     global $routes;
     $this->routes = $routes;
     $this->method_field = $this->methodField();
 }

 public function methodField()
    {

        $method_filed = strtolower($_SERVER['REQUEST_METHOD']) ;

        if($method_filed == 'post'){
            if($_POST['method']=='put'){
                $method_filed ='put';
            }
            if($_POST['method']=='delete'){
                $method_filed ='delete';
            }
        }

        return $method_filed;

 }


}
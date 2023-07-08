<?php


use App\Models\User;

require_once "../config/app.php";
require_once "../config/database.php";

require_once "../routes/web.php";
require_once "../routes/api.php";

$user = new User();
$user->find(1)->update([
    'name'=>'iman',
    'email'=>"hashemi.iman@gmail.com",
]);



$router = new \Core\Router\Router();
$router->checkRoute();
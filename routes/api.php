<?php


use Core\Router\Api\Route;

Route::get('create_user',[\App\Http\Controller\UserControllerApi::class,'users']);
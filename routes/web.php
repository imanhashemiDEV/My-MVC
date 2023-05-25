<?php

use Core\Router\Web\Route;

   Route::get('/',[\App\Http\Controller\HomeController::class,'index']);

   Route::get('/users',[\App\Http\Controller\UserController::class,'index']);
   Route::get('/create_user',[\App\Http\Controller\UserController::class,'create']);
   Route::post('/store_user',[\App\Http\Controller\UserController::class,'store']);
   Route::get('/edit_user/{id}',[\App\Http\Controller\UserController::class,'edit']);
   Route::put('/update_user/{id}',[\App\Http\Controller\UserController::class,'update']);
   Route::delete('/destroy_user/{id}',[\App\Http\Controller\UserController::class,'destroy']);

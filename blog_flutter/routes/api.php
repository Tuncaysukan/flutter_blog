<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

 //Public Routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

//Protected Routes 

Route::group(['middleware'=>['auth:sanctum']],function(){
//user auth
Route::post('/logout',[AuthController::class,'logout']);
Route::get('/user',[AuthController::class,'user']);


});
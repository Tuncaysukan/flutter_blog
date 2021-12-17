<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

 //Public Routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

//Protected Routes 

Route::group(['middleware'=>['auth:sanctum']],function(){
//user auth
Route::post('/logout',[AuthController::class,'logout']);
Route::get('/user',[AuthController::class,'user']);

//Post

Route::get('/posts', [PostController::class,'index']);//All Post
Route::post('/posts', [PostController::class,'store']);//create  Post
Route::get('/posts/{id}', [PostController::class,'show']);//Get Single Post
Route::put('/posts/{id}', [PostController::class,'update']);//Update Post
Route::delete('/posts/{id}', [PostController::class,'destroy']);//Delete Post

//Comment

Route::get('/posts/{id}/commnet', [CommentController::class,'index']);//All Comment
Route::post('/posts/{id}/commnet', [CommentController::class,'store']);//Create Comment
// Route::get('/comment/{id}', [CommentController::class,'show']);//Get Single Post
Route::put('/comment/{id}', [CommentController::class,'update']);//Update Comment
Route::delete('/posts/{id}', [CommentController::class,'destroy']);//Delete Post


// like

Route::get('/posts/{id}/like', [LikeController::class,'index']);//All like

});
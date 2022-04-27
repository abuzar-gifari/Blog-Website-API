<?php

use App\Http\Controllers\Admin\CategoryController;
// use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\GetPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/admin')->group(function(){
    //categorys route
    Route::get('/categorys',[CategoryController::class,'index']);
    Route::post('/categorys',[CategoryController::class,'store']);
    Route::put('/categorys/{id}',[CategoryController::class,'edit']);
    Route::post('/categorys/{id}',[CategoryController::class,'update']);
    Route::delete('/categorys/{id}',[CategoryController::class,'delete']);
    Route::get('/categorys/{search}',[CategoryController::class,'search']);

    //posts route
    Route::get('/posts',[PostController::class,'index']);
    Route::post('/posts',[PostController::class,'store']);
    Route::put('/posts/{id}',[PostController::class,'edit']);
    Route::post('/posts/{id}',[PostController::class,'update']);
    Route::delete('/posts/{id}',[CategoryController::class,'delete']);
    Route::get('/posts/{search}',[CategoryController::class,'search']);

    // setting route
    Route::get('/settings',[SettingController::class,'index']);
    Route::post('/settings/{id}',[SettingController::class,'update']);
    
    // contact route
    Route::get('/contact',[\App\Http\Controllers\Admin\ContactController::class,'getContacts']);
    
    // subscriber routes
    Route::get('/subscribe',[\App\Http\Controllers\Admin\SubscribeController::class,'getSubs']);
    

});    

Route::prefix('/front')->group(function(){
    Route::get('/all-posts',[GetPostController::class,'index']);
    Route::get('/view-posts',[GetPostController::class,'viewposts']);
    Route::get('/single-posts/{id}',[GetPostController::class,'getPostById']);
    Route::get('/category-posts/{id}',[GetPostController::class,'getPostByCategory']);
    Route::get('/searchposts/{search}',[GetPostController::class,'searchPost']);
    Route::post('/contact',[ContactController::class,'store']);
    Route::post('/subscribe',[\App\Http\Controllers\Frontend\SubscribeController::class,'store']);
});

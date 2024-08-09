<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

});


Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AuthController::class)->group(function () {

        Route::post('/logout', 'logout');

    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::post('/users', 'store');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
    });
    
    


    Route::controller(PostController::class)->group(function () {
        Route::get('/posts', 'index');
        Route::get('/posts/{id}', 'show');
        Route::post('/posts', 'store');
        Route::put('/posts/{id}', 'update');
        Route::delete('/posts/{id}', 'destroy');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index');
        Route::get('/categories/{id}', 'show');
        Route::post('/categories', 'store');
        Route::put('/categories/{id}', 'update');
        Route::delete('/categories/{id}', 'destroy');
    });
    Route::controller(CommentController::class)->group(function () {
        Route::get('/comments', 'index');
        Route::get('/comments/{id}', 'show');
        Route::post('/comments', 'store');
        Route::put('/comments/{id}', 'update');
        Route::delete('/comments/{id}', 'destroy');
    });

    Route::controller(LikesController::class)->group(function () {
        Route::get('/likes', 'index');
        Route::get('/likes/{id}', 'show');
        Route::post('/likes', 'store');
        Route::delete('/likes/{id}', 'destroy');
    });

});




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

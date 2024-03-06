<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Car\PostController;
use App\Http\Controllers\Car\CommentController;
use App\Http\Controllers\Car\LikeController;




Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::post('login', [AuthenticationController::class, 'login'])->name('login');


Route::middleware('auth:api')->group(function () {

    Route::get('profile', [AuthenticationController::class, 'Profile'])->name('profile');
   
    Route::post('refresh', [AuthenticationController::class, 'refresh'])->name('refresh');

    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::apiResource('posts', PostController::class);
    
    Route::post('image', [PostController::class, 'uploadImage'])->name('image');
    Route::get('post/{id}/comments', [PostController::class, 'getComments'])->name('comments');
    Route::get('post/{id}/likes', [PostController::class, 'getLikes'])->name('likes');
 
    Route::apiResource('comments', CommentController::class);

    Route::apiResource('likes', LikeController::class);

});

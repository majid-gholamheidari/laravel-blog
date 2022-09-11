<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

######################### Authentication Routes Start Here
Route::prefix('auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\AuthenticationController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\AuthenticationController::class, 'register']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthenticationController::class, 'logout'])->middleware('auth:api');
});
######################### Authentication Routes End Here

######################### Categories Routes Start Here
Route::prefix('categories')->middleware('auth:api')->group(function () {
    Route::get('/show/{category}', [\App\Http\Controllers\Api\CategoryController::class, 'show']);
    Route::get('/{category}/posts/', [\App\Http\Controllers\Api\CategoryController::class, 'posts']);
    Route::post('/store', [\App\Http\Controllers\Api\CategoryController::class, 'store']);
    Route::post('/update/{category}', [\App\Http\Controllers\Api\CategoryController::class, 'update']);
    Route::post('/delete/{category}', [\App\Http\Controllers\Api\CategoryController::class, 'delete']);
});
######################### Categories Routes End Here

######################### Categories Routes Start Here
Route::prefix('posts')->middleware('auth:api')->group(function () {
    Route::get('/show/{post}', [\App\Http\Controllers\Api\PostController::class, 'show']);
    Route::get('/{post}/likes', [\App\Http\Controllers\Api\PostController::class, 'likes']);
    Route::get('/{post}/comments', [\App\Http\Controllers\Api\PostController::class, 'comments']);
    Route::post('/store', [\App\Http\Controllers\Api\PostController::class, 'store']);
    Route::post('/update/{post}', [\App\Http\Controllers\Api\PostController::class, 'update']);
    Route::post('/delete/{post}', [\App\Http\Controllers\Api\PostController::class, 'delete']);
});
######################### Categories Routes End Here

######################### Likes Routes Start Here
Route::prefix('likes')->middleware('auth:api')->group(function () {
    Route::post('/like/post/{post}', [\App\Http\Controllers\Api\LikeController::class, 'likePost']);
    Route::post('/dislike/post/{post}', [\App\Http\Controllers\Api\LikeController::class, 'dislikePost']);
    Route::post('/like/comment/{comment}', [\App\Http\Controllers\Api\LikeController::class, 'likeComment']);
    Route::post('/dislike/comment/{comment}', [\App\Http\Controllers\Api\LikeController::class, 'dislikeComment']);
});
######################### Likes Routes End Here

######################### Comments Routes Start Here
Route::prefix('comments')->group(function () {
    Route::post('/store/{post}', [\App\Http\Controllers\Api\CommentController::class, 'store']);
});
######################### Comments Routes End Here

<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/signin', [AuthController::class, 'login']);

Route::group(['middleware' => ['jwt.auth'], 'prefix' => 'auth'], function ($router) {
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('refresh', [AuthController::class, 'refresh']);
  Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'jwt.auth'], function () {

  Route::group(['middleware' => 'role:admin'], function () {
    Route::get('users', [UserController::class, 'all']);
    Route::Apiresource('categories', CategoryController::class);
    Route::put('users/{id}/bloc-or-unbloc', [UserController::class, 'blockOrUnblock']);
  });
  Route::group(['middleware' => 'role:publisher'], function () {
    Route::put('posts/{id}/publish-or-unpublish', [PostController::class, 'publishOrUnPublish']);
  });
  Route::get('categories', [CategoryController::class, 'index']);
  Route::Apiresource('posts', PostController::class);
});

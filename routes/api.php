<?php


use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Social\PostController;
use App\Http\Controllers\Social\CommentController;
use App\Http\Controllers\Social\UserController;
use Illuminate\Http\Request;
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




Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::get('/logout', [ApiAuthController::class, 'logout'])->middleware('api.auth');



Route::post('/post/create', [PostController::class, 'create'])->middleware('api.auth');
Route::get('/posts', [PostController::class, 'index'])->middleware('api.auth');
Route::get('/posts/{id}', [PostController::class, 'getPostsFromUser']);
Route::post('/post/{id}/update', [PostController::class, 'update'])->middleware('api.auth');
Route::DELETE('/post/{id}/delete', [PostController::class, 'delete'])->middleware('api.auth');


Route::post('/user/{id}/update', [UserController::class, 'update'])->middleware('api.auth');
Route::post('/user/{id}/changePassword', [UserController::class, 'changePassword'])->middleware('api.auth');

Route::get('search/{name}', [UserController::class, 'search'])->middleware('api.auth');



Route::post('/{id}/comment', [CommentController::class, 'create'])->middleware('api.auth');
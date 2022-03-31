<?php

use App\Http\Controllers\TweetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);
Route::post('/users/create', [UserController::class, 'register']);
Route::get('/users/{id}',[UserController::class, 'show']);
Route::post('/users/{id}',[UserController::class, 'update']);
Route::delete('/users/{id}',[UserController::class, 'destroy']);



Route::get('/tweets', [TweetController::class, 'index']);
Route::post('/tweets/create', [TweetController::class, 'store']);
Route::get('/tweets/{id}',[TweetController::class, 'show']);
Route::get('/tweets/user/{u_id}',[TweetController::class, 'showByUser'])->name('tweets.showByUser');
Route::post('/tweets/{id}',[TweetController::class, 'update']);
Route::delete('/tweets/{id}',[TweetController::class, 'destroy']);

Route::get('/tweets/data/{t_id}', [TweetController::class, 'userWithtweet']);

Route::get('/followingtweet/{u_id}', [TweetController::class, 'followingsTweet']);


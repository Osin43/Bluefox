<?php

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

Route::get('/signup', [App\Http\Controllers\UserController::class, 'create']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/about', [App\Http\Controllers\SettingController::class, 'create']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show']);
    Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
   
});
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::put('/about/{id}/update', [App\Http\Controllers\SettingController::class, 'update']);

    Route::get('/about/show', [App\Http\Controllers\SettingController::class, 'index']);
    Route::get('/about/{id}', [App\Http\Controllers\SettingController::class, 'show']);
    Route::delete('/about/{id}/delete', [App\Http\Controllers\SettingController::class, 'destroy']);

 });
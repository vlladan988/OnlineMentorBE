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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/resetPassword', 'App\Http\Controllers\AuthController@resetPassword');
Route::post('/me', 'App\Http\Controllers\AuthController@me')->middleware('checkToken');

Route::put('/trainers/{id}', 'App\Http\Controllers\TrainerController@update');

Route::get('/clients', 'App\Http\Controllers\ClientController@index');
Route::get('/clients/{id}', 'App\Http\Controllers\ClientController@show');
Route::post('/clients', 'App\Http\Controllers\ClientController@store');
Route::put('/clients/{id}', 'App\Http\Controllers\ClientController@update');
Route::delete('/clients/{id}', 'App\Http\Controllers\ClientController@destroy');


Route::get('/goals/{id}', 'App\Http\Controllers\GoalController@show');
Route::put('/goals/{id}', 'App\Http\Controllers\GoalController@update');

Route::get('/galleries/{id}', 'App\Http\Controllers\GalleryController@show');
Route::post('/galleries', 'App\Http\Controllers\GalleryController@store');
Route::delete('/galleries/{id}', 'App\Http\Controllers\GalleryController@destroy');




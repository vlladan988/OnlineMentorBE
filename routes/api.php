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

Route::get('/client', 'App\Http\Controllers\ClientController@index');
Route::put('/client', 'App\Http\Controllers\ClientController@update');
Route::post('/client/gallery', 'App\Http\Controllers\ClientController@storeGallery');

Route::get('/goal', 'App\Http\Controllers\GoalController@index');
Route::put('/goal', 'App\Http\Controllers\GoalController@update');

Route::get('/gallery', 'App\Http\Controllers\GalleryController@edit');
Route::post('/gallery', 'App\Http\Controllers\GalleryController@store');




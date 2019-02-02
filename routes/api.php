<?php

use Illuminate\Http\Request;

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

Route::prefix('users')->name("users.")->group(function () {
    Route::post('/save', 'UserController@api_save')->name('save');
    Route::post('/update', 'UserController@api_update')->name('update');
    Route::get('/all', 'UserController@api_all')->name('save');
});
<?php

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

Route::group(['namespace' => '\Api'], function() {
    Route::get('users', ['uses' => 'UsersController@index', 'as' => 'users.index']);
    Route::get('users/{id}', ['uses' => 'UsersController@show', 'as' => 'users.show']);
    Route::post('users', ['uses' => 'UsersController@store', 'as' => 'users.store']);
    Route::put('users/{id}', ['uses' => 'UsersController@update', 'as' => 'users.update']);
    Route::delete('users/{id}', ['uses' => 'UsersController@destroy', 'as' => 'users.destroy']);
});

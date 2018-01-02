<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
Route::get('/user-manage/users', ['uses' => 'UsersController@home', 'as' => 'users']);
Route::get('/user-manage/users/create', ['uses' => 'UsersController@create', 'as' => 'users.create']);

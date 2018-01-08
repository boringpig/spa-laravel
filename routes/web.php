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

Route::group(['prefix' => 'user-manage'], function() {
    Route::post('users/change-password/{id}', ['uses' => 'UsersController@changePassword','as' => 'users.change-password']);
    Route::get('users/search', ['uses' => 'UsersController@search','as' => 'users.search']);
    Route::resource('users', 'UsersController');
    Route::get('roles/search', ['uses' => 'RolesController@search','as' => 'roles.search']);
    Route::resource('roles', 'RolesController');
});

Route::group(['prefix' => 'article-manage'], function() {
    Route::get('articles/search', ['uses' => 'ArticlesController@search','as' => 'articles.search']);
    Route::resource('articles', 'ArticlesController');
});

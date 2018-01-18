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

Route::group(['prefix' => 'advertisement-manage'], function() {
    Route::post('advertisements/change-file/{id}', ['uses' => 'AdvertisementsController@changeFile','as' => 'advertisements.change-file']);
    Route::post('advertisements/change-status/{id}', ['uses' => 'AdvertisementsController@changeStatus','as' => 'advertisements.change-status']);
    Route::get('advertisements/search', ['uses' => 'AdvertisementsController@search','as' => 'advertisements.search']);
    Route::resource('advertisements', 'AdvertisementsController');
});

Route::group(['prefix' => 'kiosk-manage'], function() {
    Route::get('kiosks/search', ['uses' => 'KiosksController@search','as' => 'kiosks.search']);
    Route::post('kiosks/control-light/{station}', ['uses' => 'KiosksController@controlLight', 'as' => 'kiosks.control-light']);
    Route::post('kiosks/control-fan/{station}', ['uses' => 'KiosksController@controlFan', 'as' => 'kiosks.control-fan']);
    Route::post('kiosks/control-power/{station}', ['uses' => 'KiosksController@controlPower', 'as' => 'kiosks.control-power']);
    Route::resource('kiosks', 'KiosksController')->only(['index','edit','update']);
});
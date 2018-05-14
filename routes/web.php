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

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');

// Route::get('/login', 'Auth\LoginController@showLoginForm');
// Route::post('/login', ['uses' => 'Auth\LoginController@login', 'as' => 'auth.login']);
// Route::post('/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'auth.logout']);

// Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
// Route::get('/send-email', 'HomeController@sendEmail');
// Route::get('/notifications', 'PersonController@notifications');
// Route::get('/notification/readAll', 'PersonController@markAsReadAll');
// Route::get('/notification/deleteAll', 'PersonController@deleteAll');
// Route::get('/notification/{id}/read', 'PersonController@markAsRead');
// Route::get('/notification/{id}/delete', 'PersonController@delete');
// Route::get('/person/{id}/edit', 'PersonController@edit');
// Route::patch('/person/{id}', 'PersonController@update');

// Route::group(['prefix' => 'user-manage'], function() {
//     Route::post('users/change-password/{id}', ['uses' => 'UsersController@changePassword','as' => 'users.change-password']);
//     Route::get('users/search', ['uses' => 'UsersController@search','as' => 'users.search']);
//     Route::resource('users', 'UsersController');
//     Route::get('roles/search', ['uses' => 'RolesController@search','as' => 'roles.search']);
//     Route::resource('roles', 'RolesController');
// });

// Route::group(['prefix' => 'article-manage'], function() {
//     Route::get('articles/search', ['uses' => 'ArticlesController@search','as' => 'articles.search']);
//     Route::resource('articles', 'ArticlesController');
//     Route::resource('categories', 'CategoriesController');
// }); 

// Route::group(['prefix' => 'advertisement-manage'], function() {
//     Route::post('advertisements/change-file/{id}', ['uses' => 'AdvertisementsController@changeFile','as' => 'advertisements.change-file']);
//     Route::post('advertisements/change-status/{id}', ['uses' => 'AdvertisementsController@changeStatus','as' => 'advertisements.change-status']);
//     Route::get('advertisements/search', ['uses' => 'AdvertisementsController@search','as' => 'advertisements.search']);
//     Route::resource('advertisements', 'AdvertisementsController');
// });

// Route::group(['prefix' => 'kiosk-manage'], function() {
//     Route::get('kiosks/search', ['uses' => 'KiosksController@search','as' => 'kiosks.search']);
//     Route::get('kiosks/export', ['uses' => 'KiosksController@export','as' => 'kiosks.export']);
//     Route::post('kiosks/control-light/{station}', ['uses' => 'KiosksController@controlLight', 'as' => 'kiosks.control-light']);
//     Route::post('kiosks/control-fan/{station}', ['uses' => 'KiosksController@controlFan', 'as' => 'kiosks.control-fan']);
//     Route::post('kiosks/control-power/{station}', ['uses' => 'KiosksController@controlPower', 'as' => 'kiosks.control-power']);
//     Route::get('kiosks/calculate-station', ['uses' => 'KiosksController@calculateStation', 'as' => 'kiosks.calculate-station']);
//     Route::resource('kiosks', 'KiosksController')->only(['index','edit','update']);
//     Route::resource('areagroups', 'AreaGroupsController')->except(['create','store']);
// });

// Route::group(['prefix' => 'setting-manage'], function() {
//     Route::get('settings', ['uses' => 'SettingController@index', 'as' => 'settings.index']);
//     Route::post('settings', ['uses' => 'SettingController@store', 'as' => 'settings.store']);
//     Route::get('actionlogs/search', ['uses' => 'ActionlogsController@search', 'as' => 'actionlogs.search']);
//     Route::get('actionlogs', ['uses' => 'ActionlogsController@index', 'as' => 'actionlogs.index']);
//     Route::get('schedules', ['uses' => 'SchedulesController@index', 'as' => 'schedules.index']);
// });

// // 下拉式選單用
// Route::get('dropdown/scitys', 'SCitysController@dropdown');
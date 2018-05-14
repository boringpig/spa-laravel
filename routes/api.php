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

use Illuminate\Http\Request;

// Route::post('setting/customer', 'SettingController@getCustomerData');
// Route::post('setting/kiosk', 'SettingController@getKioskFreetime');
// Route::post('advertisements', 'AdvertisementsController@index');
// Route::post('articles', 'ArticlesController@index');
// Route::post('kiosks/areagroup', 'AreaGroupsController@index');

Route::post('login', 'Auth\LoginController@login');
Route::post('register', 'Auth\RegisterController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('/user', function (Request $request) {
        // return $request->user()->getJWTCustomClaims();
        // return auth()->payload();
        return $request->user();
    });
});


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
        return response()->json($request->user());
    });

    // 使用者管理(users,roles)
    Route::group(['prefix' => 'user-manage'], function() {
        // Route::post('users/change-password/{id}', ['uses' => 'UsersController@changePassword','as' => 'users.change-password']);
        // Route::get('users/search', ['uses' => 'UsersController@search','as' => 'users.search']);
        Route::resource('users', 'UsersController');
        // Route::get('roles/search', ['uses' => 'RolesController@search','as' => 'roles.search']);
        Route::resource('roles', 'RolesController');
    });
});


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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserController@login');
Route::post('logout/{id}','API\UserController@logout');
//clears
Route::get('loginform','API\ClearsController@showLoginForm');
Route::post('login-clears','API\ClearsController@login')->name('c-login');
Route::post('save-clears','API\ClearsController@save');
Route::post('logout-clears','API\ClearsController@logout');
Route::post('show-clears','API\ClearsController@show');
Route::post('delete-clears','API\ClearsController@delete');

Route::group(['middleware' => 'auth:api'], function() {
    
    Route::post('user-info', 'API\UserController@getUserInfo');
    Route::post('get-queue-sms', 'API\GsmModuleController@getQueueSMS');
    Route::post('dispose-sent-msgs', 'API\GsmModuleController@disposeSentJsonFile');
    Route::post('store-sent-msgs', 'API\GsmModuleController@storeSentMessages');
});
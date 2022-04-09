<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: form-data; charset=UTF-8");
header('Access-Control-Max-Age: 1000');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1.2','namespace'=>'App\Http\Controllers\Api\v2'], function () {
    Route::get('user/{id}/ad', 'UserController@user_ads');
    Route::get('ad', 'AdController@index');
    Route::get('test-fcm', 'UserController@testFcm');
    Route::get('execute', 'AdController@execute');
    Route::get('get-mov-videos', 'AdController@getMovVideos');
    Route::get('get-used-images', 'AdController@getUsedImages');
    Route::get('get-used-videos', 'AdController@getUsedVideos');
});
Route::group(['prefix' => 'v1','namespace'=>'App\Http\Controllers\Api'], function () {
    Route::get('user/{id}', 'UserController@show');
    Route::get('user/{id}/ad', 'UserController@user_ads');
    Route::post('user', 'UserController@store');
    Route::post('user-details', 'UserController@store_details');
    Route::post('user/login', 'UserController@login');
    Route::post('user/logout', 'UserController@logout');
    Route::post('user/reset_password', 'UserController@reset_password');
    Route::post('user/resend_code', 'UserController@resend_code');
    Route::post('user/active', 'UserController@active');
    Route::post('user/resetPassword', 'UserController@resetPassword');
    Route::post('user/update_password','UserController@update_password');
    Route::post('user/{id}', 'UserController@update');
    Route::get('district', 'CityController@districts');
    Route::get('district/{id}/city', 'CityController@cities');
    Route::resource('city', 'CityController');
    Route::resource('category', 'CategoryController');

    Route::post('/upload_files', 'AdController@upload_multi_files');

    Route::get('ad', 'AdController@index');
    Route::post('ad', 'AdController@store');
    Route::get('ad/{id}', 'AdController@show');
    Route::post('ad/{id}', 'AdController@update');
    Route::delete('ad/{id}', 'AdController@destroy');
    Route::get('slider', 'AdController@slider');
    Route::post('comment', 'AdController@add_comment');
    Route::delete('/comment/{id}', 'AdController@delete_comment');
    Route::post('rate', 'AdController@rate');
    Route::get('reason', 'ContactController@reasons');
    Route::post('contact', 'ContactController@store');

    Route::post('send_message', 'ChatController@store');
    Route::get('chat_contacts', 'ChatController@rooms');
    Route::get('chat_messages/{id}', 'ChatController@chat_messages');
    Route::delete('chat_contacts/{room}', 'ChatController@delete_room');

    Route::get('bank', 'BankController@index');
    Route::resource('article', 'ArticleController');
    Route::get('notification', 'NotificationController@index');
    Route::get('notification/{id}', 'NotificationController@show');
    Route::delete('notification/{id}', 'NotificationController@destroy');
    Route::post('favourite', 'AdController@add_favourite');
    Route::post('report', 'AdController@add_report');
    Route::get('favourite', 'AdController@get_favourite');
    Route::get('setting', 'SettingsController@index');
    Route::get('page/{name}', 'SettingsController@page');
});

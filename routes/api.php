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


Route::group(['prefix' => 'v1.2'], function () {
    Route::get('user/{id}/ad', 'Api\v2\UserController@user_ads');
    Route::get('ad', 'Api\v2\AdController@index');


    Route::get('test-fcm', 'Api\v2\UserController@testFcm');
    Route::get('execute', 'Api\v2\AdController@execute');
    Route::get('get-mov-videos', 'Api\v2\AdController@getMovVideos');
    Route::get('get-used-images', 'Api\v2\AdController@getUsedImages');
    Route::get('get-used-videos', 'Api\v2\AdController@getUsedVideos');



});
Route::group(['prefix' => 'v1'], function () {
    Route::get('user/{id}', 'Api\UserController@show');
    Route::get('user/{id}/ad', 'Api\UserController@user_ads');
    Route::post('user', 'Api\UserController@store');
    Route::post('user-details', 'Api\UserController@store_details');
    Route::post('user/login', 'Api\UserController@login');
    Route::post('user/logout', 'Api\UserController@logout');
    Route::post('user/reset_password', 'Api\UserController@reset_password');
    Route::post('user/resend_code', 'Api\UserController@resend_code');
    Route::post('user/active', 'Api\UserController@active');
    Route::post('user/resetPassword', 'Api\UserController@resetPassword');
    Route::post('user/update_password','Api\UserController@update_password');
    Route::post('user/{id}', 'Api\UserController@update');
    Route::get('district', 'Api\CityController@districts');
    Route::get('district/{id}/city', 'Api\CityController@cities');
    Route::resource('city', 'Api\CityController');
    Route::resource('category', 'Api\CategoryController');

    Route::post('/upload_files', 'Api\AdController@upload_multi_files');

    Route::get('ad', 'Api\AdController@index');
    Route::post('ad', 'Api\AdController@store');
    Route::get('ad/{id}', 'Api\AdController@show');
    Route::post('ad/{id}', 'Api\AdController@update');
    Route::delete('ad/{id}', 'Api\AdController@destroy');
    Route::get('slider', 'Api\AdController@slider');
    Route::post('comment', 'Api\AdController@add_comment');
    Route::delete('/comment/{id}', 'Api\AdController@delete_comment');
    Route::post('rate', 'Api\AdController@rate');
    Route::get('reason', 'Api\ContactController@reasons');
    Route::post('contact', 'Api\ContactController@store');

    Route::post('send_message', 'Api\ChatController@store');
    Route::get('chat_contacts', 'Api\ChatController@rooms');
    Route::get('chat_messages/{id}', 'Api\ChatController@chat_messages');
    Route::delete('chat_contacts/{room}', 'Api\ChatController@delete_room');

    Route::get('bank', 'Api\BankController@index');
    Route::resource('article', 'Api\ArticleController');
    Route::get('notification', 'Api\NotificationController@index');
    Route::get('notification/{id}', 'Api\NotificationController@show');
    Route::delete('notification/{id}', 'Api\NotificationController@destroy');
    Route::post('favourite', 'Api\AdController@add_favourite');
    Route::post('report', 'Api\AdController@add_report');
    Route::get('favourite', 'Api\AdController@get_favourite');
    Route::get('setting', 'Api\SettingsController@index');
    Route::get('page/{name}', 'Api\SettingsController@page');
});

<?php

use Illuminate\Support\Facades\Route;

//Auth::routes();

Route::get('/', function () {
    return view('index');
});
//Route::post('/web_login', 'WebLoginController@web_login')->name('web.login.submit');
//Route::post('/web_register', 'WebLoginController@web_register')->name('web.register.submit');
//Route::get('web_logout/', 'WebLoginController@web_logout')->name('web.logout');
//Route::get('/licence', 'HomeController@licence')->name('licence');
//Route::post('/contact', 'HomeController@contact')->name('contact');
//Route::get('/child_category/{id}', 'AdController@child_category')->name('child_category');
//Route::get('/category/{id}', 'AdController@ads')->name('category');
//Route::get('/showImg/{id}', 'HomeController@showImg')->name('showImg');
//Route::get('/deleteImgAd/{id}/{name}', 'HomeController@deleteImgAd')->name('deleteImgAd');
//Route::get('logout', 'Auth\LoginController@logout');
//Route::post('/search', 'AdController@search')->name('search');
//Route::get('/ad/{id}', 'AdController@show')->name('web-ad.show');


//admin password reset routes
Route::group(['prefix'=>'/admin','namespace'=>'Auth'],function() {
    Route::get('/password/reset','AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email','AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('/password/reset','AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}','AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});
Route::group(['prefix'=>'/admin','namespace'=>'App\Http\Controllers\Admin'],function() {
    //auth
    Route::get('/login', 'AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'AdminLoginController@logout')->name('admin.logout');
    //dashboard
    Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/profile', 'AdminController@edit_profile')->name('edit_profile');

    Route::get('setting', 'SettingController@get_setting')->name('setting.get_setting');
    Route::patch('setting/{id}', 'SettingController@update_setting')->name('setting.update_setting');

    Route::resource('admin', 'AdminController');
    Route::post('admin/activate/{id}', 'AdminController@activate')->name('active_admin');
    Route::resource('roles', 'RolesController');

    Route::resource('user', 'UserController');
    Route::get('active_user', 'UserController@active_users')->name('user.active_users');
    Route::get('not_active_user', 'UserController@not_active_users')->name('user.not_active_users');
    Route::post('user/activate/{id}', 'UserController@activate')->name('active_user');

    Route::resource('category', 'CategoryController');
    Route::post('category/activate/{id}', 'CategoryController@activate')->name('active_category');
    Route::get('get_category_childs/{id}', 'CategoryController@get_category_childs');
    Route::resource('slider', 'SliderController');

    Route::resource('contact', 'ContactController');
    Route::get('collective_notice', 'NotificationController@collective_notice')->name('notification.collective_notice');
    Route::resource('notification', 'NotificationController');
    Route::get('district', 'CityController@districts')->name('district.index');
    Route::resource('city', 'CityController');

    Route::resource('bank', 'BankController');
    Route::post('bank/activate/{id}', 'BankController@activate')->name('active_bank');
    Route::resource('ad', 'AdController');

    Route::get('page/{name}', 'PageController@editPage')->name('edit_page');
    Route::post('page/{name}', 'PageController@update')->name('page.update');

});



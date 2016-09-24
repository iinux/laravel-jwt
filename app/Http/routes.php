<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['api','cors'],'prefix' => 'api'], function () {
    Route::post('register', 'ApiController@register');     // 注册
    Route::post('login', 'ApiController@login');           // 登陆
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('get_user_details', 'APIController@get_user_details');  // 获取用户详情
    });
});

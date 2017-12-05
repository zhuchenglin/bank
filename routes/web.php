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



Route::get('/login',function (){
    return view('login');
});

Route::post('/check/login','LoginController@check_login');

// 测试
Route::get('/test', function(){
    echo 'this is test';
    // return view('login');
});

Route::group(['middleware'=>['login.check']],function (){
    Route::get('/','IndexController@index');


    include('users.php');
    include('admin.php');
});
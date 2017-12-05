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

Route::get('/', function () {
    return view('login');
    // echo '123';
});

Route::post('/login', 'LoginController@check_login');

// 测试
Route::get('/test', function(){
    echo 'this is test';
    // return view('login');
});

Route::group(['middleware'=>['login.check']],function (){
    include('users.php');
   
});
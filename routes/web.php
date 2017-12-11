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


Route::group(['middleware' => 'web'], function() {
    //
    Route::get('logout','User\LoginController@logout'); // 登出
    Route::match(['get','post'],'login','User\LoginController@login');  // 登录
    
    Route::group(['middleware'=>['login.check']],function(){ //中间件'permission','checkLogin'
        Route::get('/menu/get', 'User\MenuController@get_menu');// 获取左侧菜单/导航

        Route::get('user/get_user_list_paginate','User\UserController@get_user_list_paginate');  //分页获取用户列表
        Route::get('user/get_user_info','User\UserController@get_user_info');  //获取用户信息
        Route::get('user/get_role_list','User\UserController@get_role_list');  //获取用户信息
        Route::post('user/add','User\UserController@add');  //获取用户信息
        Route::post('user/reset_pwd','User\UserController@reset_pwd');  //重置用户密码
        Route::post('user/delete','User\UserController@soft_delete');  //删除用户
        Route::post('user/password','User\UserController@password');    //修改密码

        Route::get('user/sign', 'User\SignController@qrcode');

        Route::get('role/get_role_list_paginate','User\RoleController@get_role_list_paginate');   //获取角色列表
        Route::get('role/edit','User\RoleController@edit');   //角色编辑页面
        Route::get('get_menu','User\MenuController@get_menu'); // 获取 全部左侧菜单/导航
        Route::post('role/edit_save','User\RoleController@edit_save');   //角色保存
        Route::post('role/delete','User\RoleController@delete');   //删除角色
    });
});



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
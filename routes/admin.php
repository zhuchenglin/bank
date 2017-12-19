<?php
Route::group(['prefix' => 'admin'], function () {
    Route::post('/login_out','Admin\IndexController@login_out');


    Route::group(['prefix' => 'user'], function () {
        Route::post('/list','Admin\IndexController@get_user_list');
        Route::post('/en_disable','Admin\IndexController@en_disable');
        Route::post('/delete','Admin\IndexController@delete');
        Route::post('/create','Admin\IndexController@user_create');
    });

    Route::group(['prefix' => 'account'], function () {
        Route::post('/list','Admin\IndexController@account_list');
        Route::post('/create','Admin\IndexController@account_create');
        Route::post('/delete','Admin\IndexController@delete_account');
        Route::post('/en_disable','Admin\IndexController@account_en_dis');


    });

    Route::group(['prefix' => 'account_record'], function () {
        Route::post('/list','Admin\IndexController@account_record_list');


    });

});
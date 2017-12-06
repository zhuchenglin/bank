<?php
Route::group(['prefix' => 'admin'], function () {
    Route::post('/user/list','Admin\IndexController@get_user_list');


});
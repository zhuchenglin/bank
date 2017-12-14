<?php
  Route::group(['prefix' => 'user'], function () {


    Route::get('info/codenum','User\InfoController@get_user_code');


    Route::post('deposit','User\BusinessController@deposit');
    Route::post('takemoney','User\BusinessController@take_money');
    Route::post('transfer','User\BusinessController@transfer');
});
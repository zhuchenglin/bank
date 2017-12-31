<?php
  Route::group(['prefix' => 'user'], function () {


    Route::get('info/codenum','User\InfoController@get_user_code');


    Route::post('deposit','User\BusinessController@deposit');
    Route::post('takemoney','User\BusinessController@take_money');
    Route::post('transfer','User\BusinessController@transfer');
    Route::post('cardlist','User\InfoController@get_cardlist');
    Route::post('depositlist','User\InfoController@get_deposit_list');
    Route::post('takemoneylist','User\InfoController@get_take_list');
    Route::post('transferlist','User\InfoController@get_transfer_list');
    Route::post('super/password', 'User\SuperController@password'); 
});
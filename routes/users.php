<?php
  Route::group(['prefix' => 'user'], function () {


    Route::get('info/codenum','User\InfoController@get_user_code');
});
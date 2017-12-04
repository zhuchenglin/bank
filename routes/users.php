<?php
  Route::group(['prefix' => 'user'], function () {
    Route::get('/',function(){
        return view('user.index');
    });
});
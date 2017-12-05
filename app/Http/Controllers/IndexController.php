<?php

namespace App\Http\Controllers;
class IndexController
{
    function index()
    {
        $user = get_session_user();
        if($user){
            if($user->is_manager==1){
                return view('admin.index');
            }
            else if($user->is_manager==0){
                return view('user.index');
            }
        }
        return view('login');
    }
}




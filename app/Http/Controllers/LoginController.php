<?php

namespace App\Http\Controllers;
use App\Models\User;
class LoginController 
{
    function index(){
        echo '跳转到了login/index';
        // 判断登陆
        User::get_info();



    }
}




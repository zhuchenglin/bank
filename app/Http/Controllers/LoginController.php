<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
class LoginController
{
    function check_login(Request $request){   
        // echo '跳转到了login/index';
        // // 判断登陆
        // User::get_info();

        $user_name =  $request->user_name;
        $user_pwd = $request->user_pwd;
       

        return responseToJson(1,'登陆成功');

    }
}




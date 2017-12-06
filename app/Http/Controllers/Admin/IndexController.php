<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\User;
class IndexController
{
    function get_user_list(Request $request){
        $result = User::user_list();
        if($result){
            return responseToJson(0,'获取成功',$result);
        }
        return responseToJson(1,'获取失败');
    }
}
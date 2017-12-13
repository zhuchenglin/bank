<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\Models\Business;

class BusinessController extends Controller
{
    public function deposit(Request $request){
        
        $password = encrypt_password($request->password);
        $account_id = intval($request->account_id);
        if(Business::check_psd($request->account_id,$password)){
            $user_id = get_session_user_id();
            $money = $request->money;
            if(Business::deposit($user_id,$money,$account_id)){
                return responseToJson(0,'存款成功');
            }else{
                return responseToJson(1,'存款失败');
            }
        }else{
            return responseToJson(1,'密码错误');
        }
        
        
        // dd($request);
    }
}
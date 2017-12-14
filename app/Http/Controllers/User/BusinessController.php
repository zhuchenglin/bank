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

    public function take_money(Request $request){
        
        $password = encrypt_password($request->password);
        $account_id = intval($request->account_id);
        if(Business::check_psd($request->account_id,$password)){
            $user_id = get_session_user_id();
            $money = $request->money;
            $res = Business::check_money($money,$account_id);
            // dd($res[0]);
            if( ($res[0]-$money) < 0){
                return responseToJson(1,'余额不足，请换卡支付');
            }
            if(Business::take_money($user_id,$money,$account_id)){
                return responseToJson(0,'取款成功');
            }else{
                return responseToJson(1,'取款失败');
            }
        }else{
            return responseToJson(1,'密码错误');
        }
        
    }


    public function transfer(Request $request){
        $password = encrypt_password($request->password);
        $account_id = intval($request->account_id);
        if(Business::check_psd($request->account_id,$password)){
            $user_id = get_session_user_id();
            $money = $request->money;
            $receive_account_id = $request->receive_account_id;
            $res = Business::check_other_code($receive_account_id);
            // dd($res);
            if($res == null){
                return responseToJson(1,'对方卡号不存在');
            }
            $account_orther_id = $res->id;
            if($res->id == $account_id){
                return responseToJson(1,'不能本卡转账给本卡');
            }
            $res = Business::check_money($money,$account_id);
            // dd($res[0]);
            if( ($res[0]-$money) < 0){
                return responseToJson(1,'余额不足，请换卡支付');
            }
            if(Business::transfer($user_id,$money,$account_id,$account_orther_id)){
                return responseToJson(0,'转账成功');
            }else{
                return responseToJson(1,'转账失败');
            }
        }else{
            return responseToJson(1,'密码错误');
        }
        
    }

}
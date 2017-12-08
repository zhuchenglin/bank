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

    function en_disable(Request $request){
        $user_id = get_session_user_id();
        $status = $request->status;
        if(!check_identity($user_id,1)){
            return responseToJson(-1,'没有权限');
        }
        $user_id = $request->user_id;
        $result = User::en_disable_del($user_id,$status);
        if($status==2){
            $msg = '禁用成功';
        }else if($status==0){
            $msg = '启用成功';
        }
        if($result){
            return responseToJson(0,$msg);
        }else{
            return responseToJson(1,'操作失败');
        }

    }
    function delete(Request $request){
        $user_id = get_session_user_id();
        $status = $request->status;
        if(!check_identity($user_id,1)){
            return responseToJson(-1,'没有权限');
        }
        $user_id = $request->user_id;
        $result = User::en_disable_del($user_id,$status);
        if($result){
            return responseToJson(0,'删除成功');
        }
        return responseToJson(1,'删除失败');
    }

    function user_create(Request $request){
        $user_id = get_session_user_id();
        if(!check_identity($user_id,1)){
            return responseToJson(-1,'没有权限');
        }
        $user_info = $request->user_info;
        foreach($user_info as $ui){
            if(empty($ui)){
                return responseToJson(1,'要添加的用户的信息不完善');
            }
        }
        if(User::user_exist($user_info['account'])){
            return responseToJson(1,'该账号已存在');
        }
        if(User::create_user($user_info['name'],$user_info['account'],$user_info['ID_card'],$user_info['phone'])){
            return responseToJson(0,'添加成功，默认密码为:123456');
        }
        return responseToJson(1,'添加失败');
    }




    /**************************************账号方法******************************************/
    /**
     * @param 账号列表
     */
    function account_list(Request $request){

    }







}
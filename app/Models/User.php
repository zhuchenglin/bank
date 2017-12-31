<?php
/**
 * Created by PhpStorm.
 * User: pingguo
 * Date: 2017/11/29
 * Time: 14:55
 */

namespace App\Models;

use DB;
use Log;

class User
{
    /**
     * 获得某个user的信息
     * @param $id   用户id
     * @param null $fields 要得到的字段
     * @return mixed
     */
    public static function get_info($id, $fields = null)
    {
        //TODO $fields 有值过滤返回字段,没有就取所有的
        $query = DB::table('user');
        $query->where(['id' => $id, 'status' => 0]);
        if ($fields) {
            $query->select($fields);
        }
        return $query->first();
    }

    // 判断用户是否登陆成功
    public static function alread_login()
    {

    }

    //后台页面显示的用户列表
    //type=0时返回分页内容，=1时返回总数
    public static function user_list($page,$num,$type=0){
        $user_list = DB::table('user')->where(['is_manager'=>0])->where(function ($q){
            $q->where('status',0)->orWhere('status',2);
        })->select('id','name','account','ID_card','avatar','phone','create_time','is_manager','update_time','status');
        if($type==1){
            return $user_list->count();
        }
        if($page<0||$num<=0){
            $user_list = $user_list->get();
        }else{
            $start = $page*$num;
            $user_list = $user_list->offset($start)->limit($num)->get();
        }
        if($user_list){
            return $user_list;
        }
        return 0;
    }

    //后台禁用启用用户的操作
    public static function en_disable_del($user_id,$status){
        $result = DB::table('user')->where(['id'=>$user_id])->where(function ($q){
            $q->where('status',0)->orWhere('status',2);
        })->update(['status'=>$status]);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 后台添加普通用户的方法
     */
    public static function create_user($name,$account,$ID_card,$phone,$password='123456'){
        $result = DB::table('user')->insert([
            'name'=>$name,
            'account'=>$account,
            'ID_card'=>$ID_card,
            'phone'=>$phone,
            'password'=>encrypt_password($password)
        ]);
        if($result){
            return true;
        }
        return false;
    }
    /**
     * 后台判断用户account是否已存在
     * 存在的话返回true,否则返回false
     */
    public static function user_exist($account){
        $result = DB::table('user')->where(['account'=>$account])->where(function ($q){
            $q->where('status',0)->orWhere('status',2);
        })->first();
        if($result){
            return true;
        }
        return false;
    }

    /**
     * 根据身份证号查找单个用户
     */
    public static function single_user($ID_card){
        $result = DB::table('user')->where(['ID_card'=>$ID_card])->first();
        if($result){
            return $result;
        }
        return 0;
    }

     /**
     * 获取用户信息
     * @param  [String] $code or $phone
     * @return  Object
     */
     public static function get_user_by_code($codeOrMobile)
     {
        try {
            $user = DB::table("user")->where(function ($q) use ($codeOrMobile){
                $q->where('name',$codeOrMobile)->orWhere('account',$codeOrMobile)->orWhere('phone',$codeOrMobile);
            })->first();
            return $user;
        } catch (\Exception $e) {
            Log::info($e);
            return null;
        }
    }

    static function is_password_right($pwd)
    {
        $user = DB::table('user')->where('id', get_session_user_id())->first();
        return $user->password == encrypt_password($pwd);
    }

    static function change_password($new_pwd)
    {
        // $salt = get_salt();
        $password = encrypt_password($new_pwd);
        $res = DB::table('user')
            ->where('id', get_session_user_id())
            ->update(['password' => $password, 'update_time' => time()]);
        return $res;
    }

}
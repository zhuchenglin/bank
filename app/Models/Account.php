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

class Account{
    /**
     * @param $page 页码
     * @param $num  每页显示的数量
     * $user_id=0是，返回所有，$user_id!=0 返回指定的用户的账号
     * @param int $type $type=1时，返回总数，$type=0 返回分页的结果
     */
    public static function account_list($page,$num,$user_id=0,$type=0){
        $q = DB::table('account')->where(function ($w){
            $w->where('account.status',0)->orWhere('account.status',1);
        });
        if($user_id!=0){
            $q->where('account.user_id',$user_id);
        }
        if($type==0){
            $start = $page*$num;
            $result = $q->leftJoin('user','account.user_id','=','user.id')->offset($start)->limit($num)->
                select('user.name','user.ID_card','user.phone','account.account','account.rest_money',
                'account.status','account.create_time','account.id')->get();
        }else{
            $result = $q->count();
        }
        return $result;
    }

    /**
     * 创建账户的方法
     * @param $user_id
     * @return bool
     */
    public static function account_create($user_id){
        $account = substr(time()  . uniqid(),0,10);
        $password = encrypt_password('123456');
        $result = DB::table('account')->insert([
            'account'=>$account,
            'rest_money'=>0,
            'user_id'=>$user_id,
            'status'=>0,
            'create_time'=>time(),
            'password'=>$password
        ]);
        if($result){
            return true;
        }
        return false;
    }

    /**
     * 启用，禁用删除账户的方法
     * @param $account_id
     * @param $status
     * @return bool
     */
    public static function en_disable_del($account_id,$status){
        $result = DB::table('account')->where(['id'=>$account_id])->update([
            'status'=>$status
        ]);
        if($result){
            return true;
        }
        return false;
    }

    public static function account_exist($account_id){
        $result = DB::table('account')->where(['id'=>$account_id])->where(function ($q){
            $q->where('status',0)->orWhere('status',1);
        })->first();
        if($result){
            return true;
        }
        return false;
    }

}
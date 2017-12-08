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
            $w->where('account.status',0)->orWhere('account.status',2);
        });
        if($user_id!=0){
            $q->where('account.user_id',$user_id);
        }
        if($type==0){
            $start = $page*$num;
            $result = $q->leftJoin('user','account.user_id','=','user.id')->offset($start)->limit($num)->get();
        }else{
            $result = $q->count();
        }
        return $result;
    }
}
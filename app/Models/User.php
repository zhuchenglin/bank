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

class User{
    public static function get_info($id, $fields = null)
    {
        //TODO $fields 有值过滤返回字段,没有就取所有的
        $query = DB::table('user');
        $query->where(['id'=>$id,'status'=>0]);
        if ($fields) {
            $query->select($fields);
        }
        return $query->first();
    }

    // 判断用户是否登陆成功
    public static function alread_login(){
        
    }
}
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

    public static function user_list(){
        $user_list = DB::table('user')->where(['is_manager'=>0,'status'=>0])->select('id','name','account','ID_card','avatar','phone','create_time','is_manager','update_time')->get();
        if($user_list){
            return $user_list;
        }
        return 0;
    }


}
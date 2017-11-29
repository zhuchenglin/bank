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
        } else {
            $query->select('id','name','account','ID_card','phone','avatar','create_time','update_time','is_manager','school_id');
        }
        return $query->first();
    }
}
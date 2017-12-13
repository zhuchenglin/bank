<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class Business extends Model
{

    public static function deposit($user_id,$money,$account_id){
        $res = DB::table('access_record')->insert([
            'money' => $money,
            'status' => 0,
            'create_time' => time(),
            'user_id' => $user_id,
            'account_id' => $account_id
        ]);
        // dd($account_id);
        if($res){
            DB::table('account')->where('id',$account_id)->increment('rest_money',$money);
            return true;
        }
        return false;
    }

    public static function check_psd($account_id,$password){


        $res = DB::table('account')->where('id',$account_id)->where('password',$password)->first();
        return $res;
    }

}

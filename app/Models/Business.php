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

    public static function take_money($user_id,$money,$account_id){
        $res = DB::table('access_record')->insert([
            'money' => $money,
            'status' => 1,
            'create_time' => time(),
            'user_id' => $user_id,
            'account_id' => $account_id
        ]);
        // dd($account_id);
        if($res){
            DB::table('account')->where('id',$account_id)->decrement('rest_money',$money);
            return true;
        }
        return false;
        // dd(Business::check_money($money,$account_id));
    }

    static function check_money($money,$account_id){
        return DB::table('account')->where('id',$account_id)->pluck('rest_money');
    }


    public static function transfer($user_id,$money,$account_id,$account_other_id){
        $res = DB::table('transfer_record')->insert([
            'money' => $money,
            'status' => 0,
            'create_time' => time(),
            'user_id' => $user_id,
            'account_id' => $account_id
        ]);
        // dd($account_id);
        if($res){
            DB::table('account')->where('id',$account_id)->decrement('rest_money',$money);
            DB::table('account')->where('id',$account_other_id)->increment('rest_money',$money);
            return true;
        }
        return false;
        // dd(Business::check_money($money,$account_id));
    }

    public static function check_other_code($receive_account_id){
        return DB::table('account')->where('account',$receive_account_id)->first();
    }

}

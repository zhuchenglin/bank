<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class Info extends Model
{

    static function get_user_codes($user_id){
        return DB::table('account')->where('user_id',$user_id)->where('status',0)->get();
    }

    static function get_user_cardlist($user_id){
        return DB::table('account')->where('user_id',$user_id)->where('status','<>',1)->get();
    }



    static function get_transfer_list($page_size = 50,$account_id){
        $sql = DB::table('transfer_record')->join('user', 'user.id', '=', 'transfer_record.user_id')->join('account','account.id','transfer_record.receive_account_id')->where('transfer_record.account_id',$account_id)->where('transfer_record.status',0);
        $sql = $sql -> select('transfer_record.money','transfer_record.create_time','user.name','account.account') -> orderBy('transfer_record.create_time', 'asc');
        return $sql -> paginate($page_size);
        
    }



    static function get_take_list($page_size = 50,$account_id,$status){
        $sql = DB::table('access_record')->join('user', 'user.id', '=', 'access_record.user_id')->where('access_record.account_id',$account_id)->where('access_record.status',$status);
        $sql = $sql -> select('access_record.money','access_record.create_time','user.name') -> orderBy('access_record.create_time', 'asc');
        return $sql -> paginate($page_size);
    }



}

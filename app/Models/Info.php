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
}

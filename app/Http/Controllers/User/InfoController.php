<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\Models\Info;

class InfoController extends Controller
{
    function get_user_code()
    {
        
        return responseToJson(0,'获取成功',Info::get_user_codes(get_session_user_id()));
        // dd(get_session_user_id());
    }
}
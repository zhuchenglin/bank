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

    function get_cardlist(){

        return responseToJson(0,'获取成功',Info::get_user_cardlist(get_session_user_id()));
    }


    function get_transfer_list(Request $request){
        $page_size = $request->page_size;
        $account_id = $request->account_id;
        return responseToJson(0,'获取成功',Info::get_transfer_list($page_size,$account_id));
    }



    function get_deposit_list(Request $request){
        $page_size = $request->page_size;
        $account_id = $request->account_id;
        return responseToJson(0,'获取成功',Info::get_take_list($page_size,$account_id,0));
    }



    function get_take_list(Request $request){
        $page_size = $request->page_size;
        $account_id = $request->account_id;
        return responseToJson(0,'获取成功',Info::get_take_list($page_size,$account_id,1));
    }
}
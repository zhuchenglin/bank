<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use DB;
use Log;
use Redirect;
use App\Models\Role;

class LoginController extends Controller
{
    function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $name = $request->name;//code or mobile
            $pwd = $request->pwd;
            $user = User::get_user_by_code($name);

            // if ($user && $user->status == 0 && $user->type == User::TYPE_TEACHER) {

                //md5(md5($pwd) . $user->salt)
//                dump($user->password);
            //    dd(encrypt_password($pwd));
                if (encrypt_password($pwd) == $user->password) {
                    // $roleIds = explode(',', $user->role_id);
                    // $permission = Role::get_role_permission($roleIds);
                    session(['user' => $user]);

                    // User::history([
                    //     'user_id' => $user->id,
                    //     'user_name' => $user->name,
                    //     'login_type' => $user->type,
                    //     'create_time' => millisecond()
                    // ]);
                    // Log::error(['LOGIN SUCCESS' => \GuzzleHttp\json_encode($user)]);
                    return Response::json(['status' => 0, 'msg' => '登陆成功']);
                } else {
                    Log::error(['LOGIN ERROR' =>json_encode($user)]);
                    return Response::json(['status' => 1, 'msg' => '用户名或密码错误,请重新输入']);
                }

            // } else {
            //     Log::error(['LOGIN ERROR' => \GuzzleHttp\json_encode($user)]);
            //     return Response::json(['status' => 1, 'msg' => '用户名或密码错误,请重新输入']);
            // }

        } else {
            return view('login');
        }
    }

    function logout(Request $request)
    {
        $request->session()->flush();
        return Response::json(['status' => 0, 'msg' => '登出成功']);
    }



    function auth_callback()
    {
        echo '非法访问';
        exit;
        //$user = Input::get('user');
        //dd(json_decode($user));
//        $openid = Input::get('openid');
//        $curl = new \anlutro\cURL\cURL();
//        $url = env('NOTIFY_URL') . '/api/auth_user';
//        Log::info('url:' . $url);
//        $real_openid = RsaCrypt::private_decode(utf8_decode($openid));
//        $rsa_openid = RsaCrypt::encode($real_openid);
//        $response = $curl->post($url, ['openid' => $rsa_openid, 'code' => env('AUTH_CODE')]);
//        if ($response && $response->statusCode == 200) {
//            $result = json_decode($response->body);
//            if ($result->code == 0) {
//                $user = $result->result;
//                $user->role_id = 1;
//                $permission = Role::get_role_permission(1);//todo: 管理员登录,默认为超级管理员
//                session(['user' => $user, 'permission' => $permission]);
//
//                User::history([
//                    'user_id' => $user->id,
//                    'user_name' => $user->real_name,
//                    'login_type' => 2,
//                    'unique_id' => $real_openid,
//                    'create_time' => millisecond()
//                ]);
//
//                return Response::json(['status' => 0, 'msg' => '登陆成功']);
//            } else {
//                return Response::json(['status' => 1, 'msg' => $result->msg]);
//            }
//
//        } else {
//            Log::error($response);
//            return Response::json(['status' => 1, 'msg' => '网络错误,请稍候尝试']);
//        }
    }
}
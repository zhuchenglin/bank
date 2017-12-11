<?php
/**
 * 页面json 输出
 *
 * @param int $code
 * @param $msg
 * @param $paras
 */
function responseToJson($code = 0, $msg = '', $paras = null)
{
    $res["code"] = $code;
    $res["msg"] = $msg;
    // if (!empty($paras)) {
    $res["result"] = $paras;
    // }
    return response()->json($res);
}

function get_session_user()
{
    /*$std               = new \stdClass();
    $std->id           = 5;
    $std->type         = 1;
    $std->real_name    = "chjw";
    $std->org_id       = 1;
    $std->org_name     = "XX大学";
    $std->openid       = "";
    $std->login_openid = "";
    $std->user_code    = "20051015112";
    $std->sex          = "男";
    $std->is_v         = 0;
    $std->relation_id  = 1;
    $std->role_id      = 2;

    session(['user' => $std]);*/
    return session("user");
}

function get_session_user_id()
{
    $user = session("user");
    return $user ? $user->id : 0;
}
/**
 * 获取用户密码加密字符串
 * @param $password
 * @param $salt
 * @return string
 */
function encrypt_password($password)
{
    return md5(md5($password));
}

function get_salt()
{
    $uuid = create_uuid();
    $salt = substr($uuid, strlen($uuid) - 4, 4);
    return $salt;
}

/**
 * 生成缩略图函数（支持图片格式：gif、jpeg、png）
 * @author ruxing.li
 * @param  string $src 源图片路径
 * @param  string $filename 保存名字
 * @param  string $filename 保存路径
 * @param  int $width 缩略图宽度（只指定高度时进行等比缩放）
 * @param  int $height 缩略图高度（只指定宽度时进行等比缩放）
 * @return bool
 */
function thumbnail($src, $filename, $filepath, $width = 150, $height = null)
{
    $path = $filepath;
    if ($filename != '')
        $path = $path . '/' . $filename;
    // $path = str_replace('\\','/',$path);
    // dd($path);
    $size = getimagesize($src);
    if (!$size)
        return false;
    list($src_w, $src_h, $src_type) = $size;
    if (!isset($width))
        $width = $src_w * ($height / $src_h);
    if (!isset($height))
        $height = $src_h * ($width / $src_w);

    $src_img = imagecreatefromstring(file_get_contents($src));
    if ($src_type == 3)
        $dest_img = imagecreate($width, $height);
    else $dest_img = imagecreatetruecolor($width, $height);
    imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);
    if (!is_dir($filepath)) {
        mkdir($filepath);
    }
    switch ($src_type) {
        case 1 :
            $img_type = 'gif';
            imagegif($dest_img, $path);
            break;
        case 2 :
            $img_type = 'jpeg';
            imagejpeg($dest_img, $path);
            break;
        case 3 :
            $img_type = 'png';
            imagepng($dest_img, $path);
            break;
        default :
            return false;
    }
    imagedestroy($src_img);
    imagedestroy($dest_img);
    return true;
}

/**
 * @param $org_str      待过滤字符串
 * $flag              将敏感词转化成的标记
 */
function sensitive_word_filter($org_str,$flag='***'){
    //TODO 解决演示使用,正式使用请重构
    $sensitive_words = ['打人','中国','日本','主席','嗑药','中央','逼逼'];
//    for($i=0;$i<count($sensitive_words);$i++){
//        $re[$i] = str_repeat($flag,strlen($sensitive_words[$i]));
//    }
    $re = array_fill(0,count($sensitive_words),$flag);
    $sensitive_words_array  = array_combine($sensitive_words,$re);
    $str = strtr($org_str,$sensitive_words_array);
    return $str;
}

/**
 * 检查用户身份是否正确
 * @param $user_id
 * @param $type type=0 普通用户  type=1 管理员
 * @return bool
 */
function check_identity($user_id,$type){
    $user = DB::table('user')->where(['status'=>0,'id'=>$user_id]);
    if($type==0){
        $user = $user->where('is_manager',0);
    }else if($type==1){
        $user = $user->where('is_manager',1);
    }
    $user = $user->first();
    if($user){
        return true;
    }
    return false;
}
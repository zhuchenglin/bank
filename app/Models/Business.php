<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class Business extends Model
{

    public static function deposit($user_id, $money, $account_id)
    {
        $res = DB::table('access_record')->insert([
            'money' => $money,
            'status' => 0,
            'create_time' => time(),
            'user_id' => $user_id,
            'account_id' => $account_id
        ]);
        // dd($account_id);
        if ($res) {
            DB::table('account')->where('id', $account_id)->increment('rest_money', $money);
            return true;
        }
        return false;
    }

    public static function check_psd($account_id, $password)
    {


        $res = DB::table('account')->where('id', $account_id)->where('password', $password)->first();
        return $res;
    }

    public static function take_money($user_id, $money, $account_id)
    {
        $res = DB::table('access_record')->insert([
            'money' => $money,
            'status' => 1,
            'create_time' => time(),
            'user_id' => $user_id,
            'account_id' => $account_id
        ]);
        // dd($account_id);
        if ($res) {
            DB::table('account')->where('id', $account_id)->decrement('rest_money', $money);
            return true;
        }
        return false;
        // dd(Business::check_money($money,$account_id));
    }

    static function check_money($money, $account_id)
    {
        return DB::table('account')->where('id', $account_id)->pluck('rest_money');
    }


    public static function transfer($user_id, $money, $account_id, $account_other_id)
    {
        $res = DB::table('transfer_record')->insert([
            'money' => $money,
            'status' => 0,
            'create_time' => time(),
            'user_id' => $user_id,
            'account_id' => $account_id,
            'receive_account_id' => $account_other_id
        ]);
        // dd($account_id);
        if ($res) {
            DB::table('account')->where('id', $account_id)->decrement('rest_money', $money);
            DB::table('account')->where('id', $account_other_id)->increment('rest_money', $money);
            return true;
        }
        return false;
        // dd(Business::check_money($money,$account_id));
    }

    public static function check_other_code($receive_account_id)
    {
        return DB::table('account')->where('account', $receive_account_id)->first();
    }

    /**
     * 记录列表
     * @param $account_id      要获取记录列表的账号id  如果account_id=0是所有的账号的记录
     * @param $type $type=1转账，$type=2 存取款
     * @param $page             分页的页号
     * @param $num              每页显示的数量
     * @param $get_num          当get_num=1得到数量，get_num=0得到记录
     */
    public static function account_record_list($account_id, $type, $page, $num, $get_num)
    {
        $q = null;
        if ($type == 1) {
            $q = DB::table('transfer_record');
            if (!empty($account_id)) {
                $q->where('transfer_record.account_id', $account_id);
            }
        } else if ($type == 2) {
            $q = DB::table('access_record');
            if (!empty($account_id)) {
                $q->where('access_record.account_id', $account_id);
            }
        }
        if ($get_num == 1) {
            $result = $q->count();
        } else {
            if($type==1){
                $q->leftJoin('account as origin_account','origin_account.id','=','transfer_record.account_id')
                    ->leftJoin('account as receive_account','transfer_record.account_id','=','receive_account.id')
                    ->select('origin_account.account as origin_acc','receive_account.account as receive_acc','transfer_record.money','transfer_record.create_time','transfer_record.status')
                    ->where('transfer_record.status',0)->orderBy('transfer_record.create_time','desc');
            }else if($type==2){
                $q->leftJoin('account','account.id','=','access_record.account_id')
                    ->select('account.account as origin_acc','access_record.status','access_record.create_time','access_record.money','access_record.status')
                    ->where('access_record.status','!=',2)->orderBy('access_record.create_time','desc');
            }
            if ($page != -1 && $num != 0) {
                $start = $page * $num;
                $result = $q->offset($start)->limit($num)->get();
            } else {
                $result = $q->get();
            }
        }
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    /**
     * 快速排序，对记录按时间排序
     * @param $arr
     * @param $low
     * @param $high
     */
    public static function quickSort(&$arr, $low, $high)
    {
        if ($low < $high) {
            $i = $low;
            $j = $high;
            $primary = $arr[$low];
            while ($i < $j) {
                while ($i < $j && $arr[$j] >= $primary) {
                    $j--;
                }
                if ($i < $j) {
                    $arr[$i++] = $arr[$j];
                }
                while ($i < $j && $arr[$i] <= $primary) {
                    $i++;
                }
                if ($i < $j) {
                    $arr[$j--] = $arr[$i];
                }
            }
            $arr[$i] = $primary;
            quickSort($arr, $low, $i - 1);
            quickSort($arr, $i + 1, $high);
        }
    }

}

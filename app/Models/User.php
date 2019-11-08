<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;


    /**
     * 查找用户账号
     * @param $account 账号
     * @param $password 密码
     */
    public static function find_user_account($account,$password)
    {
        $field = ['id','user_name','password','real_name','update_at'];
        $result = self::where('$user_name',$account)->select($field)->where('status',1)->first();
        $result = object_to_array($result);
        return $result;
    }

    /**
     * @Desc 查询所有用户信息
     * @Auther liu
     * @Time
     * */
    static function select_user_info($name='',$phone='',$id_card='',$register_start_time,$register_end_time,$where,$page_size='',$page=1,$field=['*'],$promoter_name=''){
        $page_size = $page_size ? $page_size : env('PAGE_SIZE');

        $info = self::where($where);
        if($name != ''){
            $info = $info->where('user_idcard_info.uname','like','%'.$name.'%');
        }
        if($phone != ''){
            $info = $info->where('user.u_account','like','%'.$phone.'%');
        }
        if($id_card != ''){
            $info = $info->where('user_idcard_info.idcard_code','like','%'.$id_card.'%');
        }
        if($promoter_name){
            $info = $info->where('promoter.nick_name','like','%'.$promoter_name.'%');
        }
        if($register_start_time && $register_end_time){
            $info = $info->whereBetween('user.ctime',[$register_start_time,$register_end_time]);
        }else if($register_start_time){
            $info = $info->where('user.ctime','>',$register_start_time);
        }else if($register_end_time){
            $info = $info->where('user.ctime','<',$register_end_time);
        }



        $info = $info->orderBy('user.ctime','desc')
            ->leftjoin('user_idcard_info','user_idcard_info.user_id','=','user.id')
            ->leftjoin('promoter','promoter.id','=','user.promoter_id')
            ->with('user_identify')
            ->paginate($page_size,$field,null,$page);


        $record_list = object_to_array($info);
        $array = array("mailst"=>0,"operate"=>0,"contacts"=>0,"face"=>0,"alipay"=>0);

        foreach($record_list['data'] as $key=>$value){
            $record_list['data'][$key] = array_merge($record_list['data'][$key],$array);

            foreach($value['user_identify'] as $k=>$v){
                if($v['identify_name'] == 'mailst_identify'){
                    $record_list['data'][$key]['mailst'] = $v['state'];
                }elseif($v['identify_name'] == 'operator_identify'){
                    $record_list['data'][$key]['operate'] = $v['state'];
                }elseif($v['identify_name'] == 'contacts_identify'){
                    $record_list['data'][$key]['contacts'] = $v['state'];
                }elseif($v['identify_name'] == 'face_identify'){
                    $record_list['data'][$key]['face'] = $v['state'];
                }elseif($v['identify_name'] == 'alipay_identify'){
                    $record_list['data'][$key]['alipay'] = $v['state'];
                }
            }
        }


        $result['total_page'] = $record_list['last_page'];
        $result['total_data'] = $record_list['total'];
        $result['list'] = $record_list['data'];

        return $result;
    }
}

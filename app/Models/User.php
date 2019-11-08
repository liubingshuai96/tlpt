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
     * datetime 2019-11-8
     * @Auther liu
     * @Time
     * */
    static function select_user_info($name='',$tel='',$idcard='',$email = '',$created_at,$updated_at,$where,$page_size='',$page=1,$field=['*'])
    {
        $page_size = $page_size ? $page_size : env('PAGE_SIZE');

        $info = self::where($where);

        if($name != ''){
            $info = $info->where('user.user_name','like','%'.$name.'%');
        }
        if($tel != ''){
            $info = $info->where('user.tel','like','%'.$tel.'%');
        }
        if($email != '') {
            $info = $info->where('user.email','like','%'.$email.'%');
        }
        if($idcard != ''){
            $info = $info->where('user.idcard','like','%'.$idcard.'%');
        }


        if($created_at && $updated_at){
            $info = $info->whereBetween('user.ctime',[$created_at,$updated_at]);
        }else if($created_at){
            $info = $info->where('user.created_at','>',$created_at);
        }else if($updated_at){
            $info = $info->where('user.created_at','<',$updated_at);
        }

        $info = $info->orderBy('user.created_at','desc')
            ->paginate($page_size,$field,null,$page);

        $record_list = object_to_array($info);
        $result['total_page'] = $record_list['last_page'];
        $result['total_data'] = $record_list['total'];
        $result['list'] = $record_list['data'];
        return $result;
    }
}

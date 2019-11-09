<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use session;
class SysAdmin extends Model
{
    //
    protected $table = 'sys_admin';
    //数据库主键
    public $primaryKey = 'id';
    public $dateFormat = 'U';
    public $timestamps = false;
    /**
     * 通过账号查询用户
     * datetime 2019-11-7
     * author liu
     */
    public static function find_admin($account)
    {
        $result = self::where('account',$account)->where('status',1)->first();
        $res = object_to_array($result);
        return $res;
    }

    /**
     * datetime 2019-11-8
     * author liu
     * @return mixed
     */
    public static function login_out($status)
    {
        $array = array('status'=>2,$status);
        $out = self::where('id',session::get('account')->update($array));
        return $out;
    }
    /**
     * @Desc 查询管理员信息
     * @Auther liu
     * @Time 2019-11-8 20:20
     * */
    public static function select_sys_admin($page_size='',$page=1,$field){
        $where_info = self::where('sys_admin.status','1');

        $page_size = $page_size ? $page_size : env('PAGE_SIZE');

        $where_info = $where_info->orderBy('created_at','desc')
            ->leftjoin("admin_group","sys_admin.admin_group_id","=","admin_group.id")
            ->paginate($page_size,$field,null,$page);
        $record_list = object_to_array($where_info);
        $result['total_page'] = $record_list['last_page'];
        $result['total_data'] = $record_list['total'];
        $result['list'] = $record_list['data'];
        return $result;
    }
    /**
   * @Desc 查询单条数据
   * @Auther liu
   * @Time 2019-11-8
   * */
    public static function find_sys_admin($where,$field=['*'],$id=''){
        $admin_info = self::where($where);
        if(!empty($id)){
            $admin_info = $admin_info->where('id','!=',$id)->where('status','!=',2);
        }
        $admin_info = $admin_info->select($field)->first();
        if(!$admin_info){
            return false;
        }
        return object_to_array($admin_info);
    }
    /**
    * @Desc 添加管理员信息
    * @Auther liu
    * @Time
    * */
    public static function add_admin($data){

        $result = self::insertGetId($data);
        return $result;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    //数据库名称
    public $table = 'role_fun';
    //数据库主键
    public $primaryKey = 'id';
    public $dateFormat = 'U';
    public $timestamps = false;


    /**
     * @Desc 查询角色信息
     * @Auther liu
     * @Time 2019-11-15 20:20
     * */
    public static function select_role($page_size='',$page=1,$field)
    {
        $where_info = self::where('role_fun.status','1');
        $page_size = $page_size ? $page_size : env('PAGE_SIZE');
        $where_info = $where_info->orderBy('created_at','desc')
                      ->leftjoin("user","role_fun.user_id","=","user.id")
                      ->leftjoin("function","role_fun.function_id","=","function.id")
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
     * @Time 2019-11-8 3:00
     * */
    public static function find_role_fun($where,$field=['*'],$id='')
    {
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
     * @desc 添加角色
     * @time 2019-11-14
     * @author liu
     * @param $data
     * @return mixed
     */
    public static function add_role($data)
    {
        $result = self::insertGetId($data);
        return $result;
    }
    /**
    * @Desc 修改数据
    * @Auther liu
    * @Time 2019-11-14
    * */
    public static function edit_role($field,$id,$data){

        $res = self::where($field,$id)->update($data);

        return $res;
    }
    /**
     * @Desc 修改数据
     * @Auther liu
     * @Time 2019-11-14
     * */
    public static function del_role($field,$id,$data){

        $res = self::where($field,$id)->delete($data);

        return $res;
    }
}

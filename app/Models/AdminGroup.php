<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AdminGroup extends Model
{
    //数据库名称
    public $table = 'admin_group';
    //数据库主键
    public $primaryKey = 'id';
    public $dateFormat = 'U';
    public $timestamps = false;

    /**
     * @Desc 查询后台权限组
     * @Auther liu
     * @Time 2019-11-12
     * */
    public static function select_admin_group($page_size='',$page=1,$field=['*'])
    {
        $where_info = self::where('status','1');
        $page_size = $page_size ? $page_size : env('PAGE_SIZE');
        $where_info = $where_info->orderBy('created_at','desc')->paginate($page_size,$field,null,$page);
        $record_list = object_to_array($where_info);
        $result['total_page'] = $record_list['last_page'];
        $result['total_data'] = $record_list['total'];
        $result['list'] = $record_list['data'];
        return $result;
    }

    /**
    * @添加后台权限组
    * @Auther liu
    * @Time 2019-11-12
    * */
    public static function add_admin_group($data)
    {
        $result = self::insert($data);
        return $result;
    }

    /**
    * @Desc 查询单条数据
    * @Auther
    * @Time
    * */
    public static function find_admin_group($id,$field=null)
    {
        $find_info = self::where("id",$id)->select($field)->first();
        if(!$find_info){
            return false;
        }
        return object_to_array($find_info);
    }
    /**
     * @Desc 修改数据
     * @Auther
     * @Time
     */
    public static function edit_admin_group($field,$id,$data)
    {
        $res = self::where($field, $id)->update($data);
        return $res;


    }
    /**
      * @Desc 修改管理员信息
      * @Auther
      * @Time
      * */
        public static function del_admin($field,$value,$data)
        {
        $info = self::where($field,$value)->delete($data);
        return $info;
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuAdminAction extends Model
{
    //数据库名称
    public $table = 'menu_admin_action';
    //数据库主键
    public $primaryKey = 'menu_action_id';

    /**
     * @Desc 查询菜单权限
     * @Time
     * @Auther
     * */
    public static function select_menu($where=[],$field=['*'])
    {
        $where['status'] = 1;
        $menu_info = self::where($where);
        $menu_info = $menu_info->orderBy('sort','asc')->select($field)->get();
        $menu_list = object_to_array($menu_info);
        return $menu_list;
    }

    /**
     * @Desc 根据权限查询所有左侧导航栏第一级
     * @Time
     * @Auther
     * */
    public static function select_auth_menu($where,$menu_permission,$field=['*'])
    {

        $menu_info = self::whereIn('menu_action_id',$menu_permission)
                            ->where($where)->orderBy('sort','asc')
                            ->select($field)->get();
        return object_to_array($menu_info);
    }

    /**
     * @Desc 根据权限查询左侧导航栏第二级
     * @Time
     * @Author
     * */
    public static function select_auth_menu_two($where,$menu_permission,$field=['*'])
    {
        $menu_info = self::where($where)
                            ->whereIn('menu_action_id',$menu_permission)
                            ->orderBy('sort','asc')->select($field)->get();
        return object_to_array($menu_info);
    }
}

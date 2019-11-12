<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuAdminButton extends Model
{
    //数据库名称
    public $table = 'menu_admin_button';
    //数据库主键
    public $primaryKey = 'btn_id';
    public $dateFormat = 'U';
    public $timestamps = false;

    /**
     * @Desc 查询所有权限
     * @Time
     * @Author
     *
     */
    static function select_menu_admin($field=['*'])
    {
        $info = self::select($field)->get();
        return object_to_array($info);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    //
    protected $table = 'medicine';
    public $primaryKey = 'id';
    public $dateFormat = 'U';


    /**
     * @Desc 查询药材信息
     * @Auther liu
     * @Time 2019-11-14 20:20
     * */
    public static function select_medicine($page_size='',$page=1,$field)
    {
        $where_info = self::where('status','1');
        $page_size = $page_size ? $page_size : env('PAGE_SIZE');
        $where_info = $where_info->orderBy('created_at','desc')
                    ->paginate($page_size,$field,null,$page);
        $record_list = object_to_array($where_info);
        $result['total_page'] = $record_list['last_page'];
        $result['total_data'] = $record_list['total'];
        $result['list'] = $record_list['data'];
        return $result;
    }
    /**
     * @Desc 查询单条药材
     * @Auther liu
     * @Time 2019-11-14 3:00
     * */
    public static function find_medicine($where,$field=['*'],$id='')
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
     * @desc 添加药材
     * @author liu
     * @time 2019-11-14
     */
    public static function add_medicine($data)
    {
        $result = self::insertGetId($data);
        return $result;
    }

    /**
     * @desc 修改药材
     * @author liu
     * @time 2019-11-14 4:16
     */
    public static function edit_medicine($field,$id,$data)
    {
        $result = self::where($field,$id)->update($data);
        return  $result;
    }

    /**
     * @desc 删除药材
     * @author liu
     * @time 2019-11-14
     */
    public static function del_medicine($field,$id,$data)
    {
        $res = self::where($field,$id)->delete($data);
        return $res;
    }
}

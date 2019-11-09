<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SysAdmin;

class SysAdminController extends Controller
{

    /**
    * @Desc 管理员列表
    * @Auther liu
    * @Time
    * */
    public function admin_list(request $request){
        $page = $request->input('page',1);
        $page_size = $request->input('page_size');
        $field = array("sys_admin.id","sys_admin.account","sys_admin.created_at","sys_admin.updated_at","admin_group.admin_name as group_name");

        $admin_group_list = SysAdmin::select_sys_admin($page_size,$page,$field);
        foreach($admin_group_list["list"] as $k=>$value){
            $admin_group_list["list"][$k]["account"] = substr_replace($value['account'],'****',5,4);
        }
        $this->success("请求成功",$admin_group_list['list'],'',$admin_group_list['total_page'],$admin_group_list['total_data']);
    }
    /**
    * @Desc 添加管理员
    * @Auther zengjiuping
    * @Time 2018-10-28 19:28
    * */
    public function add_admin(request $request){

        $data['account'] = $request->input('account');
        $data['password'] = md5($request->input('password'));
        $data['admin_group_id'] = intval($request->input('admin_group_id'));

        if(empty($data['account']) || empty($data['password']) || empty($data['admin_group_id'])){
            self::error('参数不全');
        }
        if(empty($data['account'])){
            self::error("账号不能为空");
        }
        //判断管理员账号是否已经存在
        $where['account'] = $data['account'];
        $info = SysAdmin::find_sys_admin($where,'id');
        if(SysAdmin::find_sys_admin($where,'id')){
            self::error("此账号已经存在，不能重复添加");
        }
        $data['created_at'] = time();
        $add_admin_info = SysAdmin::add_admin($data);
        if($add_admin_info){
            self::success("添加成功");
        }else{
            self::error("添加失败");
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SysAdmin;
//管理员管理
class SysAdminController extends Controller
{

    /**
    * @Desc 管理员列表
    * @Auther liu
    * @Time 2019-11-8 5:20
    * */
    public function admin_list(request $request)
    {
        $page = $request->input('page',1);
        $page_size = $request->input('page_size');
        $field = array("sys_admin.id","sys_admin.account","sys_admin.created_at","sys_admin.updated_at","admin_group.admin_name as group_name");
        $admin_group_list = SysAdmin::select_sys_admin($page_size,$page,$field);
        $this->success("请求成功",$admin_group_list['list'],'',$admin_group_list['total_page'],$admin_group_list['total_data']);
    }
    /**
    * @Desc 添加管理员
    * @Auther liu
    * @Time 2019-11-9 9:28
    * */
    public function add_admin(Request $request)
    {
        $data['account'] = $request->input('account');
        $data['tel'] = $request->input('tel');
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
        if(SysAdmin::find_sys_admin($where,'id')){
            self::error("此账号已经存在，不能重复添加");
        }
        $data['status'] = 1;
        $data['created_at'] = time();
        $add_admin_info = SysAdmin::add_admin($data);
        if($add_admin_info){
            self::success("添加成功");
        }else{
            self::error("添加失败");
        }
    }
    /**
    * @Desc 修改管理员
    * @Auther liu
    * @Time   2019-11-9 9:50
    * */
    public function edit_admin(request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type'); //1修改 2提交
        if($type == 1) {
            if(!$id) {
                self::error("参数不全");
            }
            //查询后台管理员信息
            $field = ['id','account','admin_group_id'];
            $where_admin['id'] = $id;
            $first_admin = SysAdmin::find_sys_admin($where_admin,$field);
            $first_admin['account'] = substr_replace($first_admin['account'],'****',5,4);
            if($first_admin){
                self::success("请求成功",$first_admin);
            }else{
                self::error("操作有误");
            }
            } else {
            //修改管理员信息
            $data['account'] = $request->input('account');
            $data['admin_group_id'] = $request->input('admin_group_id');
            $data['updated_at'] = time();
            $data['type'] = 1;
            $edit_sys_admin_info = SysAdmin::edit_sys_admin("id",$id,$data);
            if($edit_sys_admin_info){
                self::success("修改成功");
            }else{
                self::error("修改失败");
            }
        }
    }
    /**
    * @Desc 删除管理员
    * @Auther liu
    * @Time 2019-11-9 11:00
    * */

    public function del_admin(request $request)
    {
        $admin_id = $request->input('id');
        if(!$admin_id){
            self::error("missing parameter");
        }
        $admin_data['status'] = '4';  //4删除
        $del_admin_info = SysAdmin::del_sys_admin("id",$admin_id,$admin_data);

        if($del_admin_info){
            self::success("删除成功");
        }else{
            self::error("删除失败");
        }
    }

}

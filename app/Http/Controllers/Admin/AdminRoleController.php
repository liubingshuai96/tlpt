<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminRole;

//角色管理
class AdminRoleController extends Controller
{
    /**
     * @desc 角色列表
     * @author liu
     * @time 2019-11-14
     */
    public function role_list(Request $request)
    {
        $page = $request->input('page',1);
        $page_size = $request->input('page_size');
        $field = array("role_fun.id","role_fun.role_name","role_fun.created_at","role_fun.updated_at","user.user_name as user_name");
        $admin_group_list = AdminRole::select_role($page_size,$page,$field);
        $this->success("请求成功",$admin_group_list['list'],'',$admin_group_list['total_page'],$admin_group_list['total_data']);
    }

    /**
     * @desc 添加角色
     * @time 2019-11-14
     * @author liu
     * @param Request $request
     */
    public function add_role(Request $request)
    {
        $data['id']= $request->input('id');
        $data['user_id']= $request->input('user_id');
        $data['function_id'] = $request->input('function_id');
        $data['role_name'] = $request->input('role_name');
        $data['role_intro'] = $request->input('role_intro');
        if(empty($data['user_id']) || empty($data['role_name']) || empty($data['role_intro']) || empty($data['function_id'] )) {
            self::error('参数不全');
        }
        if(empty($data['role_name']) ) {
            self::error('角色名不能为空');
        }
        //判断角色名是否存在
        $where['role_name'] = $data['role_name'];
        if( AdminRole::find_role_fun($where,'id') ) {
            self::error('角色名已存在，不要重复添加');
        }
        $data['status'] = 1;

        $data['created_at'] = time();
        $add_admin_info = AdminRole::add_role($data);
        if($add_admin_info){
            self::success("添加成功");
        }else{
            self::error("添加失败");
        }
    }

    /**
     * @desc 修改角色
     * @time 2019-11-14
     * @author liu
     * @param Request $request
     */
    public function edit_role(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type'); //1修改
        if($type == 1) {
            if(!$id) {
                self::error('参数不全');
            }
            $field = ['id','role_name','role_intro'];
            $where_role['id'] = $id;
            $first_role = AdminRole::select_role($where_role,$field);
            if($first_role) {
                self::success('请求成功',$first_role);
            } else {
                self::error('请求失败');
            }
        } else {
            $data['role_name'] = $request->input('role_name');
            $data['role_intro'] = $request->input('role_intro');
            $data['updated_at'] = time();
            $data['type'] = 1;
            $edit_role = AdminRole::edit_role('id',$id,$data);
            if($edit_role) {
                self::success('修改成功');
            } else {
                self::error('修改失败');
            }
        }
    }

    /**
     * @desc 删除角色
     * @time 2019-11-14
     * @author liu
     * @param Request $request
     */
    public function del_role(Request $request)
    {
        $role_id = $request->input('id');
        if(!$role_id) {
            self::error('miss');
        }
        //$role_data['status'] = 4;
        $del_role = AdminRole::del_role('id',$role_id);
        if($del_role) {
            self::success('删除成功');
        } else {
            self::error('删除失败');
        }
    }

}

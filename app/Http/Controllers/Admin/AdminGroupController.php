<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminGroup;
use App\Models\MenuAdminAction;
use App\Models\MenuAdminButton;

//后台权限组
class AdminGroupController extends Controller
{

    /**
    * @Desc 菜单栏目
    * @Time
    * @Auther
    * */
    function menu_column()
    {
        //查询第一级菜单栏目
        $one_level_where['level'] = 1;
        $one_level_where['parent_id'] = 0;
        $one_level_field = ['menu_action_id','action_name','level'];
        $info['menu_auth']  = MenuAdminAction::select_menu($one_level_where,$one_level_field);
        //查询第二级菜单栏目
        $two_level_where['level'] = 2;
        $two_level_field = ['menu_action_id','action_name','parent_id','level'];
        $two_level_auth_info = MenuAdminAction::select_menu($two_level_where,$two_level_field);
        //查询三级菜单栏目
        $three_level_where['level'] = 3;
        $three_level_field = ['menu_action_id','action_name','parent_id','level'];
        $three_level_auth_info = MenuAdminAction::select_menu($three_level_where,$three_level_field);

        foreach($info['menu_auth'] as &$value) {
            $one_children = array();
            foreach($two_level_auth_info as &$v){
                if($v['parent_id'] == $value['menu_action_id']){
                    array_push($one_children,$v);
                    foreach($one_children as &$three_value){
                        $two_children = array();
                        foreach($three_level_auth_info as &$three_v){
                            if($three_v['parent_id'] == $three_value['menu_action_id']){
                                array_push($two_children,$three_v);
                            }
                        }
                        $three_value['children'] = $two_children;
                    }
                }
            }
            $value['children'] = $one_children;
        }
        //查询操作权限
        $button_auth = ['btn_id','btn_name','btn_intro'];
        $info['button_auth'] = MenuAdminButton::select_menu_admin($button_auth);
        $this->success("请求成功",$info);
    }
    /**
    * @权限组管理
    * @Time 2019-11-12
    * @Auther liu
    * */
    function permission_group(Request $request)
    {
        $page = $request->input('page',1);
        $page_size = $request->input('page_size');
        $field = array("id","admin_name","desc");
        $admin_group_list = AdminGroup::select_admin_group($page_size,$page,$field);
        self::success("请求成功",$admin_group_list['list'],'',$admin_group_list['total_page'],$admin_group_list['total_data']);
    }
    /**
    * @新增权限组
    * @Time 2019-11-12
    * @Auther liu
    * */
    public function add_permission_group(Request $request)
    {
        $data['admin_name'] = $request->input('admin_name');

        if (!$data['admin_name']) {
            self::error('参数不全');
        }
        $data['menu_permission'] = $request->input('menu_permission');
        $data['button_permission'] = $request->input('button_permission');
        $data['status'] = 1;
        $data['type'] = 2;
        $data['desc'] = $request->input('desc');
        $data['created_at'] = time();
        $add_admin_group_info = AdminGroup::add_admin_group($data);

        if ($add_admin_group_info) {
            self::success("添加成功");
        } else {
            self::error("添加失败");
        }
    }
     /**
     * @修改权限组
     * @Time 2019-11-12
     * @Auther liu
     * */
    public function edit_admin_group(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type'); //1修改 2提交
        if ($type == 1){
            if(!$id){
                self::error("参数不全1");
            }
            //查询当前权限组信息
            $field = ['id','menu_permission','button_permission','admin_name','desc'];
            $where_admin['id'] = $id;
            $first_admin_group = AdminGroup::find_admin_group($where_admin,$field);
            if ($first_admin_group) {
                self::success("请求成功",$first_admin_group);
            } else {
                self::error("操作有误");
            }
            } else {
            $data['id'] = $request->input('id');
            $data['admin_name'] = $request->input('admin_name');
            if (!$data['admin_name']) {
                self::error('参数不全2');
            }
            $data['menu_permission'] = $request->input('menu_permission');
            $data['button_permission'] = $request->input('button_permission');
            $data['desc'] = $request->input('desc');
            $data['updated_at'] = time();
            $edit_admin_group_info = AdminGroup::edit_admin_group("id",$data['id'],$data);
            if($edit_admin_group_info){
                self::success("修改成功");
            } else {
                self::error("修改失败");
            }

        }
    }

     /**
     * @Desc 删除管理组(同时删除管理组底下管理员)
     * @Auther liu
     * @Time 2019-11-13
     * */
    public function del_admin_group(request $request)
    {
        $id = $request->input("id");
        if(!$id){
            self::error("missing parameter");
        }
        //删除管理组
        $admin_group_data['status'] = '4';
        $del_admin_group_info = AdminGroup::edit_admin_group("id",$id,$admin_group_data);
        //删除所属管理员
        $admin_data['status'] = '4';
        $del_admin_info = AdminGroup::del_admin("id",$id,$admin_data);

        if ($del_admin_info || $del_admin_group_info) {
            self::success("删除成功");
        } else {
            self::error("删除失败");
        }
    }



}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    //
    /**
     * @desc 药材列表
     * @author liu
     * @time 2019-11-14
     *
     */
    public function medicine_list(Request $request)
    {
        $page = $request->input('page',1);
        $page_size = $request->input('page_size');
        $field = array("id","medicine_name","medicine_price","desc","created_at","updated_at");
        $admin_group_list = Medicine::select_medicine($page_size,$page,$field);
        $this->success("请求成功",$admin_group_list['list'],'',$admin_group_list['total_page'],$admin_group_list['total_data']);

    }
    /**
     * @desc 增加药材
     * @author liu
     * @time 2019-11-15
     */
    public function add_medicine(Request $request)
    {

        $data['medicine_name'] = $request->input('medicine_name');
        //$data['note']= $request->input('note');
        $data['desc'] = $request->input('desc');
        $data['medicine_price'] = $request->input('medicine_price');
        if(empty($data['medicine_name']) || empty($data['desc']) || empty($data['medicine_price'])) {
            self::error('参数不全');
        }
        if(empty($data['medicine_name'])) {
            self::error('药材名不能为空');
        }
        $where['medicine_name'] = $data['medicine_name'];
        if(Medicine::find_medicine($where,'id')) {
            self::error('药材已存在');
        }
        $data['created_at'] = time();
        $medicine = Medicine::add_medicine($data);
        if($medicine){
            self::success('添加成功');
        } else {
            self::error('添加失败');
        }
    }
    /**
     * @desc 修改药材
     * @author liu
     * @time 2019-11-15
     */
    public function edit_medicine(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type'); //1修改 2提交
        if($type == 1) {
            if(!$id) {
                self::error("参数不全");
            }
            //查询药材信息
            $field = ['id','medicine_name','medicine_price'];
            $where_medicine['id'] = $id;
            $first_medicine = Medicine::find_medicine($where_medicine,$field);

            if($first_medicine){
                self::success("请求成功",$first_medicine);
            }else{
                self::error("操作有误");
            }
        } else {
            //修改药材信息
            $data['medicine_name'] = $request->input('medicine_name');
            $data['medicine_price'] = $request->input('medicine_price');
            $data['updated_at'] = time();
            $data['type'] = 1;
            $edit_sys_admin_info = Medicine::edit_medicine("id",$id,$data);
            if($edit_sys_admin_info){
                self::success("修改成功");
            }else{
                self::error("修改失败");
            }
        }
    }

    /**
     * @param Request $request
     * @desc 删除药材
     * @author liu
     * @time 2019-11-15
     */
    public function del_medicine(Request $request)
    {
        $medicine_id = $request->input('id');
        if(!$medicine_id) {
            self::error('请输入正确的内容');
        }
        $medicine_data['status'] = 4;
        $del_medicine = Medicine::del_medicine('id',$medicine_id,$medicine_data);
        if($del_medicine) {
          self::success('删除成功');
        } else {
            self::error('删除失败');
        }
    }
}

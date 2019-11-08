<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @用户管理页面
     * @time 2017-11-8
     *
     */
    public function user_mange(Request $request)
    {
        $where['user.status'] = 1;
        $name = $request->input('user_name');
        $tel = $request->input('tel');
        $idcard = $request->input('idcard');
        $created_at = $request->input('created_at');
        $updated_at = $request->input('uodated_at');
        if($created_at) {
            $created_at =strtotime($created_at,'00:00:00');
        }
        if($updated_at) {
            $updated_at = strtotime($updated_at,"23:59:59");
        }
        $page = $request->input('page',1);
        $page_size = $request->input('page_size');
        $field = array('user.id','user.name','user.idcard','user.account');
        $user_info = User::select_user_info($name,$tel,$idcard,$created_at,$updated_at,$where,$page_size,$page,$field);
        self::success("请求成功",$user_info['list'],'',$user_info['total_page'],$user_info['total_data']);


    }

}

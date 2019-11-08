<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SysAdmin;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{

    //后台登录
    public function admin_login(Request $request)
    {
        $account = $request->input('account');
        $password =$request->input('password');
        $captcha = $request->input('code');
        if (empty($account) || empty($password) || empty($captcha)) {
            self::error("参数不全");
        }
        $admin_info = SysAdmin::find_admin($account,$password,$captcha);

        if(empty($admin_info)){
            self::error('账号或密码不对');
        }
        self::success($admin_info,'success');
/*
        //判断
        if (empty($admin_info)) {
            self::error('账号不存在');
        }elseif(md5($admin_info['password']) != $password){
            self::error('账号或密码不正确');
        }else{
            self::success('登录成功');
        }*/

    }


    /**
     * 管理员退出登录
     * datetime 2019-11-8
     * author liu
     * @param Request $request
     */
    function admin_quit(Request $request){

        $reg = $request->input('id');
        $request->has('user',$reg,null);
        self::success($reg,'request successful');
    }
}

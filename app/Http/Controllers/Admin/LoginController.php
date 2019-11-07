<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SysAdmin;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    //
    protected $sys_admin_obj;

    public function __construct( )
    {
        $this->sys_admin_obj = new SysAdmin();
    }
    //后台登录
    public function admin_login(Request $request)
    {
        $account = $request->post('account');
        $password =$request->post('password');

       if (empty($account) || empty($password)) {
            self::error("参数不全");
        }
        $admin_info = SysAdmin::find_admin($account);
        return $admin_info;
 /*       if (empty($admin_info)) {
            self::error('账号不存在');
        }else if(md5($admin_info['password'].'qaz123') != $password){
            self::error('账号或密码不正确');
        }else{

        }*/
    }
    /**
     * 管理员退出登录
     * datetime 2019-11-7
     * author liu
     * @param Request $request
     */
    function admin_quit(Request $request){

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SysAdmin;
use Illuminate\Http\Request;
use Session;
//登录管理
class LoginController extends Controller
{
    /**
     * @desc 管理员登录
     * @datetime 2019-11-8
     * @author liu
     * @param Request $request
     */
    public function admin_login(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');

        if (empty($account) || empty($password)) {
            self::error("参数不全");
        }
        $admin_info = SysAdmin::find_admin($account, $password);

        if (empty($admin_info)) {
            self::error('账号或密码不对');
        }
        self::success($admin_info, 'success');
    }
    /**
     * @desc 管理员退出登录
     * @datetime 2019-11-8
     * @author liu
     * @param Request $request
     */
    function admin_quit(Request $request)
    {
        $reg = $request->input('id');
        $request->has('user',$reg,null);
        self::success($reg,'request successful');
    }
}

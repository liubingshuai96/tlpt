<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    //
    public function user(Request $request)
    {
        $name = $request->post('user_name');
        $pass = $request->post('password');
        if(empty($name) || empty($pass)){
            self::failed('no message');
        }
        $result = User::find_user_account($name,$pass);
        $password =isset($result['password'])?$result['password']:'xxx';
        $password = md5($password.'123');
        if(empty($result)) {
            self::failed('账户不存在');
        }
        if($pass == $password){
            $result['id'] = $result['user_id'];
            unset($result['password']);

            self::success('login success',$result);
        }
        else{
            self::failed('账号或密码不正确');
        }



    }
}

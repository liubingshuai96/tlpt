<?php

namespace App\Models;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Database\Eloquent\Model;

class SysAdmin extends Model
{
    //
    protected $table = 'sys_admin';
    //数据库主键
    public $primaryKey = 'id';
    public $dateFormat = 'U';
    public $timestamps = false;
    /**
     * 通过账号查询用户
     * datetime 2019-11-7
     * author liu
     */
    public static function find_admin($account)
    {
        $result = self::where('account',$account)->where('status',1)->first();
        $result = object_to_array($result);
        return $result;
    }

}

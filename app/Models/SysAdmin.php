<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use session;
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
        $res = object_to_array($result);
        return $res;
    }

    /**
     * datetime 2019-11-8
     * author liu
     * @return mixed
     */
    public static function login_out($status)
    {
        $array = array('status'=>2,$status);
        $out = self::where('id',session::get('account')->update($array));
        return $out;
    }
}

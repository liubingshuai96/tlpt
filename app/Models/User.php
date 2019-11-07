<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    /**
     * 查找用户账号
     * @param $account 账号
     * @param $password 密码
     */
    public function find_user_account($account,$password)
    {
        $field = ['id','user_name','password','real_name','update_at'];
        $result = self::where('$user_name',$account)->select($field)->where('status',1)->first();
        $result = object_to_array($result);
        return $result;
    }
}

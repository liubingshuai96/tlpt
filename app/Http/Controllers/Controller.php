<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * 返回统一格式的json信息
     * @param null $message 返回信息
     * @param null $data 返回数据
     * @param string $error_code 1111:登录失效
     * @param string $total_page 总页数
     * @return array
     */
    public static function success($message=null,$data=null,$error_code='0000',$total_page=null,$total_data=null,$extra=null,$button=null)
    {
        $results = array();
        $results['flag'] = 'success';
        $results['message'] = $message;
        $results['error_code'] = $error_code ? $error_code : '0000';
        if($total_page){
            $results['total_page'] = $total_page;
        }
        if(isset($total_data)){
            $results['total_data'] = $total_data;
        }
        if($data==null)
        {
            $results['data']=[];
        } else {
            $results['data'] = $data;
        }
        if(!empty($extra)){
            $results['extra'] = $extra;
        }
        if(!empty($button)){
            $results['auth'] = $button;
        }
        exit(json_encode($results));

    }


    /**
     * 返回统一格式的json信息
     * @param null $message 返回信息
     * @param null $data 返回数据
     * @param string $error_code 1111:登录失效
     * @param string $total_page 总页数
     * @return array
     */
    public static function error($message=null,$data=null,$error_code='9999',$total_page =null)
    {
        $results = array();
        $results['flag'] = 'error';
        if($total_page){
            $results['total_page'] = $total_page;
        }
        $results['message'] = $message;
        $results['error_code'] = $error_code ? $error_code : '9999';
        if($data==null)
        {
            $results['data']=[];
        } else {
            $results['data'] = $data;
        }
        exit(json_encode($results));
    }
}

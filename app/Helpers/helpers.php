<?php
/**
 * @desc Object转Array数组
 * @param Object对象
 * @return Array数组
 */
function object_to_array($object)
{
    $result = [];
    if($object){
        $result = json_decode(json_encode($object),true);
    }
    return $result;
}

/**
 * xml转化为数组
 * @param $xml
 */
function xml_to_array($xml)
{
    $result = [];
    if($xml){
        $object = simplexml_load_string($xml);
        $result = json_decode(json_encode($object),true);
    }
    return $result;
}

/**
 * 检测电话号码是否有效
 * @param
 * @param
 */
function is_valid_telephone($telephone)
{
    $rule = '/^1[23456789]\d{9}$/';
    if(empty($telephone)){
        return false;
    }
    if(preg_match($rule, $telephone)){
        return true;
    }
    else{
        return false;
    }
}

/**
 * 拼接图片域名
 * @param $pic 图片
 * @param $default_pic 默认图片
 */
function return_image_pic($pic,$default_pic)
{
    if(empty($pic)){
        return (env('APP_URL') . $default_pic);
    }
    if(strpos($pic, "http") === 0){
        return $pic;
    }
    else{
        return (env('APP_URL') . $pic);
    }
}

/**
 * 秘钥验证
 * @param $phone 电话
 * @param $send_class 发送类型
 */
function return_secret_key($phone,$send_class)
{
    return md5(md5($phone.$send_class).'qaz123');
}

/**
 * 随机生成4位数字
 * @param $flag 字母/数字
 * @param $num 位数
 * @param
 */
function random_code($flag = '', $num = 0)
{
    /**获取验证标识**/
    $arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',1,2,3,4,5,6,7,8,9,0);
    $vc = '';
    //字符串
    if($flag == 'char'){
        for($i = 0; $i < $num; $i++){
            $index = rand(0,61);
            $vc .= $arr[$index];
        }
    }elseif($flag == 'num'){  //数字
        for($i = 0; $i < $num; $i++){
            $index = rand(52,61);
            $vc .= $arr[$index];
        }
    }
    return $vc;
}

/**
 * @Desc 打印
 * */
function print_d($value)
{
    echo "<pre>";
    print_r($value);
    exit;
}

/*
 * @Desc 获取当天开始和结束时间

 * */
function get_start_and_end_time()
{
    $date = date('Y-m-d',time());
    $data['begin_time'] = strtotime($date." 00:00:00");
    $data['end_time'] = strtotime($date." 23:59:59");
    return $data;
}
/*
 * @Desc 获取几天前开始和结束时间

 **/
function get_few_days_ago($days=1)
{
    $begin_date = date("Y-m-d",strtotime("-".$days." day"))." 00:00:00";
    $data['begin_time'] = strtotime($begin_date);
    $end_date = date("Y-m-d",strtotime("-".$days." day"))." 23:59:59";
    $data['end_time'] = strtotime($end_date);
    return $data;
}

/**
 * @desc 冒泡排序(正序)

 * @param $array 要排序的数组
 * @param $key 要排序的键值
 * @return
 */
function  bubble_asc_sort($array,$key)
{
    $array_count = count($array);
    for($i=0; $i<$array_count; $i++){
        for($j=($array_count-1);$j>$i;$j--){
            if($array[$j][$key] < $array[$j-1][$key]){
                $temp = $array[$j];
                $array[$j] = $array[$j-1];
                $array[$j-1] = $temp;
            }
        }
    }
    return $array;
}


/**
 * @desc 冒泡排序(倒序)
 * @author duxiangyang
 * @time 2017/11/28 18:20
 * @param $array 要排序的数组
 * @param $key 要排序的键值
 * @return
 */
function  bubble_desc_sort($array,$key){
    $array_count = count($array);
    for($i=0; $i<$array_count; $i++){
        for($j=($array_count-1);$j>$i;$j--){
            if($array[$j][$key] > $array[$j-1][$key]){
                $temp = $array[$j];
                $array[$j] = $array[$j-1];
                $array[$j-1] = $temp;
            }
        }
    }
    return $array;
}



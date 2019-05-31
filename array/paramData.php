<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31
 * Time: 10:30
 */

/**
 * 从给到的[Array]$params中根据[Array]$need参数，提取需要的数据组
 * @param array $params 来源组【原始数组】
 * @param array $need 需求组【复合数组】[string][key]||[array][key=>value]|[key=>[method,param]]
 * @return array
 */
function param_data($params,$need) {
    $data = [];
    foreach ($need as $item) {
        if(is_array($item)) {
            $data = param_need($params,$item,$data);
        } else {
            $data[$item] = paramKey($params,$item);
        }
    }
    return $data;
}

/**
 * 从给到的[Array]$params中根据[Array]$need参数获取需要的数据
 * @param array $params
 * @param array|string $need
 * @param string $data
 * @param bool $arr
 * @return string|array
 */
function param_need($params,$need,$data='',$arr=true) {
    list($key,$default) = to_list($need);
    if(!is_array($default)) {
        $data[$key] = paramHad($key,$params,$default);
    } else {
        list($method,$param) = to_array($default);
        $data[$key] = paramHad($key,$params);
        $data[$key] = by_func([$data[$key]],$method,$param);
    }
    return $arr ? $data : $data[$key];
}


//借助借助方法
function paramKey($param,$key,$default='',$must=true,$msg=' 无有效值'){
    $keys = explode('|',$key);
    $key = $keys[0];
    $keyName = count($keys)>1? $keys[1] : $key;
    $msg = count($keys)>2? $keys[2] : $msg;
    $value = key_exists($key,$param)
        ? ($param[$key]!==''? $param[$key] : ($default!==''? $default : ''))
        : ($default!==''? $default : '');
    if($value==='' && $must) exception($keyName.$msg);
    return $value;
}
function paramHad($key,$param,$default='') {
    return paramKey($param,$key,$default,false);
}
function to_array($data,$delimiter=','){
    if(is_array($data)) return $data;
    $arr = explode($delimiter,$data);
    foreach($arr as $k=>$v){
        $arr[$k] = is_array($v)? $v : trim($v);
    }
    return $arr;
}

/**
 * 判断是否为整数数据
 * @param $age
 * @return bool
 */
function be_int($age) {
    if(!is_numeric($age)||strpos($age,".")!==false){
        return false;   //echo "不是整数";
    }else{
        return true;    //echo "是整数";
    }
}

/**
 * 数组键值对变同维数组值
 * @param $data
 * @return array
 */
function to_list($data) {
    $get = $data;
    $data = to_array($data);
    $list = [];
    foreach ($data as $key=>$value) {
        if(be_int($key)) continue;
        $list[] = $key;
        $list[] = $value;
    }
    null_unset($data);
    return $list ?: [$get,''];
}

/**
 * 引用外部方法处理给定数据
 * @param $data
 * @param $method
 * @param $param
 * @return mixed
 */
function by_func($data,$method,$param) {
    return $method
        ? call_user_func_array($method,
        $param
                ? array_merge([$data],$param)
                : [$data]
            )
        : $data;
}

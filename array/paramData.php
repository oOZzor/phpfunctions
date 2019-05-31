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

/**
 * 替换|移除源数组$arr中的$rep指定的键名|数据
 * @param array $arr
 * @param array $rep [key1=>field1|'',key2=>field2|'',,,]
 * @param bool $sort 是否保持源次序
 * @return array
 */
function key_replace($arr,$rep,$sort=false) {
    if($sort) {
        $data = [];
        foreach ($arr as $key=>$item) {
            if(key_exists($key,$rep)) {
                if($rep[$key]) $data[$rep[$key]] = $item;
            } else {
                $data[$key] = $item;
            }
        }
        null_unset($arr);
        null_unset($rep);
        return $data;
    } else {
        foreach ($rep as $key=>$field) {
            if(key_exists($key,$arr)) {
                if($field) {
                    $arr[$field] = $arr[$key];
                }
                unset($arr[$key]);
            }
        }
        null_unset($rep);
        return $arr;
    }
}

//借助借助方法

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

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/17
 * Time: 16:56
 */


/**
 * 获取参数指定字段对应键值
 * @param $param
 * @param $key
 * @param mixed $default
 * @param bool $must
 * @param string $msg
 * @return string
 * @throws Exception 不存在对应键值则
 */
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



/**
 * 缓存|选项转数据对
 * @param $data
 * @param string $cacheName
 * @return array
 */
function list2option($data,$cacheName='') {
    $option = $cacheName? cache($cacheName) : [];
    if(empty($option)) {
        if(!empty($data) && is_array($data)) {
            $option = [];
            foreach ($data as $datum) {
                $datum = array_values($datum);
                $option[$datum[0]] = $datum[1];
            }
            if($cacheName) cache($cacheName,$option,3600);
        }
    }
    return $option;
}

/**
 * 数据对转选项|并缓存
 * @param $data
 * @param string $cacheName 缓存名
 * @param array $key 选项名
 * @return array
 */
function data2list($data,$cacheName='',$key=['value','name']) {
    $list = $cacheName? cache($cacheName) : [];
    if(empty($list)) {
        if(!empty($data) && is_array($data)) {
            list($k1,$k2) = $key;
            foreach ($data as $k=>$v) {
                $list[] = [
                    $k1 => $k,
                    $k2 => $v
                ];
            }
            if($cacheName) cache($cacheName,$list,3600);
        }
    }
    null_unset($data);
    return $list;
}

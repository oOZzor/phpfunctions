<?php

/**
 * 数据处理方法
 */




/**
 * //随机返回给定数据指定个数据 type: val返回值，key返回键，item返回键值对
 * @param $arr
 * @param int $num
 * @param int $type
 * @return array|mixed|string
 */
function value_rand($arr,$num=1,$type=0) {
    $data = '';
    if(empty($arr)) return '';
    if(!$num || !in_array($type,['val','key','item'])) return $arr;
    $arr = to_array($arr);
    if(count($arr)<=$num && $type=='item') return $arr;
    $key = array_rand($arr,$num);
    $value = $num==1? $arr[$key] : [];
    switch ($type) {
        case 'val':
            $data = $value;
            if($num>1) {
                foreach ($arr as $k=>$v) {
                    if(in_array($k,$key)) $data[] = $v;
                }
            }
            break;
        case 'key':
            $data = $key;
            break;
        case 'item':
            if($num==1) {
                $data = [$key=>$value];
            } else {
                foreach ($arr as $k=>$v) {
                    if(in_array($k,$key)) $data[$k] = $v;
                }
            }
            break;
    }
    null_unset($arr);
    null_unset($key);
    return $data;
}



/**
 * 从数组里获取指定字段的最小值
 * @param $arr
 * @param $field
 * @return mixed
 * @author machaoyi
 */
function getArrayMin($arr, $field){
    $temp = [];
    foreach($arr as $k=>$v){
        $temp[] = $v[$field];
    }
    return min($temp);
}


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
 * 判断若是字符串则转数组 [确保提供数据是数组形式]
 * @param $data
 * @param string $delimiter
 * @return array
 */
function to_array($data,$delimiter=','){
    if(is_array($data)) return $data;
    $arr = explode($delimiter,$data);
    foreach($arr as $k=>$v){
        $arr[$k] = is_array($v)? $v : trim($v);
    }
    return $arr;
}

/**
 * 判断是数组则转为字符串 [确保提供数据为字符串形式]
 * @param $data
 * @param string $glue
 * @return string
 */
function to_string($data,$glue=','){
    if(!is_array($data)) return $data;
    return implode($glue,$data);
}

/**
 * 特殊数组转字符串 [数据库原生语句 UNION ALL 查询]
 * @param $data
 * @param string $glue
 * @return string
 */
function union_string($data,$glue='t'){
    if(!is_array($data)) return $data;
    $string = '';
    $count = count($data)-1;
    foreach ($data as $k=>$datum) {
        $as = $glue.$k;
        $string .= ' SELECT * FROM ('.$datum.") $as" . ($k<$count? ' UNION ALL ' : '');
    }
    return $string;
}

/**
 * 去除二维数组指定字段
 * @param $arr array 需处理数组
 * @param $key string|array 指定字段
 * @param bool $retain 是否保留原键名
 * @return array|null
 */
function array_remove_key($arr,$key,$retain=false) {
    if(empty($arr) || !$key) return $arr;
    $data = [];
    foreach ($arr as $k=>$item) {
        foreach (to_array($key) as $k)
        {
            if(key_exists($k,$item)) {
                unset($item[$k]);
            }
        }
        $retain
            ? $data[$k] = $item
            : $data[] = $item;
    }
    $arr=null;unset($arr);
    return $data;
}

/**
 * 去处数组中指定的键值的数据
 * @param $arr
 * @param $keys
 * @return mixed
 */
function array_move_keys($arr,$keys) {
    if(empty($arr) || !$keys) return $arr;
    foreach ($keys as $key) {
        if(key_exists($key,$arr))
            unset($arr[$key]);
    }
    return $arr;
}
/**
 * $arr2 融入 $arr1 [根据配比键$key1,为$key2填充] $key1可为空
 * @param array $arr1
 * @param array $arr2
 * @param string $key1
 * @param string $key2
 * @param string $default 无匹配数据填值
 * @param string $method 可选，对匹配数据的外部方法处理引用
 * @param array $param 配合$method 额外的方法参数
 * @return array
 */
function array_assimilate($arr1,$arr2,$key1,$key2,$default='',$method='',$param=[]) {
    $data = [];
    foreach ($arr1 as $key=>$item) {
        //数据融入匹配
        $item[$key2] = $key1
            ? (key_exists($item[$key1],$arr2)? $arr2[$item[$key1]] : $default)
            : (key_exists($key,$arr2)? $arr2[$key] : $default);
        //外部方法处理引入
        if($method && $item[$key2]) {
            $item[$key2] = call_user_func_array($method,
                $param
                    ? array_merge([$item[$key2]],$param)
                    : [$item[$key2]]
            );
        }
        $data[$key] = $item;
    }
    $arr1=null;unset($arr1);
    $arr2=null;unset($arr2);
    return $data;
}

/**
 * 将数组根据指定健名值 重新分组【新增一个维度】
 * @param array $arr
 * @param string $key 根据此指定键名[在给定数组中对应键值存在重复出现]
 * @param bool $remove 重分组数据是否去除用于参考分组的指定原健值对
 * @param string|array $valKey 重新分组后的取值处理 引用外部处理方法|或带额外常量参数
 * @return array
 */
function array_groupBy_key($arr,$key,$remove=false,$valKey='') {
    $data = [];
    foreach ($arr as $item) {
        $data[$item[$key]][] = $valKey
            ? (is_array($valKey) ? (call_user_func_array($valKey[0],[$item,$valKey[1]])) : $item[$valKey])
            : (!$remove? $item : array_diff_key($item,[$key=>'']));
    }
    $select=null;unset($select);
    return $data;
}

/**
 * 数组数据处理|提取
 * @param string $key 将数组的主键值替换为字段名为$key的值
 * @param array $oldArray 多维数组数据
 * @param string $value 配合$key值，提取出[$key]=>[$value]的新数组
 * @return array
 * @throws \Exception tp5内置抛出异常的方法
 */
function array_add_key($key,$oldArray,$value='')
{   if(empty($oldArray)) return $oldArray;
    if(!array_key_exists($key,$oldArray[0]))
        exception("数据置键处理出错[不存在的键：$key]");
    if(!empty($value) && !is_array($value) && !array_key_exists($value,$oldArray[0]))
        exception("数据置键处理出错[不存在的键：$value]");
    $valueArray = empty($value)
        ? $oldArray
        : ( is_array($value)? $value : array_column($oldArray,$value) );
    return array_combine(array_column($oldArray,$key),$valueArray);
}

/**
 * 可选设值字段挑出
 * @param array $param 给定参数组
 * @param array $fields 提取数据键名数组
 * @return array 返回$param中包含给定键名$fields【有则取，无则略】的键值对子集数组数据
 */
function may_data($param,$fields) {
    $data = [];
    foreach ($fields as $field) {
        if(key_exists($field,$param)) $data[$field] = $param[$field];
    }
    return $data;
}

/**
 * 提取指定键名得键值对组数据
 * @param array $param
 * @param array $fields [key1,key2=>field2,key3,,,]
 * @return array
 */
function extract_data($param,$fields) {
    $data = [];
    foreach ($fields as $key=>$field) {
        $key = be_int($key)? $field : $key;
        if(key_exists($key,$param)) $data[$field] = $param[$key];
    }
    return $data;
}


/**
 * 清空给定数据【缓存\数组指定键值对】
 * @param array|string|object $obj
 * @param string $key
 * @return bool|null
 */
function null_unset($obj,$key=''){
    if(!$key) {
        $obj=NULL;unset($obj);return true;
    }
    $obj[$key]=NULL;unset($obj[$key]);
    return $obj;
}


/**
 * xml转换到数组
 * @param $xml
 * @return mixed
 */
function XML2Array($xml) {
    normalizeSimpleXML(simplexml_load_string($xml, null, LIBXML_NOCDATA), $result);
    return $result;
}
function normalizeSimpleXML($obj, &$result) {
    $data = $obj;
    if (is_object($data)) {
        $data = get_object_vars($data);
    }
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $res = null;
            normalizeSimpleXML($value, $res);
            if (($key == '@attributes') && ($key)) {
                $result = $res;
            } else {
                $result[$key] = $res;
            }
        }
    } else {
        $result = $data;
    }
}

/**
 * 数组生成xml
 * @param array $arr
 * @return string
 */
function array2xml(array $arr) {
    $xml = "<xml>";
    foreach ($arr as $key => $val) {
        if ($val) {
            $xml .= "<{$key}>{$val}</{$key}>";
        }
    }
    $xml .= "</xml>";
    return $xml;
}

/**
 * 判断参数是否不为空
 * @param $param
 * @param $key
 * @return bool
 * @author machaoyi
 */
function isNotEmpty($param, $key){
    return isset($param[$key]) && !empty($param[$key]);
}

/**
 * stdClass转换成数组
 * @param $data
 * @return array
 */
function stdc2array($data) {
    $ret = array();
    foreach ($data as $key => $val) {
        $ret[$key] = $val;
    }
    return $ret;
}

/**
 * 数组 转 对象
 *
 * @param array $arr 数组
 * @return object
 */
function array_to_object($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)array_to_object($v);
        }
    }

    return (object)$arr;
}

/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 * @return array
 */
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }

    return $obj;
}

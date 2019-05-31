<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31
 * Time: 11:36
 */

//define('URL', 'http://api.guanyierp.com/rest/erp_open');
//define('APPKEY', '140233');
//define('SESSIONKEY', 'ba0f24003ff04c9488bbe85eb3560f53');
//define('SECRET', 'd569dd0a1b1c404ca1d188277d209dfe');
//
////获取信息
//public function getData($param)
//{
//    $data['appkey'] = APPKEY;
//    $data['appkey'] = SESSIONKEY;
//    $data['method'] = 'items.get';
//    $data['page_no'] = $param['page_no'] ?: '1';
//    $data['page_size'] = $param['page_size'] ?:'10';
//    $data['sign'] = sign($data, SECRET);
//    echo 'response: ' . mycurl(URL, $data);
//}

/**
 * 管易云对外接口连接简单实现
 * @param $url
 * @param $data
 * @return mixed
 */
function mycurl($url, $data)
{
    $data_string = json_encode_ch($data);
//        echo 'request: ' . $data_string . "\n";
    $data_string = urlencode($data_string);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type:text/json;charset=utf-8',
        'Content-Length:' . strlen($data_string)
    ));
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}


/**
 * @param $data
 * @param $secret
 * @return string
 * 管易云签名
 */
function sign($data, $secret)
{
    if (empty($data)) {
        return "";
    }
    unset($data['sign']); //可选，具体看传参
    $data = json_encode_ch($data);
    $sign = strtoupper(md5($secret . $data . $secret));
    return $sign;
}

function json_encode_ch($arr)
{
    return urldecode(json_encode(url_encode_arr($arr)));
}

function url_encode_arr($arr)
{
    if (is_array($arr)) {
        foreach ($arr as $k => $v) {
            $arr[$k] = url_encode_arr($v);
        }
    } elseif (!is_numeric($arr) && !is_bool($arr)) {
        $arr = urlencode($arr);
    }
    return $arr;
}


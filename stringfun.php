<?php

/**
 * 字符串处理方法
 */

/**
 * 生成随机字符串
 * @param string $prefix
 * @return string
 */
function get_random($prefix = '') {
    return $prefix . base_convert(time() * 1000, 10, 36) . "_" . base_convert(microtime(), 10, 36) . uniqid();
}

/**
 * 生成指定长度的随机大小英文字母与数字混合的字符串
 * @param $length
 * @return null|string
 */
function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol)-1;

    for($i=0; $i<$length; $i++){
        $str .=$strPol[rand(0,$max)];
    };

    return $str;
}


/**
 * 生成指定长度的随机纯大小英文字母字符串
 * @param $length
 * @return null|string
 */
function getRandLetter($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol)-1;

    for($i=0; $i<$length; $i++){
        $str .=$strPol[rand(0,$max)];
    };

    return $str;
}



/**
 * 通过时间戳生成流水号，格式：年月日时分秒毫秒数前四位 流水号类型两位 年份两位 月份两位 日期两位 时两位 分两位 秒两位 毫秒四位。总共 16 位
 * @param string $suffix
 * @return string
 * @author machaoyi
 */
function serialNumber($suffix){
    // 获取当前毫秒数
    list($usec, $sec) = explode(" ", microtime());
    // 毫秒数取前4位数
    return $suffix.date('ymdHis').substr(explode('.', $usec)[1], 0, 4);
}


/**
 * 使用两次md5加密密码
 * @param $original
 * @return string
 * @author machaoyi
 */
function encryptPassword($original){
    return md5(md5($original));
}



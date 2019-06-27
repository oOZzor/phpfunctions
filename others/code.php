<?php
/**
 * Created by PhpStorm.
 * User: VULCANTSeries
 * Date: 2019/6/28
 * Time: 1:28
 */


/**
 * 编码格式转为utf-8
 * @param $value
 * @return string
 */
function codeToUtf8($value)
{
    if(mb_detect_encoding($value, 'UTF-8') !== 'UTF-8') {
        $encodes = array("ASCII","GB2312","GBK","UTF-8");
        $encode = mb_detect_encoding($value, $encodes);
        $value = iconv($encode, "UTF-8//IGNORE", $value);
    }
    return $value;
}



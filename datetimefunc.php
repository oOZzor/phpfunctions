<?php
/**
 * Created by PhpStorm.
 * User: VULCANTSeries
 * Date: 2019/5/27
 * Time: 1:35
 */

/**
 * 时间处理方法
 */


//[今天|某天]以前*天的日期
function get_preDate($day=1,$date='') {
    $date = $date? strtotime($date) : now();
    return $day
        ? date("Y-m-d",strtotime("- $day days",$date))
        : date('Y-m-d');
}

/**
 * 获取指定日期（默认当天）的昨日日期
 * @param string $date
 * @return false|string
 */
function get_yesterday($date='')
{
    if(!$date) return date("Y-m-d",strtotime("- 1 days",time()));

    return date("Y-m-d",strtotime("- 1 days",strtotime($date)));
}


/**
 * 获取当前时间
 * @return [type] [description]
 */
function now() {
    return date('Y-m-d H:i:s');
}


/**
 * 获取毫秒数
 * @return [type] [description]
 */
function millisecond() {
    list($s1, $s2) = explode(' ', microtime());
    return (float) sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}



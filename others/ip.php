<?php
/**
 * Created by PhpStorm.
 * User: VULCANTSeries
 * Date: 2019/6/28
 * Time: 1:30
 */


//tp5框架内
function ip_info($ip='')
{
    $ip = $ip ?: request()->ip();
    $url='http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
    $result = file_get_contents($url);
    $result = json_decode($result,true);
    dump($result);
}


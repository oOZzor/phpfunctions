<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/20
 * Time: 19:02
 */


function time2datetime ($arr) {
    list($st,$end) = $arr;
    return [
        date('Y-m-d H:i:s',$st),
        date('Y-m-d H:i:s',$end)
    ];
}

//Time:: use think\helper\Time;
function timez() {

    // 今日开始和结束的时间戳
    p(time2datetime(Time::today()));

    // 昨日开始和结束的时间戳
    p(time2datetime(Time::yesterday()));

    // 本周开始和结束的时间戳
    p(time2datetime(Time::week()));

    // 上周开始和结束的时间戳
    p(time2datetime(Time::lastWeek()));

    // 本月开始和结束的时间戳
    p(time2datetime(Time::month()));

    // 上月开始和结束的时间戳
    p(time2datetime(Time::lastMonth()));

    // 今年开始和结束的时间戳
    p(time2datetime(Time::year()));

    // 去年开始和结束的时间戳
    p(time2datetime(Time::lastYear()));

    // 获取7天前零点到现在的时间戳
    p(time2datetime(Time::dayToNow(7)));

    // 获取7天前零点到昨日结束的时间戳
    p(time2datetime(Time::dayToNow(7, true)));

    // 获取7天前的时间戳
    p(time2datetime(Time::daysAgo(7)));

    //  获取7天后的时间戳
    p(time2datetime(Time::daysAfter(7)));

    // 天数转换成秒数
    p(time2datetime(Time::daysToSecond(5)));

    // 周数转换成秒数
    p(time2datetime(Time::weekToSecond(5)));

}
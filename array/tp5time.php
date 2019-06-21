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
    p(Time::daysAfter(7));

    // 天数转换成秒数
    p(Time::daysToSecond(5));

    // 周数转换成秒数
    p(Time::weekToSecond(5));

}
//timez() 输出结果：
//<pre>Array
//(
//    [0] => 2019-06-21 00:00:00
//    [1] => 2019-06-21 23:59:59
//)
//<pre>Array
//(
//    [0] => 2019-06-20 00:00:00
//    [1] => 2019-06-20 23:59:59
//)
//<pre>Array
//(
//    [0] => 2019-06-17 00:00:00
//    [1] => 2019-06-23 23:59:59
//)
//<pre>Array
//(
//    [0] => 2019-06-10 00:00:00
//    [1] => 2019-06-16 23:59:59
//)
//<pre>Array
//(
//    [0] => 2019-06-01 00:00:00
//    [1] => 2019-06-30 23:59:59
//)
//<pre>Array
//(
//    [0] => 2019-05-01 00:00:00
//    [1] => 2019-05-31 23:59:59
//)
//<pre>Array
//(
//    [0] => 2019-01-01 00:00:00
//    [1] => 2019-12-31 23:59:59
//)
//<pre>Array
//(
//    [0] => 2018-01-01 00:00:00
//    [1] => 2018-12-31 23:59:59
//)
//<pre>Array
//(
//    [0] => 2019-06-14 00:00:00
//    [1] => 2019-06-21 11:46:45
//)
//<pre>Array
//(
//    [0] => 2019-06-14 00:00:00
//    [1] => 2019-06-21 11:46:45
//)
//int(1560484005)
//int(1561693605)
//int(432000)
//int(3024000)
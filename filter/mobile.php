<?php
/**
 * Created by PhpStorm.
 * User: VULCANTSeries
 * Date: 2019/6/28
 * Time: 1:05
 */



function is_mobile( $text ) {
    $search = '/^0?1[3|4|5|6|7|8][0-9]\d{8}$/';
    return preg_match( $search, $text ) == 1;
}






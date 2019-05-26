<?php
$print = 'print test';
print("a $print");

//test print_r
$array = array('aa','ss','dd','ff','dd','gg','ds');
print_r($array);


/**
 * 打印数据
 * @param $input
 */
function p($input){
    if(is_array($input)){
        echo '<pre>';
        print_r($input);
    }else if(gettype($input) == 'object'){
        var_dump(json_encode($input));
    }else{
        var_dump($input);
    }
}







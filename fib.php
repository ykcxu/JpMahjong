<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 下午6:33
 */
for ($i=1;$i<10;$i++){
    echo a::fib($i)."\n";
}
class a{
 public static function fib($int){
    if ($int<=2) return 1;
    $result = a::fib($int-1)+a::fib($int-2);
    return $result;
}
}
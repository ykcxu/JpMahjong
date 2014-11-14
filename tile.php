<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 下午12:54
 */

class tile {
   var $type = "";//类型  p,s,m,z
   var $num = 0;//数目
    function tile($k="empty",$n=0){
        $this->type = $k;
        $this->num = $n;

    }
    function name(){
        return $this->num.$this->type;
    }

}
#禁用tile类，使用1-34代替指定牌


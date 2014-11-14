<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 下午12:54
 */

class tile {
   var $type = "";
   var $num = 0;
    function tile($k="empty",$n=0){
        $this->type = $k;
        $this->num = $n;

    }
    function name(){
        return $this->num.$this->type;
    }

}


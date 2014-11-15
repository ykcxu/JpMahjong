<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 下午12:54
 */
#echo tile::numtoword(11);

class tile {
  public static function numtoword($num){
      $value =array(
          "m",
          "p",
          "s",
          "z",
      );
      $a = (int)(($num-1)/9);
      $b = $num%9;
      if ($b==0) $b=9;
      $result = ($b).$value[$a];
      return $result;
  }

}
#禁用tile类，使用1-34代替指定牌


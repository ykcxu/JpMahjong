<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 上午9:42
 */
require_once "./tile.php";
require_once "./pairs.php";

#echo json_encode($hands=hands::readString("1111s222z333w"));
#$a = new tile("z",2);
#$hands=hands::delTile($hands,$a);
#echo hands::haveTile($hands,$a);
#echo json_encode($hands);
class hands {
    public static function readString($string){
        $tmpstring = array();
        foreach (str_split($string) as $i){
            if (($i>0) and ($i<=9)) array_push($tmpstring,$i);
            else {
                foreach ($tmpstring as $j) $hand["$j$i"]+= 1;
                $tmpstring = array();
            }
        }
        return $hand;
    }
    public static function havePairs($hands,$pairs){
        #判断手牌中是否有某个搭子
        foreach($pairs as $tile)
        {
            if  (hands::haveTile($hands,$tile)==0) return 0;
            $hands=hands::delTile($hands,$tile);
        }
        return 1;
    }
    public static function delPairs($hands,$pairs){
        foreach($pairs as $tile)
        {
           $hands=hands::delTile($hands,$tile);
        }
        return $hands;
    }
    public static function haveTile($hands,$tile){
        #判断手牌是否有某个牌
        $name = $tile->name();
        if ($hands["$name"]>0) return 1;

        return 0;
    }
    public static function delTile($hands,$tile){
        $name =$tile->name();
        $hands["$name"]=$hands["$name"]-1;
        return $hands;
    }
}
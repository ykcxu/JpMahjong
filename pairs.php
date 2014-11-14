<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 下午6:31
 */
require_once "./hands.php";
#$str = "11z11s1233p";
#$hands = hands::readString($str);
#echo "输入牌型:".$str."\n";
#echo "手牌模组:".json_encode($hands)."\n";
#echo "拆分搭子:".json_encode(pairs::prePairs($hands));

class pairs {
    public static function prePairs($hands){   //遍历手牌中的搭子
          $tmpPairs = array();
          foreach($hands as $key => $value){
                $a = str_split($key);
                $nowtile = new tile($a[1],$a[0]);
                $nexttile = new tile($a[1],$a[0]+1);
                $thirdtile = new tile($a[1],$a[0]+2);
                $kezi = array($nowtile,$nowtile,$nowtile);
                if (hands::havePairs($hands,$kezi)) array_push($tmpPairs,$kezi);
                $dui = array($nowtile,$nowtile);
                if (hands::havePairs($hands,$dui)) array_push($tmpPairs,$dui);
                if ($a[1]=="z") continue;
                $shunzi = array($nowtile,$nexttile,$thirdtile);
                if (hands::havePairs($hands,$shunzi)) array_push($tmpPairs,$shunzi);
                $dazi = array($nowtile,$nexttile);
                if (hands::havePairs($hands,$dazi)) array_push($tmpPairs,$dazi);
                $dazi = array($nowtile,$thirdtile);
                if (hands::havePairs($hands,$dazi)) array_push($tmpPairs,$dazi);
              }
     #  echo "这次发现".count($tmpPairs)."个,判断值为".empty($tmpPairs)."\n";

       return $tmpPairs;
    }
    public static function type($pairs){   //判断搭子类型
      #  echo "这次判断的类型是".json_encode($pairs)."判断类型为";
        $nowtile = $pairs[0];
       # echo json_encode($nowtile)."\n";
        $nexttile = new tile($nowtile->type,$nowtile->num+1);
        $thirdtile = new tile($nowtile->type,$nowtile->num+2);
        #echo json_encode($nexttile)."\n";
        #echo json_encode($thirdtile)."\n";
        $kezi = array($nowtile,$nowtile,$nowtile);
        if ($pairs==$kezi) return "kezi";
        $dui = array($nowtile,$nowtile);
        if ($pairs==$dui) return "dui";

        $shunzi = array($nowtile,$nexttile,$thirdtile);
        # echo "顺子判定结果:".hands::havePairs($pairs,$shunzi)."\n";
        if ($pairs==$shunzi) return "shunzi";
        $dazi = array($nowtile,$nexttile);
        if ($pairs==$dazi) return "dazi";
        $dazi = array($nowtile,$thirdtile);
        if ($pairs==$dazi) return "dazi";

       # echo "这次判断的类型是".json_encode($pairs)."判断类型为error";
        return "error";

    }


} 
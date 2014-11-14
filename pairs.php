<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 下午6:31
 */
require_once "./hands.php";
/*$str = "11z11s1233p";
$hands = hands::readString($str);
echo "输入牌型:".$str."\n";
echo "手牌模组:".json_encode($hands)."\n";
echo "拆分搭子:".json_encode(pairs::prePairs($hands,11));
# echo pairs::type(array(9,10));
*/
class pairs {
    public static function prePairs($hands,$tile){   //遍历手牌中的搭子
          $tmpPairs = array();
          $k =0;
         # echo "传进来的起始牌是:".$tile."\n";
          foreach($hands as $key => $value){
                $thirdtile =0;
                $nowtile = $key;
                if ($key%9==0) {$nexttile=100;$thirdtile=100;}
                else $nexttile = $key+1;
                if ($key%9==8) {$thirdtile=100;}
                else $thirdtile+=($key+2);
                if ($tile <= $nowtile) $k=1;
                if ($k==0) continue;
                $kezi = array($nowtile,$nowtile,$nowtile);
                if (hands::havePairs($hands,$kezi)) array_push($tmpPairs,$kezi);
                $dui = array($nowtile,$nowtile);
                if (hands::havePairs($hands,$dui)) array_push($tmpPairs,$dui);
                if ($nowtile>27) continue;
                $shunzi = array($nowtile,$nexttile,$thirdtile);
                if (hands::havePairs($hands,$shunzi)) array_push($tmpPairs,$shunzi);
                $dazi = array($nowtile,$nexttile);
                if (hands::havePairs($hands,$dazi)) array_push($tmpPairs,$dazi);
                $dazi = array($nowtile,$thirdtile);
                if (hands::havePairs($hands,$dazi)) array_push($tmpPairs,$dazi);
              }
     #  echo "这次发现".count($tmpPairs)."个,判断值为".empty($tmpPairs)."\n";
       # echo "返回的数据是：".json_encode($tmpPairs)."\n";

       return $tmpPairs;
    }
    public static function type($pairs){   //判断搭子类型
      #  echo "这次判断的类型是".json_encode($pairs)."判断类型为";
        $thirdtile =0;
        $nowtile = $pairs[0];
        if ($nowtile%9==0) {$nexttile=100;$thirdtile=100;}
        else $nexttile = $nowtile+1;
        if ($nowtile%9==8) {$thirdtile=100;}
        else $thirdtile+=($nowtile+2);
        #echo json_encode($nexttile)."\n";
        #echo json_encode($thirdtile)."\n";
        #echo "这次判断的类型是".json_encode($pairs)."判断类型为error，生成的三个数组分别是".json_encode($shunzi);
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

        echo "这次判断的类型是".json_encode($pairs)."判断类型为error，生成的三个数组分别是".json_encode($shunzi);
        return "error";

    }


} 
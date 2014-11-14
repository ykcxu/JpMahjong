<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 下午4:43
 */
require_once "./hands.php";
require_once "./pairs.php";
$str = "1112223334445p";
$hands = hands::readString($str);


$handsplit = array();
/* 定义handsplit
    当前未分手牌   $hands
    当前已分模组  $tiles数组
    当前手牌状态   $status  记录顺子数，面子数，搭子数，国士无双完成数，tiles模组数量

*/
$handsplit = $handsplit + array(
        "hands" => $hands,
    );

$perResult = array();
array_push($perResult,$handsplit);

$perResult=process::split($perResult,0);
$test = $perResult[1];

#echo json_encode($test);
echo "处理牌型".$str."中.....\n";
echo "共有分类方法".count($perResult)."个\n";
echo  "手牌处理完成,收获成型搭子共计".$test["status"]["tiles"]."个\n";
$dazi = $test["status"]["dui"]+$test["status"]["dazi"];
$mianzi = $test["status"]["shunzi"]+ $test["status"]["kezi"];
echo "其中,顺子".$test["status"]["shunzi"]."个,刻子".$test["status"]["kezi"]."个,对子".$test["status"]["dui"]."个,搭子".$test["status"]["dazi"]."个\n";
echo "剩余手牌".json_encode($test["hands"]);
echo "向听数".(min($dazi,4-$mianzi)+max(4-$dazi-$mianzi,0)*2-1);
   # min（搭子数    ，4 -   面子数）+  max     （4-   面子书   -     搭子数   ，0）* 2 + 1 *（雀头有无） - 1


class process{
    public static function split($perResult,$deep){
      #  if ($deep>3) return $perResult;
        $k=0;
        $tmpResult = array();
       # if ($deep==1) echo json_encode($perResult)."\n";
        foreach ($perResult as $handsplit){
 #             echo json_encode($handsplit)."\n";
              $hands = $handsplit["hands"];
              $array = pairs::prePairs($hands);
             # echo json_encode($array);
              if (empty($array)) {array_push($tmpResult,$handsplit);}
              else {
              foreach($array as $pairs){
  #                echo json_encode($pairs)."\n";
                  $handsplitbak = $handsplit;
                  $handsplitbak["tiles"]= array();
   #               echo (hands::havePairs($hands,$pairs))."\n";
                  if (hands::havePairs($hands,$pairs)) {
                     $handsplitbak["hands"]=hands::delPairs($hands,$pairs);
                     $t = pairs::type($pairs);
    #                 echo $t."\n";
                     $handsplitbak["status"][$t]+=1;
                     $handsplitbak["status"]["tiles"]+=1;
                     array_push($handsplitbak["tiles"],$pairs);
                     array_push($tmpResult,$handsplitbak);
                     #echo json_encode($tmpResult)."\n";
                     $k=1;
                    }
              }
              }
        }
     #   echo json_encode($tmpResult)."\n";
      #  echo "deep".$deep."\n";
        if ($k==1) return process::split($tmpResult,$deep+1);
        else return $tmpResult;
    }
}
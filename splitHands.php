<?php
/**
 * Created by PhpStorm.
 * User: xulu
 * Date: 14-11-13
 * Time: 下午4:43
 */
require_once "./hands.php";
require_once "./pairs.php";
$str = "1577m222333888p";

$xiangting = process::cal($str);
if ($xiangting==-1) echo("胡牌");
$youxiao = array();
for ($i=1;$i<=34;$i++){
    if (process::cal($str.tile::numtoword($i))<$xiangting) array_push($youxiao,$i);
}
echo "分析牌型:".$str."\n";
echo "有效章有:";
foreach($youxiao as $i)
{
    echo tile::numtoword($i)."   ";
}
// $hands = hands::readString($str);


//$handsplit = array();
/* 定义handsplit
    当前未分手牌   $hands
    当前已分模组  $tiles数组
    当前手牌状态   $status  记录顺子数，面子数，搭子数，国士无双完成数，tiles模组数量

*/
/*
$handsplit = $handsplit + array(
        "hands" => $hands,
        "tiles" => array(),

    );
$handsplit["status"]["startpile"]=1;

$perResult = array();
array_push($perResult,$handsplit);

$perResult=process::split($perResult,10);
#echo json_encode($perResult);
$min=10;
$array = array();
*/
/*echo count($perResult);
function my_sort($a,$b)
{
    if (count($a)==count($b)) {
        for($i=0;$i<count($a);$i++)
        {
            if (($a[$i]->num)>($b[$i]->num)) return 1;
            if (($a[$i]->num)>($b[$i]->num)) return -1;

        }
        return 0;
    }
    elseif (count($a)>count($b)) return 1;
    else return -1;

}
foreach($perResult as $test)
{
  #  if (process::xiangting($test)<$min) {$array=array();array_push($array,$test);$min=process::xiangting($test);}
   # if (process::xiangting($test)==$min) {array_push($array,$test);}
  echo json_encode($test)."\n\n\n";
    usort($test["tiles"],"my_sort");
    echo '排序后'.json_encode($test)."\n\n\n";
    array_push($array,$test);

}
*/
#echo count($array);
#$perResult = array_unique($array,SORT_STRING);
# echo json_encode($perResult);
/*$test = $perResult[0];
echo "处理牌型".$str."中.....\n";
echo "共有分类方法".count($perResult)."个\n";
echo  "手牌处理完成,收获成型搭子共计".$test["status"]["tiles"]."个\n";
$dazi = $test["status"]["dui"]+$test["status"]["dazi"];
$mianzi = $test["status"]["shunzi"]+ $test["status"]["kezi"];
$quetou = $test["status"]["quetou"];
echo "其中,顺子".$test["status"]["shunzi"]."个,刻子".$test["status"]["kezi"]."个,对子".$test["status"]["dui"]."个,搭子".$test["status"]["dazi"]."个,雀头".$quetou."个\n";
echo "剩余手牌".json_encode($test["hands"]);
echo "向听数".(min($dazi,4-$mianzi)+max(4-$dazi-$mianzi,0)*2+1*(1-$quetou)-1)."\n";
if (($mianzi==4) and ($quetou==1)) echo "少年你胡牌了！";
   # min（搭子数    ，4 -   面子数）+  max     （4-   面子书   -     搭子数   ，0）* 2 + 1 *（雀头有无） - 1
*/

class process{
    public static function cal($str){//判断听牌
        $hands = hands::readString($str); //读取字符串
        //初始化手牌序列
        $handsplit = array();
        /* 定义handsplit
            当前未分手牌   $hands
            当前已分模组  $tiles数组
            当前手牌状态   $status  记录顺子数，面子数，搭子数，国士无双完成数，tiles模组数量

        */
        $handsplit = $handsplit + array(
                "hands" => $hands,
                "tiles" => array(),

            );
        $handsplit["status"]["startpile"]=1;

        $perResult = array();
        array_push($perResult,$handsplit);
        //分析牌型
        $perResult=process::split($perResult,10);

        $test = $perResult[0];//抽取结果之一

        //计算向听数
        return process::xiangting($test);

    }
    public static function split($perResult,$min){
       # if ($deep>3) return $perResult;  防止搜索过深，设定深度开关
        $k=0;
        $tmpResult = array();
       # if ($deep==1) echo json_encode($perResult)."\n";  调试用
        foreach ($perResult as $handsplit){
 #             echo json_encode($handsplit)."\n";
              $hands = $handsplit["hands"];
              $array = pairs::prePairs($hands,$handsplit["status"]["startpile"]);   //获取现有零散手牌中的搭子序列
             # echo json_encode($array);
              if (empty($array)) {
                 if (process::xiangting($handsplit)==$min)
                       array_push($tmpResult,$handsplit);
                  if (process::xiangting($handsplit)<$min)
                  {  # echo "清除序列".json_encode($tmpResult)."\n";
                     # echo "理由：现有手牌".json_encode($handsplit)."向听数".process::xiangting($handsplit)."小于最小向听".$min."\n";
                      $tmpResult=array();array_push($tmpResult,$handsplit);$min=process::xiangting($handsplit);
                  }

              }  //没有搭子则搜索达到终点，直接返回
              else {
              foreach($array as $pairs){
  #                echo json_encode($pairs)."\n";
                  $handsplitbak = $handsplit;   //备份手牌分配序列
                 # $handsplitbak["tiles"]= array();
   #               echo (hands::havePairs($hands,$pairs))."\n";
                  if (hands::havePairs($hands,$pairs)) {   //遍历搭子序列
                     $handsplitbak["hands"]=hands::delPairs($hands,$pairs); //搭子ok则删除零散手牌中对应的牌
                     $t = pairs::type($pairs);//获取搭子类型
    #                 echo $t."\n";
                     if ($t=="dui"){
                         if ($handsplitbak["status"]["quetou"]==1)
                             $handsplitbak["status"][$t]+=1;
                         else $handsplitbak["status"]["quetou"]=1;
                     }
                     else   $handsplitbak["status"][$t]+=1;

                     $handsplitbak["status"]["tiles"]+=1;   //更新序列状态
                     $handsplitbak["status"]["startpile"]=$pairs[0];
                     array_push($handsplitbak["tiles"],$pairs);
                     if (process::xiangting($handsplitbak)<$min) $min=process::xiangting($handsplitbak);

                 #   echo "插入".json_encode($pairs)."后，序列变为".json_encode($handsplitbak["tiles"])."\n";
                     array_push($tmpResult,$handsplitbak);   //更新后的序列加入结果存储地址

                     #echo json_encode($tmpResult)."\n";
                     $k=1;   //匹配开关置1，表示此次搜索找到新组合
                    }
              }
              }
        }
     #   echo json_encode($tmpResult)."\n";
      #  echo "deep".$deep."\n";
        if ($k==1) return process::split($tmpResult,$min);  //此次搜索找到新序列，手牌中可能还没有筛出的搭子，深度加1继续进行搜索
        else return $tmpResult;//手牌中无新序列，可直接返回
    }
    public static function  xiangting($test){
        $dazi = $test["status"]["dui"]+$test["status"]["dazi"];
        $mianzi = $test["status"]["shunzi"]+ $test["status"]["kezi"];
        $quetou = $test["status"]["quetou"];
        $result = min($dazi,4-$mianzi)+max(4-$dazi-$mianzi,0)*2+1*(1-$quetou)-1;
        return $result;

    }
}
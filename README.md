JpMahjong
=========

Base php and js

=========
实现第一个分手牌功能，深度优先，面对清一色有内存不足的危险，T_T
2014-11-14

=========
增加新成员
@playing
@jimobox
哈哈，好开心
2014-11-14

==========
增加了筛选功能，每次在搜索到根部的时候判断向听数，小于最小则更新list，大于则抛弃
2014-11-14

==========
修正了因为筛选功能导致的list过早被舍弃
修改了tile对象，现在已经不会占用过多的内存了
深度优先抛弃模式加入
增加了胡牌判断
2014-11-15

==========
增加了有效章计算，胡牌判断


==========
Todo List
1，增加返回列表的图形显示  @playing
2，修改tile对象，变成枚举类型
3，在深度优先过程中加入抛弃模式，随时更新list

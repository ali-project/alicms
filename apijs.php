<?php
/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/13
 * Time: 13:40
 */
defined('IN_WZ') or exit('No direct script access allowed');
class apijs{

    public function init()
    {
        include "res/js/apijs.js";

    }






    public function pages()
    {
        //echo json_encode($GLOBALS);
        load_function("tools","alicms");
        $cid = $GLOBALS['cid'];
        $table = aligettablebycid($cid)[0];

        $db = load_class("mydb","alicms");
        $c['cid'] = $cid ;
        $c['status'] = 9;
        if($GLOBALS['where']!="undefined" && $GLOBALS['where']!="")
        {
            $temp =  explode("," ,$GLOBALS['where']);
            foreach ($temp as $t)
            {
                $temp2 = explode("=" ,$t);
                $c[$temp2[0]] = $temp2[1];
            }
        }
        $result = $db->where($c)->order($GLOBALS["order"])->getall($table);

        $count = count($result);
        $yyy = array();

        if($count%$GLOBALS['count']==0){
            $pages=$count/$GLOBALS['count'];
        }else{
            $pages=ceil($count/$GLOBALS['count']);
        }
//        $urlrule="/index.php?v=listing&cid={\$cid}&page={\$page}";
        $urlrule = $GLOBALS['urlrule'];
//================================================================
        $pagelimit = $GLOBALS['pagelimit'] ;
        $currentpage = $GLOBALS['page'] ;
        $resultoutput="<ul class='ali-ul'>";
        $active = "ali-first-li";
        $active2 = "ali-first-a";

        if(1==$GLOBALS['page']){
            $active .= " ali-first-li-disabled";
            $active2 .= " ali-first-a-disabled";
        }

        $yyy['url'] =_pageurl($urlrule,1,array("cid"=>$GLOBALS[cid]));
        $resultoutput.="<li class='".$active."'><a class='".$active2."' href='".$yyy['url']."'>首页</a></li>\n";

        $active = "ali-priv-li";
        $active2 = "ali-priv-a";

        if(1==$GLOBALS['page']){
            $active .= " ali-priv-li-disabled";
            $active2 .= " ali-priv-a-disabled";
        }

        $yyy['url'] =_pageurl($urlrule,$currentpage-1<1?1:$currentpage-1,array("cid"=>$GLOBALS['cid']));
        $resultoutput.="<li class='".$active."'><a class='".$active2."' href='".$yyy['url']."'>上一页</a></li>\n";


        $pagelimit=$pagelimit-1;
        $yyy['page'];
        $c['page'];
        $from = 1 ;
        if($c['pagelimit']<5) $c['pagelimit']=5 ;




        for($i=1;$i<=$pages;$i++)
        {

            if($pages>$pagelimit-2){
                $from = $pages-2;
            }

            if($pages>$currentpage-$pagelimit){
                $from = $currentpage-$pagelimit;
            }


        }

        if($from<1) $from=1 ;

       //下一页的数字可见
        if($from+$pagelimit<$pages && $currentpage!=1){
            $from = $from+1 ;
        }



        for($ali=$from;$ali<=$from+$pagelimit&&$ali<=$pages;$ali++)
        {
            $active = "";
            $active2 = "";
            if($ali==$currentpage){
                $active = "class='ali-active-li'";
                $active2 = "class='ali-active-a'";

            }

            $yyy['url'] =_pageurl($urlrule,$ali,array("cid"=>$c["cid"]));

            $resultoutput.="<li ".$active."><a ".$active2." href='".$yyy['url']."'>".$ali."</a></li>\n";


        }




        $active = "ali-next-li";
        $active2 = "ali-next-a";

        if($currentpage==$pages){
            $active .= " ali-next-li-disabled";
            $active2 .= " ali-next-a-disabled";
        }

        $yyy['url'] =_pageurl($urlrule,($currentpage+1>$pages?$pages:$currentpage+1),array("cid"=>$c["cid"]));
        $resultoutput.="<li class='".$active."'><a class='".$active2."' href='".$yyy['url']."'>下一页</a></li>\n";



        $active = "ali-last-li";
        $active2 = "ali-last-a";

        if($currentpage==$pages){
            $active .= " ali-last-li-disabled";
            $active2 .= " ali-last-a-disabled";
        }




        $yyy['url'] =_pageurl($urlrule,$pages,array("cid"=>$c["cid"]));
        $resultoutput.="<li class='".$active."'><a class='".$active2."' href='".$yyy['url']."'>末页</a></li></ul>\n";

        $this->pages = $resultoutput;
        if($count<=$GLOBALS['count']){
            $resultoutput = "<div class='ali-nopage' id='ali-nopage'></div>";
        }


        echo $resultoutput;

    }
    
    
    
    
    
    
    
    
    
    
}

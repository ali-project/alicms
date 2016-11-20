<?php
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2016/11/18
 * Time: 10:03
 */
class app
{

    function  __construct()
    {
        load_function("tools","alicms");
    }


    /**
     * 获取文章的上一页和下一页,-1的为无
     */
    public function contentlastnext()
    {
        load_function("tools","alicms");
        $table = aligettablebycid($GLOBALS['cid'])[0];
        $db = load_class("mydb","alicms");
        $c['cid'] = $GLOBALS['cid'];
        $c['status'] = 9 ;
        $result = $db->where($c)->order("sort desc,addtime desc")->getall($table);
        $last = -1 ;
        $next = -1 ;
        $last_ = -1 ;
        $next_ = -1 ;
        $nexttitle = "";
        $lasttitle="";
        $lasttitle_="";
        foreach ($result as $r=>$x)
        {
            if($next_==0){
                $next = $x['id'];
                $nexttitle=$x['title'];
                break ;
            }
            if($GLOBALS['id']==$x['id']){
                $last = $last_ ;
                $lasttitle = $lasttitle_ ;
                $next_ = 0 ;
            }
            $last_ = $x["id"] ;
            $lasttitle_ = $x['title'];

        }
        echo json_encode(array("status"=>0,"last"=>$last,"next"=>$next,"lasttitle"=>$lasttitle,"nexttitle"=>$nexttitle));

    }


    public function getclicknumber()
    {
        echo  json_encode(setgetviews($GLOBALS['cid'],$GLOBALS['id'])) ;
    }




















}
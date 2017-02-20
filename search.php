<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2017/1/19
 * Time: 11:32
 */
defined('IN_WZ') or exit('No direct script access allowed');
class search{

    private $db;
    function __construct() {
        load_function("tools","alicms");
        $this->db = load_class('mydb',"alicms");

    }

    /**
     * search
     */
    public function init(){
        $c = "title like '%".$GLOBALS['key']."%'";

        if(isset($GLOBALS['cid']) && $GLOBALS['cid']!=0 ){
            $c.=" and cid=". $GLOBALS['cid'];
        }
        echo  $c ;

        $result = $this->db->where($c)->order("addtime desc")->getall("alisearch_cache");
        alidump($result);






    }





}
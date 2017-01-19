<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2017/1/19
 * Time: 10:43
 */

defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');

class searchcache extends WUZHI_admin
{
    private $db;
    function __construct() {
        load_function("tools","alicms");
        $this->db = load_class('mydb',"alicms");
    }

    public function listing(){
        echo "<p>本次刷新是将模型内的所有文章已审核文章(status=9)刷新到搜索表内,即可实现全站搜索</p>";
        echo "<p><a href='http://www.kancloud.cn/ali-project/alicms/263940' target='_blank'>文档参考</a></p>";
        echo "<p><a href='/index.php?m=alicms&f=searchcache&v=flush".$this->su()."'>立即刷新</a></p>";
    }


    public function flush(){

        //获取到所有的模型
        $c["m"] = "content" ;
        $result = $this->db->where($c)->getall("model");

        $this->db->delete("alisearch_cache","1=1");
        $tableflush = "";
        foreach ($result as $r){
            $table = $r['master_table'];
            if(!is_int(strpos($tableflush,$table))){
                $result2 = $this->db->begin()->where("status=9")->getall($table);
                foreach ($result2 as $r2){
//                    echo "<p>table=".$table."cid=".$r2["cid"].",id=".$r2['id'].",title=".$r2['title'].",addtime=".$r2['addtime'].",modelid=".$r['modelid']."</p>";
                    $d['cid'] = $r2["cid"];
                    $d['id'] = $r2["id"];
                    $d['title'] = $r2["title"];
                    $d['addtime'] = $r2["addtime"];
                    $this->db->begin()->add("alisearch_cache",$d);

                }
                $tableflush.=$table ;
            }




        }








        MSG("刷新已完成",HTTP_REFERER,2000);
    }



}


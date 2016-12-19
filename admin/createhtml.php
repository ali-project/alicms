<?php

/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/12
 * Time: 10:32
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');

class createhtml extends WUZHI_admin
{
    private $db;
    private $arr;

    function __construct()
    {
        $this->db = load_class('mydb', "alicms");
        $this->arr = array();
        load_function("tools", "alicms");
    }

    function listing()
    {
        load_function("tools", "alicms");

        if (isset($GLOBALS['catids'])) {
            if ($GLOBALS['catids'][0] == "") {
                $this->arr = array();
                $this->getchildcid(0);
            } else {
                $this->arr = array();
                foreach ($GLOBALS['catids'] as $r) {
                    $this->arr = array();
                    array_push($this->arr, $r);
                    $this->getchildcid($r);
                }
            }
        }

        foreach ($this->arr as $r) {
            $this->createhtml($r);
        }


        $categorys = get_cache('category', 'content');
        foreach ($categorys as $cid => $cate) {
            $categorys[$cid]['cid'] = $cid;
        }
        $form = load_class('form');


        include $this->template('createhtml_listing');

    }

    function getchildcid($cid)
    {


        $result = $this->db->where("pid=$cid")->getall("category");
        foreach ($result as $r) {
            if ($r['type'] == 0) {
                array_push($this->arr, $r['cid']);
                if ($r['child'] > 0) {
                    $this->getchildcid($r['cid']);
                }

            }

        }
    }


    function flushcache()
    {

        $cid = ($GLOBALS['cid']);
        $this->getchildcid($cid);
        $this->runclearcache($cid);

        foreach ($this->arr as $r) {
            $this->runclearcache($r);
        }

    }

    function runclearcache($cid)
    {
        load_function("tools", "alicms");
        $result = $this->db->where("cid=$cid")->getall("jingtai_html");
        //alidump($result);
        foreach ($result as $r)
        {
            $file = WWW_ROOT . "" . $r['html'];

            $file = str_replace("//", "/", $file);
            //echo $file . "<br>";
            if (file_exists($file)) {
                if (!unlink($file)) {
                    //echo("Error deleting $file");
                } else {
                    //echo("Deleted $file");
                }

            }

        }

        $this->db->delete("jingtai_html","cid=$cid");

        MSG("清除缓存成功");



        /*

        $table = aligettablebycid($cid)[0];
        //echo $table ;
        $result = $this->db->where("cid=$cid and route=3 and status<>9 ")->getall($table);




        foreach ($result as $r) {



            $alicms['key'] = "jingtai_".$cid."_".$r['id'];

            $resultalicms = $this->db->where($alicms)->getall("alicms");

            foreach ($resultalicms as $rr)
            {

                $file = WWW_ROOT . "" . $rr['value'];

                $file = str_replace("//", "/", $file);
                echo $file . "<br>";
                if (file_exists($file)) {
                    if (!unlink($file)) {
                        echo("Error deleting $file");
                    } else {
                        echo("Deleted $file");
                    }

                }


            }





            $alicms['key'] = "jingtai_".$cid."_".$r['id'];

            //$alicms['value'] = $r['url'];
            $this->db->delete("alicms",$alicms);


        }

        //MSG("清除缓存完毕");

        $result = $this->db->where("m='content' and f='content' and v='delete'")->getall("logs");
        alidump($result);
        $data = $result[0]['data'];
        $aar = explode(chr(13), $data);
        alidump($aar);
        foreach ($aar as $r) {


            if (is_int(strpos($r, "_groupid"))) {

            } else if (is_int(strpos($r, "cid"))) {
                $arrttt = explode("=", $r);
                echo "====cid====" . $arrttt[1];


            } else if (is_int(strpos($r, "id"))) {
                $arrttt = explode("=", $r);
                echo "====id====" . $arrttt[1];


            }
        }
*/

    }


    function createhtml($cid)
    {
        load_function("tools", "alicms");
        $table = aligettablebycid($cid)[0];

        $result = $this->db->where("cid=$cid and route=3 and status=9 ")->getall($table);
        foreach ($result as $r) {

            // if($r['route']==3){
            $xx['cid']=$cid;
            $xx['pid']=$r['id'];
            $xx['html']=$r['url'];
            $result = $this->db->where($xx)->getall("jingtai_html");
            if(count($result)==0){
                $this->db->add("jingtai_html",$xx);
            }

            $arr = explode("/", $r['url']);

            $urls['url'] = remove_xss($r['url']);
            $p = "";
            for ($j = 1; $j < count($arr) - 1; $j++) {
                if (!is_dir(WWW_ROOT . $p . $arr[$j])) {
                    mkdir(WWW_ROOT . $p . $arr[$j]);
                }
                $p .= $arr[$j] . "/";
            }

            if (file_exists($p . $arr[count($arr) - 1])) {
                unlink($p . $arr[count($arr) - 1]);
            }
            $myfile = fopen($p . $arr[count($arr) - 1], "w") or die("Unable to open file!");

            $url = 'http://' . $_SERVER['HTTP_HOST'] . "/index.php?v=show&cid=$cid&id=" . $r['id'];
            //MSG($url."--".$cid."  ".$id);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            //curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $txt = curl_exec($curl);
            curl_close($curl);

            fwrite($myfile, $txt);
            fclose($myfile);
            //}

        }

    }

}
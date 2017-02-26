<?php
/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/13
 * Time: 13:40
 */
defined('IN_WZ') or exit('No direct script access allowed');
class js{

    public function jqueryform()
    {
        include "res/js/jquery-form.js";

    }

    public function jquery()
    {
        include "res/js/jquery.min.js";

    }

    public function test()
    {
        load_function("tools","alicms");
//        echo get_ip();
//        $path = COREFRAME_ROOT."alicms/res/bb.jpg";
//        echo $path ;
//        load_function("tools","alicms");
//
//        $aaa[0]['path'] = $path ;
//        $aaa[0]['name'] = "aa" ;
//
//
//        alisend_mail("xienaizhong@qq.com","aaa","bbb  <img src= \"https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png\" ><script>alert('aff')</script>");
        echo  alipinyin("谢乃中");

    }
    public function aliqiniu()
    {
        $db = load_class("db");
        $r = $db->get_one('setting',array('keyid'=>'qiniu','m'=>'alicms'));
        //MSG($r['data']);
        $setting = unserialize($r['data']);
        $this->domain = $setting['domain'];


        $token = $setting['token'];
        include "res/js/aliqiniu.js";

    }
    public function moxie()
    {
        include "res/js/moxie.min.js";

    }
    public function plupload()
    {
        include "res/js/plupload.min.js";

    }
    public function qiniu()
    {





        include "res/js/qiniu.min.js";

    }


}

<?php
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/18
 * Time: 15:44
 */

//include "alidayu/top/TopClient.php";
//include "alidayu/top/request/AlibabaAliqinFcSmsNumSendRequest.php";
include "alidayu/TopSdk.php";

class WUZHI_alidayu
{


    private $setting ;


    public function __construct()
    {
        $db = load_class("db");
        $r = $db->get_one('setting',array('keyid'=>'alidayu','m'=>'alicms'));

        $this->setting = unserialize($r['data']);
    }


    public function send($mobile){
        $rand = rand(1000,9999);
        $c = new TopClient;
        $c->appkey = $this->setting['AppKey'];
        $c->secretKey = $this->setting['AppSecret'];
        $req = new AlibabaAliqinFcSmsNumSendRequest;
//        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($this->setting['SignName']);
        $req->setSmsParam("{\"code\":\"$rand\"}");
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode($this->setting['TemplateCode']);
        $resp = $c->execute($req);
        $db = load_class("mydb","alicms");
        $d['code']=$rand;
        $d['mobile']=$mobile;
        $d['posttime']=SYS_TIME;
        $db->add("alisms",$d);

    }

    public function checksms($mobile,$code){
        $db = load_class("mydb","alicms");
        $d['code']=$code;
        $d['mobile']=$mobile;
        $posttime = SYS_TIME-600;//10分钟内有效
        $r = $db->begin()->where("`code`='$code' AND `posttime`>$posttime AND mobile='$mobile'")->getall("alisms");

        return count($r);





    }



}
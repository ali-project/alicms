<?php

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2016/11/17
 * Time: 11:31
 */
defined('IN_WZ') or exit('No direct script access allowed');
class ajaxapi
{

    public function updatetargetmail(){
        $db = load_class("mydb","alicms");
        $c['id']=$GLOBALS['id'];
        $d['targetmail'] = $GLOBALS['targetmail'];
        $db->begin()->where($c)->save("ziduan",$d);

        $r['status'] = 0 ;
        $r['msg'] = "ok3 ";
        echo json_encode($r);



    }
    public function updatetixing(){
        $db = load_class("mydb","alicms");
        $c['id']=$GLOBALS['id'];
        $d['tixing'] = $GLOBALS['tixing'];
        $db->begin()->where($c)->save("ziduan",$d);

        $r['status'] = 0 ;
        $r['msg'] = "ok ";
        echo json_encode($r);



    }
    public function updatediscribe(){
        $db = load_class("mydb","alicms");
        $c['id']=$GLOBALS['id'];
        $d['discribe'] = $GLOBALS['discribe'];
        $db->begin()->where($c)->save("ziduan",$d);

        $r['status'] = 0 ;
        $r['msg'] = "ok ";
        echo json_encode($r);
    }


    public function getuid(){
        $db = load_class('db');
        $uid = get_cookie('_uid');
        if($uid)
        {
            echo $uid;
        }else{
            echo 0;
        }
    }

    /**
     * 获取验证码的值
     */
    public function getcode(){


        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            // ajax 请求的处理方式
        }else{

            exit( "invalid call 1!");
        };

        load_class("session");
        echo $_SESSION['code'];
    }

    public function sendmail(){
        load_function('sendmail');
        if(send_mail($GLOBALS['email'],$GLOBALS['subject'],$GLOBALS['body'])===false) {
            //MSG("发送错误");
            echo json_encode(array("status"=>1,"msg"=>"配置错误"));
            return ;
        }
        echo json_encode(array("status"=>0));
    }


    public function sendmailaliyun(){
        $send = load_class("Mail","alicms");
        $send->send($GLOBALS['email'],$GLOBALS['subject'],$GLOBALS['body']);
        echo json_encode(array("status"=>0));
    }

    public function saveziduan(){
        $mydb = load_class("mydb","alicms");

        $table = $GLOBALS['table'];
        $d['dbname'] = $table ;
        $cums = $mydb->begin()->where($d)->getall("ziduanx");
        $dbs = $mydb->begin()->where($d)->getall("ziduan");
        $subject = "自定义字段【".$dbs[0]["discribe"]."】有新的信息";
        $tomail = $dbs[0]["targetmail"];
        //echo $subject ;
        $body = "";
        foreach ($cums as $r)
        {
            $body .= $r['dbdescribe']."(".  $r['dbcum'].")=>".$GLOBALS[$r['dbcum']]."<br>";
            $c[$r['dbcum']]= $GLOBALS[$r['dbcum']];
        }
        $c['createtime'] = date('Y-m-d H:i:s',time());
        //echo $body ;
        $uid = get_cookie('_uid');
        if($uid){
            $c['uid']=$uid;
        }
        $mydb->add($table,$c);

        if($dbs[0]["tixing"]==1)
        {
            load_function('sendmail');
            $mailarr = explode(";", $tomail);
            foreach ($mailarr as $mails) {
                send_mail($mails,$subject,$body);
            }
        }else if($dbs[0]["tixing"]==2)
        {
            $send = load_class("Mail","alicms");

            $mailarr = explode(";", $tomail);
            foreach ($mailarr as $mails) {
                $send->send($mails,$subject,$body);
            }
        }

        $re['status'] =0 ;
        $re['msg'] = json_encode($GLOBALS);
        echo json_encode($re);

    }


    public function  sendsms(){

        if(strtolower(trim($GLOBALS['param']))==""){
            exit('{"msg":"验证码错误","status":"1"}');
        }



        load_class('session');
        if($_SESSION['code'] == strtolower(trim($GLOBALS['param']))) {
            //exit('{"info":"验证码正确","status":"y"}');
        } else {
            exit('{"msg":"验证码错误","status":"1"}');
        }



        $api =load_class("alidayu","alicms");
        $api->send($GLOBALS['mobile']);
        exit('{"msg":"发送成功","status":"0"}');

    }

    public function  checksms(){
        //exit('{"msg":"验证通过","status":"0"}');
        $api =load_class("alidayu","alicms");
        $count =$api->checksms($GLOBALS['mobile'],$GLOBALS['code']);
        if($count==0){
            exit('{"msg":"验证失败","status":"1"}');
        }else{
            exit('{"msg":"验证通过","status":"0"}');
        }

    }




    public function getlists()
    {

        $db  = load_class("mydb","alicms");
        $c['cid'] = $GLOBALS['cid'];
        $result = $db->where($c)->getall("category");

        $d['modelid'] = $result[0]['modelid'];
        $result = $db->where($d)->getall("model");
        $table = $result[0]['master_table'];

        $e['cid'] = $GLOBALS['cid'];
        $e['status'] = 9;
        $result =$db->begin()->page($GLOBALS['page'],$GLOBALS['count'])->order("sort DESC,updatetime DESC")->where($e)->getall($table);


        echo json_encode($result);

    }




    public function getkeyvalue(){
        $cid = $GLOBALS['cid'];
        $ziduan = $GLOBALS['ziduan'];
        $value = $GLOBALS['value'];
        load_function("tools","alicms");
        echo alikeyvalue($cid,$ziduan,$value);


    }








}
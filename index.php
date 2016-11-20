<?php

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2016/11/17
 * Time: 11:44
 */
defined('IN_WZ') or exit('No direct script access allowed');
class index
{

    public function androidpushbyid(){



        //$data['cid'] = $GLOBALS['cid'];
        //$data['id'] = $GLOBALS['id'];
        $data = $GLOBALS['data'];

        $jpush = load_class("jpushsdk","alicms");
        $jpush->androidpushbyid($GLOBALS['deviceid'],$GLOBALS['alert'],$GLOBALS['title'],$data);

    }

    public function iospushbyid()
    {
        $data = $GLOBALS['data'];
        $jpush = load_class("jpushsdk","alicms");
        $jpush->iospushbyid($GLOBALS['deviceid'],$GLOBALS['message'],$data);
    }

    public function ziduanaction()
    {

        $mydb = load_class("mydb","alicms");

        $table = $GLOBALS['table'];
        $form = $GLOBALS['form'];
        $d['dbname'] = $table ;
        $cums = $mydb->begin()->where($d)->getall("ziduanx");
        $dbs = $mydb->begin()->where($d)->getall("ziduan");
        $subject = "自定义字段【".$dbs[0]["discribe"]."】有新的信息";
        $tomail = $dbs[0]["targetmail"];
        //echo $subject ;
        $body = "";
        foreach ($cums as $r)
        {


            if(is_array($form[$r['dbcum']])){
                $c[$r['dbcum']]= json_encode($form[$r['dbcum']]);
                $body .= $r['dbdescribe']."(".  $r['dbcum'].")=>".json_encode( $form[$r['dbcum']])."<br>";
            }else{

                $c[$r['dbcum']]= $form[$r['dbcum']];
                $body .= $r['dbdescribe']."(".  $r['dbcum'].")=>".$form[$r['dbcum']]."<br>";
            }


        }

        $c['createtime'] = date('Y-m-d H:i:s',time());
        $uid = get_cookie('_uid');
        if($uid){
            $c['uid']=$uid;
        }
        //echo $body ;

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

        MSG($GLOBALS['msg'],HTTP_REFERER,500);



    }


    public function getv()
    {
        load_function("tools","alicms");
        echo getVersion();
    }



}
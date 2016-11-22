<?php

/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/11/8
 * Time: 10:58
 */
class WUZHI_ziduan
{
    public function saveziduan($c){
        $mydb = load_class("mydb","api");

        $table = $c['table'];
        $d['dbname'] = $table ;
        $cums = $mydb->begin()->where($d)->getall("ziduanx");
        $dbs = $mydb->begin()->where($d)->getall("ziduan");
        $subject = "自定义字段【".$dbs[0]["discribe"]."】有新的信息";
        $tomail = $dbs[0]["targetmail"];
        //echo $subject ;
        $body = "";
        foreach ($cums as $r)
        {
            $body .= $r['dbdescribe']."(".  $r['dbcum'].")=>".$c[$r['dbcum']]."<br>";
            $c[$r['dbcum']]= $c[$r['dbcum']];
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
            $send = load_class("Mail","api");

            $mailarr = explode(";", $tomail);
            foreach ($mailarr as $mails) {
                $send->send($mails,$subject,$body);
            }
        }



    }





}
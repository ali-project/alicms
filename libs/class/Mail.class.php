<?php

/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/7/19
 * Time: 10:21
 */
include_once 'mail/aliyun-php-sdk-core/Config.php';
use Dm\Request\V20151123 as Dm;
class WUZHI_Mail
{

    public function send($mail,$subject,$body)
    {

        //$mail = $GLOBALS['mail'];
        //$subject = $GLOBALS['subject'];
        //$body = $GLOBALS['body'];

        $db = load_class("db");
        $r =$db->get_one('setting',array('keyid'=>'sendmailaliyun','m'=>'alicms'));
        $setting = unserialize($r['data']);




//

        $iClientProfile = DefaultProfile::getProfile($setting['regionId'], $setting['accessKeyId'], $setting['accessSecret']);
        $client = new DefaultAcsClient($iClientProfile);
        $request = new Dm\SingleSendMailRequest();
        $request->setAccountName($setting['frommail']);
        $request->setAddressType(1);
        $request->setFromAlias($setting['username']);
        $request->setReplyToAddress("true");
        $request->setToAddress($mail);
        $request->setSubject($subject);
        $request->setHtmlBody($body);
        $response = $client->getAcsResponse($request);
        //print_r($response);





    }





}
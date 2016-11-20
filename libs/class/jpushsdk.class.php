<?php
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/9/7
 * Time: 14:34
 */
require_once 'jpushsdk/autoload.php' ;
use JPush\Client as JPush;
class WUZHI_jpushsdk
{

    private $setting ;
    function __construct() {
        $db = load_class("db");
        $r = $db->get_one('setting',array('keyid'=>'jpush','m'=>'alicms'));
        $this->setting = unserialize($r['data']);
    }








    public function iospushbyid($registration_id,$alert,$data){
        $app_key = $this->setting['app_key'];
        $master_secret = $this->setting['master_secret'];
        // $registration_id = '1a0018970aa604e54f9';

        $client = new JPush($app_key, $master_secret);



        // 完整的推送示例,包含指定Platform,指定Alias,Tag,指定iOS,Android notification,指定Message等
        $result = $client->push()
            ->setPlatform(array('ios'))
            //->addAlias('alias1')
            //->addTag(array('tag1', 'tag2'))
            //->setNotificationAlert('Hi, JPush')
            ->addRegistrationId($registration_id)
            ->iosNotification($alert,$data)
            //->addAndroidNotification('Hi, android notification', 'notification title', 1, array("key1"=>"value1", "key2"=>"value2"))
            //->addIosNotification($alert, 'iOS sound', 1999, true, 'iOS category', $data)
            //->setMessage("msg content", 'msg title', 'type', array("key1"=>"value1", "key2"=>"value2"))
            ->setOptions(time(), 3600, null, true)
            ->send();
        echo 'Result=' . json_encode($result) ;


    }


    public function androidpushbyid($registration_id,$alert,$title,$data)
    {




        $app_key = $this->setting['app_key'];
        $master_secret = $this->setting['master_secret'];
       // $registration_id = '1a0018970aa604e54f9';

        $client = new JPush($app_key, $master_secret);

        $push_payload = $client->push()
           ->setPlatform(array('android'))
            //->addAllAudience()
            ->addRegistrationId($registration_id)
            //->setNotificationAlert($alert)
            ->addAndroidNotification($alert, $title, 0, $data)

            ;



        try {
            $response = $push_payload->send();
        }catch (\JPush\Exceptions\APIConnectionException $e) {
            // try something here
            print $e;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            // try something here
            print $e;
        }


        print_r($response);

    }



}
<?php


require_once 'qiniusdk/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
defined('IN_WZ') or exit('No direct script access allowed');

class WUZHI_qiniuapi
{




    private $bucketMgr;
    private  $testAuth ;
    private  $bucket;
    private $domain ;
    private $secretKeyx ;
    private $accessKeyx;
    public function __construct()
    {

        $setting = array();
        $db = load_class("db");
        $r = $db->get_one('setting',array('keyid'=>'qiniu','m'=>'alicms'));
        //MSG($r['data']);
        $setting = unserialize($r['data']);
        $this->domain = $setting['domain'];


        $accessKey = $setting['accessKey'];//'PkDMktpjk29Ag0n86_1mtF7zhX9f1RJCyHcgjnCI';
        $this->accessKeyx = $accessKey ;
        $secretKey = $setting['secretKey'];//'8gI2seqsKitvRn59CeOSgna_VyI82E2244JHmqj9';
        $this->secretKeyx = $secretKey ;
        $this->bucket = $setting['bucket'];//'8gI2seqsKitvRn59CeOSgna_VyI82E2244JHmqj9';

        $this->testAuth = new Auth($accessKey, $secretKey);
        $this->bucketMgr = new BucketManager($this->testAuth);




    }

    public function getdomain(){
        return $this->domain;
    }


    public function getauth(){
        $limit = time()+1*60*60 ;

        $put_policy ='{"scope":"'.$this->bucket.'","deadline":'.$limit.'}';

        $encoded =  strtr(base64_encode($put_policy), '+', '-');
        $encoded =  strtr(base64_encode($encoded), '/', '_');




        //echo $encoded ;
       // $signature = $this->testAuth->hmac_sha1($this->secretKeyx, $encoded);
        $signature = hash_hmac('sha1', $this->secretKeyx, $encoded);
        $encode_signed  =  strtr(base64_encode($signature), '+', '-');
        $encode_signed  =  strtr(base64_encode($encode_signed), '/', '_');

        echo $this->accessKeyx.":". $encode_signed.":".$encoded ;


    }





    public function getdirs($prefix)
    {
        $marker = '';
        $limit = 2100000000;
        $dirs = array();
        $files = array();
        list($iterms, $marker, $err) = $this->bucketMgr->listFiles($this->bucket, $prefix, $marker, $limit);
        if ($err !== null) {
        } else {
            for($i=1;$i<count($iterms);$i++)
            {
                $tmp = $iterms[$i]['putTime'];
                $tmp_ = $iterms[$i];
                $j=$i-1 ;
                for(;$j>=0;$j--){
                    if($iterms[$j]['putTime']<$tmp){
                        $iterms[$j+1] = $iterms[$j] ;
                    }else{
                        break;
                    }
                }
                $iterms[$j+1]=$tmp_ ;
            }
            foreach ($iterms as $obj) {
                $sub = substr($obj["key"], strlen($prefix));
                //文件夹标记(可创建文件夹的)
                if($sub=="") { continue ;}
                //还有文件夹的
                if (strpos( $sub,"$")){
                    $arr = explode("$", $sub);
                    $dirs[$arr[0]]="";
                    //没有文件夹了
                }else{
                    $files[$sub]="";//$obj['putTime'];
                }
            }

        }

        return array("dir"=>$dirs,"files"=>$files);
    }


    public function getdirs2($prefix)
    {
        $marker = '';
        $limit = 2100000000;
        $dirs = array();
        $files = array();
        $detail = array();
        list($iterms, $marker, $err) = $this->bucketMgr->listFiles($this->bucket, $prefix, $marker, $limit);
        if ($err !== null) {
        } else {
            for($i=1;$i<count($iterms);$i++)
            {
                $tmp = $iterms[$i]['putTime'];
                $tmp_ = $iterms[$i];
                $j=$i-1 ;
                for(;$j>=0;$j--){
                    if($iterms[$j]['putTime']<$tmp){
                        $iterms[$j+1] = $iterms[$j] ;
                    }else{
                        break;
                    }
                }
                $iterms[$j+1]=$tmp_ ;
            }
            foreach ($iterms as $obj) {
                $sub = substr($obj["key"], strlen($prefix));
                //文件夹标记(可创建文件夹的)
                if($sub=="") { continue ;}
                //还有文件夹的
                if (strpos( $sub,"$")){
                    $arr = explode("$", $sub);
                    $dirs[$arr[0]]="";
                    $detail[$arr[0]] = $obj ;
                    //没有文件夹了
                }else{
                    $files[$sub]="";//$obj['putTime'];
                    $detail[$sub]=$obj;
                }
            }

        }

        return array("dir"=>$dirs,"files"=>$files,"detail"=>$detail);
    }

    public function delete($key){
        $err = $this->bucketMgr->delete($this->bucket, $key);
        //echo "\n====> delete $key : \n";
        if ($err !== null) {

            return 1 ;
            //var_dump($err);
        } else {
            return 0 ;
        }

    }


    public function  deletedir($prefix){

        //echo $prefix;
        //echo  strpos($prefix,"$") ;
        if(strpos($prefix,"$")<1) return 1 ;



        $marker = '';
        $limit = 210000000;
        list($iterms, $marker, $err) = $this->bucketMgr->listFiles($this->bucket, $prefix, $marker, $limit);
        if ($err !== null) {
        } else {
            foreach ($iterms as $obj) {
                //echo  $obj['key']."<br>";
                $this->bucketMgr->delete($this->bucket, $obj['key']);
            }
        }

        if($err!=null){
//            var_dump($err);
        }

    }







    public function upload($filePath,$key){
        // 生成上传 Token
        $token = $this->testAuth->uploadToken($this->bucket);

        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        //echo "\n====> putFile result: \n";
        if ($err !== null) {
            return 1 ;
        } else {
            unlink($filePath);
            return 0 ;
        }
    }


    public function mkdir($key){


        $token = $this->testAuth->uploadToken($this->bucket);

        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, __DIR__."/qiniusdk/not_remove");
        //echo "\n====> putFile result: \n";
        if ($err !== null) {
            return 1 ;
        } else {

            return 0 ;
        }





    }



}






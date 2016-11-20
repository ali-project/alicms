<?php

/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/12
 * Time: 10:32
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
class qiniu extends WUZHI_admin
{
    private $db;
    function __construct() {
        $this->db = load_class('db');
    }
    public function set(){


        




        if(isset($GLOBALS['submit'])) {
            $formdata = array_map('remove_xss',$GLOBALS['form']);
            $updatetime = date('Y-m-d H:i:s',SYS_TIME);
            $r = $this->db->get_one('setting',array('keyid'=>'qiniu','m'=>'alicms'));
            if($r==null){
                $this->db->insert('setting',array('keyid'=>'qiniu','m'=>'alicms'));
            }
            set_cache('qiniu',$formdata);
            $formdata = serialize($formdata);
            $this->db->update('setting',array('data'=>$formdata,'updatetime'=>$updatetime),array('keyid'=>'qiniu','m'=>'alicms'));
            MSG(L('edit success'),HTTP_REFERER);
        }else {
            $setting = array();
            $r = $this->db->get_one('setting',array('keyid'=>'qiniu','m'=>'alicms'));
            $setting = unserialize($r['data']);
            include $this->template('qiniuset');
        }
    }
    public function upload(){

        if(isset($GLOBALS['submit'])){

            if(!file_exists(__DIR__."/temp")){mkdir(__DIR__."/temp");}


            $aaa = load_class("qiniuapi","alicms");
            $ret = array();
            for($i=0;$i<count($_FILES['file']['name']);$i++)
            {
                $dir = __DIR__."/temp/".time().rand(1000000,9999999);
                //echo $_FILES['file']['tmp_name'][$i] ;
                if(move_uploaded_file($_FILES['file']['tmp_name'][$i],$dir))
                {

                    $aaa->upload($dir,$GLOBALS['qiniudir'].$_FILES['file']['name'][$i]);
                    $ret[$i+1] = $GLOBALS['qiniudir'].$_FILES['file']['name'][$i];
                }
            }

            //echo  json_encode(array("status"=>0,"msg"=>"ok"));
            header("Location:/index.php?m=alicms&f=qiniu&v=upload&p=".$GLOBALS['qiniudir']."&code=alicms".$this->su());
        }


            include $this->template('qiniuupload');
    }

    public function mkdir(){

        $qiniu = load_class("qiniuapi","alicms");
        $result =$qiniu->mkdir($GLOBALS['dir']);

        $r['msg'] = $GLOBALS['dir'];
        echo json_encode($r);

    }


    public function delete(){
        $qiniu = load_class("qiniuapi","alicms");
        $result =$qiniu->delete($GLOBALS['key']);
        $r['msg'] = $GLOBALS['key'];
        $r['status'] = json_encode($result) ;
        echo json_encode($r);


    }


    public function deletedir(){

        if($GLOBALS['p']==""){


            echo '{"status":"1","msg":"不能删除根目录"}';
            return ;
        }


        $qiniu = load_class("qiniuapi","alicms");
        $qiniu->deletedir($GLOBALS['p']);
        $r['msg'] = $GLOBALS['p'];

        echo json_encode($r);


    }
















}
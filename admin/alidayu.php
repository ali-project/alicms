<?php

/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/12
 * Time: 10:32
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
class alidayu extends WUZHI_admin
{
    private $db;
    function __construct() {
        $this->db = load_class('db');
    }
    public function set(){
        if(isset($GLOBALS['submit'])) {
            $formdata = array_map('remove_xss',$GLOBALS['form']);
            $updatetime = date('Y-m-d H:i:s',SYS_TIME);
            $r = $this->db->get_one('setting',array('keyid'=>'alidayu','m'=>'alicms'));
            if($r==null){
                $this->db->insert('setting',array('keyid'=>'alidayu','m'=>'alicms'));
            }
            set_cache('alidayu',$formdata);
            $formdata = serialize($formdata);
            $this->db->update('setting',array('data'=>$formdata,'updatetime'=>$updatetime),array('keyid'=>'alidayu','m'=>'alicms'));
            MSG(L('edit success'),HTTP_REFERER);
        }else {
            $setting = array();
            $r = $this->db->get_one('setting',array('keyid'=>'alidayu','m'=>'alicms'));
            $setting = unserialize($r['data']);
            include $this->template('alidayuset');
        }
    }




}
<?php

/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/12
 * Time: 10:32
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');

class alimail extends WUZHI_admin
{
    private $db;

    function __construct()
    {
        $this->db = load_class('db');
    }

    public function set()
    {
        if (isset($GLOBALS['submit'])) {

            $formdata = array_map('remove_xss', $GLOBALS['form']);
            $updatetime = date('Y-m-d H:i:s', SYS_TIME);

            $r = $this->db->get_one('setting', array('keyid' => 'sendmailaliyun', 'm' => 'alicms'));
            if ($r == null) {
                $this->db->insert('setting', array('keyid' => 'sendmailaliyun', 'm' => 'alicms'));
            }

            set_cache('sendmailaliyun', $formdata);
            $formdata = serialize($formdata);
            $this->db->update('setting', array('data' => $formdata, 'updatetime' => $updatetime), array('keyid' => 'sendmailaliyun', 'm' => 'alicms'));
            MSG(L('edit success'), HTTP_REFERER);

        } else {

            $setting = array();
            $r = $this->db->get_one('setting', array('keyid' => 'sendmailaliyun', 'm' => 'alicms'));
            $setting = unserialize($r['data']);
            include $this->template('set_sendmailaliyun');

        }
    }


    public function sendmailaliyun_test()
    {


        if (isset($GLOBALS['submit'])) {
            $receive = remove_xss($GLOBALS['receive']);

            load_function('preg_check');
            if (empty($receive) || !is_email($receive)) {
                MSG(L('email address error'));
            }

            $send = load_class("Mail", "alicms");
            $send->send($GLOBALS['receive'], "来自阿力CMS的邮件测试", "来自阿力CMS的邮件测试");

            MSG(L('sendmail success'), HTTP_REFERER);
        } else {

            include $this->template('set_sendmailaliyun_test');
        }


    }


}
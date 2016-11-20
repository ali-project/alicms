<?php
/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/13
 * Time: 13:40
 */
defined('IN_WZ') or exit('No direct script access allowed');
class js{

    public function jqueryform()
    {
        include "res/js/jquery-form.js";

    }

    public function jquery()
    {
        include "res/js/jquery.min.js";

    }

    public function test()
    {
        echo file_get_contents("http://www.baidu.com");



    }



}

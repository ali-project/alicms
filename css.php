<?php
/**
 * Created by PhpStorm.
 * User: 闲道人阿力
 * Date: 2016/10/13
 * Time: 13:40
 */
defined('IN_WZ') or exit('No direct script access allowed');
class css{

    public function iconfont()
    {


        header("Content-type: text/css");

        include "res/css/iconfont.css";


    }

}

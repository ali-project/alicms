<?php

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2016/11/17
 * Time: 13:06
 */
defined('IN_WZ') or exit('No direct script access allowed');
class qiniu
{
    public function token()
    {
        $qiniu = load_class("qiniuapi","alicms");
        echo $qiniu->getauth();


    }


}
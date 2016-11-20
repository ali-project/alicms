<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

class WUZHI_tools {
	


	public function addsetting($key,$m,$f,$v)
	{
		$db = load_class("mydb","alicms");
		$c['keyid'] = $key;
		$c['m'] = $m ;
		$c['f'] = $f ;
		$c['v'] = $v ;

		$result = $db->where($c)->getall("setting");
		if(count($result)==0)
		{
			$db->add("setting",$c);
		}





	}





}
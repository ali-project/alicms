<?php
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2016/11/17
 * Time: 13:45
 */
class init
{


    public function addmenu($f,$v,$name,$pid,$data)
    {

        $db=load_class("mydb","alicms");
        //如果没有Alicms总的菜单,加Alicms菜单
        $c['m']="alicms";
        $c['f']=$f;
        $c['v']=$v;
        $c['data']=$data;

        $result = $db->where($c)->getall("menu");

        if(count($result)==0){
            $c['name']=$name;
            $c['pid']=$pid;
            $c['display']=1;
            $c['sort']=5 ;
            $a = $db->add("menu",$c);
            $data="\r\n".'$MENU['.$a.']=\''.$name.'\';';
            file_put_contents(COREFRAME_ROOT.'languages/zh-cn/admin_menu.lang.php', $data,FILE_APPEND);
            //var_dump($a);
        }else{

            $a=$result[0]['menuid'];

        }
        return $a ;

    }


    public function initdb_ziduanx()
    {
        $this->db = load_class("db");
        $t = get_config("mysql_config");
        $this->config =$t['default']['tablepre'];

        $config =$this->config;
        $sql = "SHOW TABLES LIKE '".$config."ziduanx';";
        $r = $this->db->query($sql);

        if($r->num_rows==0){

            $sql = " CREATE TABLE `".$config."ziduanx` (
				  `id` int(10) NOT NULL AUTO_INCREMENT,
				  `dbname` varchar(100) DEFAULT NULL,
				  `dbcum` varchar(255) DEFAULT NULL,
				  `dbtype` varchar(255) DEFAULT NULL,
				  `dbdescribe` varchar(255) DEFAULT NULL,
				  `data` text DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $this->db->query($sql);


        }
    }




    public function initdb_ziduan()
    {
        $this->db = load_class("db");
        $t = get_config("mysql_config");
        $this->config =$t['default']['tablepre'];

        $config =$this->config;
        $sql = "SHOW TABLES LIKE '".$config."ziduan';";
        $r = $this->db->query($sql);

        if($r->num_rows==0) {

            $sql = " CREATE TABLE `" . $config . "ziduan` (
				  `id` int(10) NOT NULL AUTO_INCREMENT,
				  `dbname` varchar(100) DEFAULT NULL,
				  `discribe` varchar(255) DEFAULT NULL,
				  `tixing` int(1) DEFAULT 0,
				  `targetmail` varchar(255) DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $this->db->query($sql);
        }
    }



    public function initdb_alicms()
    {
        $this->db = load_class("db");
        $t = get_config("mysql_config");
        $config =$t['default']['tablepre'];


        $sql = "SHOW TABLES LIKE '".$config."alicms';";
        $r = $this->db->query($sql);

        if($r->num_rows==0) {

            $sql = " CREATE TABLE `" . $config . "alicms` (
				  `id` int(10) NOT NULL AUTO_INCREMENT,
				  `key` varchar(100) DEFAULT NULL,
				  `value` varchar(255) DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $this->db->query($sql);
        }


    }

    public function initdb_alisms()
    {
        $this->db = load_class("db");
        $t = get_config("mysql_config");
        $config =$t['default']['tablepre'];


        $sql = "SHOW TABLES LIKE '".$config."alisms';";
        $r = $this->db->query($sql);

        if($r->num_rows==0) {

            $sql = " CREATE TABLE `" . $config . "alisms` (
				  `id` int(10) NOT NULL AUTO_INCREMENT,
				  `mobile` varchar(100) DEFAULT NULL,
				  `code` varchar(100) DEFAULT NULL,
				  `posttime` bigint(20) DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $this->db->query($sql);
        }


    }

    public function initdb_jingtai_html()
    {

        $this->db = load_class("db");
        $t = get_config("mysql_config");
        $config =$t['default']['tablepre'];


        $sql = "SHOW TABLES LIKE '".$config."jingtai_html';";
        $r = $this->db->query($sql);

        if($r->num_rows==0) {
            $sql = "CREATE TABLE `" . $config . "jingtai_html` (
              `id` int(10) NOT NULL AUTO_INCREMENT,
              `cid` int(10) DEFAULT NULL,
              `pid` int(10) DEFAULT NULL,
              `html` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8";
            $this->db->query($sql);

        }


    }


    public function init()
    {

        $tools = load_class("tools","alicms");
        $rid =  $this->addmenu("index","init","AliCMS",1,"");
        //七牛配置

        $tools->addsetting("qiniu","alicms","","");
        //七牛上传菜单
        $this->addmenu("qiniu","set","七牛上传设置",$rid,"");
        $this->addmenu("qiniu","upload","七牛上传",$rid,"p=&code=alicms");

        //阿里大于
        $tools->addsetting("alidayu","alicms","","");
        $this->addmenu("alidayu","set","阿里大于设置",$rid,"");

        //Jpush
        $tools->addsetting("jpush","alicms","","");
        $this->addmenu("jpush","set","Jpush设置",$rid,"");
        $this->addmenu("jpush","test","Jpush测试",$rid,"");



        //阿里邮件推送
        $tools->addsetting("sendmailaliyun","alicms","","");
        $this->addmenu("alimail","set","阿里邮件设置",$rid,"");
        $this->addmenu("alimail","sendmailaliyun_test","阿里邮件测试",$rid,"");

        //自定义字段
        $this->addmenu("index","listing","自定义字段",$rid,"");

        //刷新静态
        $this->addmenu("createhtml","listing","刷新静态文件",$rid,"");



        $this->initdb_alicms();
        $this->initdb_ziduan();
        $this->initdb_ziduanx();
        $this->initdb_alisms();
        $this->initdb_jingtai_html();
        MSG("初始化成功");
        

    }

    














}
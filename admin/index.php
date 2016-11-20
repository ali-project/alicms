<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

load_class('admin');
//load_class('foreground', 'member');
//load_function('common',M);

class index extends WUZHI_admin {

	private $db ;

	public $config ;


	function __construct() {

//		$this->member = load_class('member', 'member');
//		$this->setting = get_cache('setting', 'member');
		$this->db = load_class("db");
		
		$t = get_config("mysql_config");
		$this->config =$t['default']['tablepre'];

	}

	public function init()
	{

		$db = load_class("tools","alicms");
		$version = $db->getVersion();



		include $this->template('home');
		
		
		
		
		
		
		
		
		
	}





	public function gencode()
    {
        $dbname = $GLOBALS['dbname'];
        $mydb = load_class("mydb","alicms");


        $result = $mydb->begin()->getfield($dbname);

        //dump($result);


        $return= "";
        $return .= "<form action='/index.php?m=alicms&v=ziduanaction&table=".$dbname."' method='post'>\n";
        $return.="<!------隐藏域开始-------->\n";
        $return.="<input type='hidden' name='msg' id='submit' value='提交成功'><br>\n";
        $return.="<input type='hidden' name='form[url]' id='url' value=''><br>\n";
        $return.="<input type='hidden' name='form[title]' id='title' value=''><br>\n";

        $return.="<script>\n";
        $return.="$('#url').val(window.location.href)\n";
        $return.="$('#title').val(document.title)\n";



        $return.="</script>\n";


        $return.="<!------隐藏域结束-------->\n";



//        $return.="<input type='radio'  name='fuck' value='fuckyou'><br>\n";
//        $return.="<input type='radio'  name='fuck' value='fuckme'><br>\n";
//        $return.="<input type='checkbox'  name='fuck[]' value='fuckher'><br>\n";
//        $return.="<input type='checkbox'  name='fuck[]' value='fuckhim'><br>\n"
//
////      $return.="<textarea name='data' style='height: 100px;width: 300px;'>选项1|1&#xd;选项2|2</textarea>";






        foreach ($result as $r){


            if($r["dbcum"]=="title"||$r["dbcum"]=="url") continue ;




            if($r['dbtype']=="String"){
                $return.=$r['dbdescribe'].":<input name='form[".$r["dbcum"]."]'><br>\n";
            }else if($r['dbtype']=="Double"){
                $return.=$r['dbdescribe'].":<input type='number' step='0.1' name='form[".$r["dbcum"]."]'><br>\n";
            }else if($r['dbtype']=="Int"){
                $return.=$r['dbdescribe'].":<input type='number' name='form[".$r["dbcum"]."]'><br>\n";
            }else if($r['dbtype']=="Text"){
                $return.=$r['dbdescribe'].":<textarea  name='form[".$r["dbcum"]."]'></textarea><br>\n";
            }else if($r['dbtype']=="datetime"){
                $return.=$r['dbdescribe'].":<input type='date'  name='form[".$r["dbcum"]."]'><br>\n";
            }else if($r['dbtype']=="radio"){
                $data = $r['data'];
                $data =str_replace(" ","",str_replace(chr(13),chr(32),$data));
                $data = explode("\n",$data);
                foreach ($data as $r2){
                    $data2 = explode("|",$r2);
                    $return.=$data2[0]."<input name='form[".$r["dbcum"]."]' type='radio' value='".$data2[1]."'><br>\n";
                }

            }else if($r['dbtype']=="checkbox"){
                $data = $r['data'];
                $data =str_replace(" ","",str_replace(chr(13),chr(32),$data));
                $data = explode("\n",$data);
                foreach ($data as $r2){
                    $data2 = explode("|",$r2);
                    $return.=$data2[0]."<input name='form[".$r["dbcum"]."][]' type='checkbox' value='".$data2[1]."'><br>\n";
                }

            }else if($r['dbtype']=="editor"){


                //<script type="text/javascript">CKEDITOR.config.toolbar = '';CKEDITOR.replace("content");</script>
                $return.="<!------编辑器开始-------->\n";
                $return.="<textarea name='form[".$r["dbcum"]."]' id='".$r["dbcum"]."' boxid='".$r["dbcum"]."' ></textarea>\n";
                $return.="<script src='/res/js/ckeditor/ckeditor.js'></script>\n";

                //$return.="<div id='".$r["dbcum"]."' name='form[".$r["dbcum"]."]'></div>";
                //$return.="<script >CKEDITOR.replace( '".$r["dbcum"]."' );</script>";
                $return.="<script >";
                $return.="CKEDITOR.config.toolbar = '';CKEDITOR.replace('".$r["dbcum"]."');";

                $return.="</script>\n";
                $return.="<!------编辑器结束-------->\n";









            }

        }

        $return .= "<input type='submit' value='submit'><br>\n";




        $return.= "</form>";

        $return = htmlspecialchars($return);


        include $this->template('gencode');

    }











	public function deletecum()
	{
		$config =$this->config;
		$table = $GLOBALS['dbname'];
		$tablep = $config.$table ;
		$cum = $GLOBALS['cum'];
		$sql = "alter table `$tablep` drop column $cum";
		$mydb = load_class("mydb","alicms");
		$mydb->query($sql);

		$c['dbname'] = $table ;
		$c['dbcum'] = $cum ;
		$mydb->delete("ziduanx",$c);


		MSG("成功","index.php?m=alicms&f=index&v=edit&dbname=".$GLOBALS['dbname'].$this->su(),1000);

	}


	public function deletedata()
	{
		$table = $GLOBALS['dbname'];
		$id = $GLOBALS['id'];
		$c['id'] = $id ;
		$mydb = load_class("mydb","alicms");
		$mydb->delete($table,$c);

		echo MSG("成功","index.php?m=alicms&f=index&v=listdata&dbname=".$GLOBALS['dbname'].$this->su(),1000);

	}





	public function delete()
	{
		$config =$this->config;
		$mydb = load_class("mydb","alicms");
		$r['result'] =  $GLOBALS['dbname'];
//		echo json_encode($r);
		$sql = "DROP TABLE ".$config.$GLOBALS['dbname'];
		$mydb->query($sql);
		$mydb->delete("ziduan"," dbname='".$GLOBALS['dbname']."'");
		$mydb->delete("ziduanx"," dbname='".$GLOBALS['dbname']."'");





		MSG("删除成功");

	}






	public function listdata()
	{
		$mydb = load_class("mydb","alicms");
		$result = $mydb->begin()->order("id desc")->getall($GLOBALS['dbname']);

		//var_dump($result);
		$c['dbname'] = $GLOBALS['dbname'];
		$result2 = $mydb->begin()->where($c)->getall("ziduanx");






		include $this->template('listdata');





	}

	




	public function listing()
	{


//		$mail = load_class("Mail","alicms");
//		$mail->send("xienaizhong@qq.com","测试","测试内容");


		$result = $this->db->get_list('ziduan','', '*', 0, 200,1,'id DESC');


		include $this->template('listing');
	}







	public function edit()
	{

		$mydb = load_class("mydb","alicms");


		$result = $mydb->begin()->getfield($GLOBALS['dbname']);

		include $this->template('editdata');
	}
	public function add()
	{

		if(strlen($GLOBALS['dbname'])>0){
			$mydb = load_class("mydb","alicms");
			$config =$this->config;
			$sql = " CREATE TABLE `".$config.$GLOBALS['dbname']."` (
				  `id` int(10) NOT NULL AUTO_INCREMENT,
				  `createtime` datetime DEFAULT NULL,
				  `uid` int DEFAULT 0,
				  
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";

			$mydb->query($sql);


			$c['dbname'] = $GLOBALS['dbname'];
			$c['discribe'] = $GLOBALS['discribe'];
			$c['tixing'] = $GLOBALS['tixing'];
			$c['targetmail'] = $GLOBALS['email'];
			$mydb->add("ziduan",$c);
				MSG("成功","index.php?m=alicms&f=index&v=listing".$this->su(),1000);

		}else{
			include $this->template('add');
		}

	}


	public function editx()
	{



	}









	public function addx()
	{

		if(strlen($GLOBALS['cname'])>0){
			$mydb = load_class("mydb","alicms");

			$config =$this->config;

			if($GLOBALS['dbtype']=="String"){
				$type = "VARCHAR(255) DEFAULT NULL";
			}else if($GLOBALS['dbtype']=="Int"){
				$type = "int(11) DEFAULT NULL";
			}else if($GLOBALS['dbtype']=="Double"){
				$type = "double DEFAULT NULL";
			}else if($GLOBALS['dbtype']=="Text"){
				$type = "text";
			}else if($GLOBALS['dbtype']=="datetime"){
				$type = "datetime";
			}else if($GLOBALS['dbtype']=="radio"){
				$type = "VARCHAR(255) DEFAULT NULL";
			}else if($GLOBALS['dbtype']=="checkbox"){
				$type = "VARCHAR(255) DEFAULT NULL";
			}else if($GLOBALS['dbtype']=="editor"){
                $type = "text";
            }




			$sql = "ALTER TABLE ".$config.$GLOBALS['dbname']." ADD ".$GLOBALS['cname']." ".$type.";";
			echo $sql ;
			$mydb->query($sql);

			$c['dbname'] = $GLOBALS['dbname'] ;
			$c['dbcum'] = $GLOBALS['cname'] ;
			$c['dbtype'] = $GLOBALS['dbtype'];
			$c['dbdescribe'] = $GLOBALS['discribe'];

			$c['data'] = $GLOBALS['data'];

			$mydb->add("ziduanx",$c);

			MSG("成功","index.php?m=alicms&f=index&v=edit&dbname=".$GLOBALS['dbname'].$this->su(),1000);

		}else{


			$table = $GLOBALS['dbname'];


			include $this->template('addx');
		}

	}







}
?>
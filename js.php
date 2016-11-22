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
        load_function("tools","alicms");


        $db = load_class("mydb","alicms");
        $reuslt = $db->getbyid("yuyue",8);
            alidump($reuslt);



//
//

//
//        alidump($GLOBALS);
//        echo "<br>";



//        $att = array();
//        array_push($att,array("name"=>"multiimg.zip","path"=>COREFRAME_ROOT."app/alicms/multiimg.zip"));
//        array_push($att,array("name"=>"README.md","path"=>COREFRAME_ROOT."app/alicms/README.md"));
//        alisend_mail("xienaizhong@qq.com","subject","body",$att);

        //获取category栏目
//        $db = load_class("mydb","alicms");
//        $result = $db->getall("category");
//        alidump($result);
//        $form = load_class('form');
//        $categorys = get_cache('category','content');
//        foreach($categorys as $cid=>$cate) {
//            $categorys[$cid]['cid'] = $cid;
//        }
//       // alidump($categorys);
//        $form = load_class('form');
//        echo "<form name=\"form1\" method=\"post\" action=''>";
//        echo $formcategorys = $form->tree_select($categorys, 0, 'name="catids[]" class="form-control" multiple="multiple" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择"', '≡ 全部 ≡');
//        echo "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"icon-cycle btn-icon\"></i>生成栏目页html</button>";
//        echo "</form>";





    }



}

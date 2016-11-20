<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>

<body>

<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>


<div class="panel-body" id="mybody">

<form method="post">
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">表名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text"  class="form-control" name="dbname" value="<?php echo  $table ;?>" disabled/>
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">字段名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text"  class="form-control" name="cname" value="" />
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">描述</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text"  class="form-control" name="discribe" value="" />
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">类型</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <select name="dbtype" id="dbtype">
                        <option value="String">255字之内的字符串</option>
                        <option value="Double">小数点</option>
                        <option value="Int">整型数字</option>
                        <option value="Text">长字符串，不限字数</option>
                        <option value="datetime">日期时间</option>
                        <option value="radio">单选按钮</option>
                        <option value="checkbox">多选按钮按钮</option>
                        <option value="editor">编辑器</option>



                    </select>
                </div>
            </div>
            <div class="form-group" id="data" style="display: none;">
                <label class="col-sm-2 col-xs-4 control-label">选项配置</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea name="data" style="height: 100px;width: 300px;">选项1|1&#xd;选项2|2</textarea>
                </div>
            </div>



             <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" name="submit"  type="submit" value="提交">
                </div>
            </div>
</form>

    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
    <script>

        $(document).ready(function () {
            $(".addnew").click(function () {
                location.href =('index.php?m=alicms&f=index&v=addx'+'<?php echo $this->su();?>');
            });
            $(".flush").click(function () {
                location.reload();
            });





        });


        $("#dbtype").change(function () {
            var val =($(this).val());
            if(val=="radio"||val=="checkbox"){
                $("#data").show();
            }else{
                $("#data").hide();

            }
        })






    </script>







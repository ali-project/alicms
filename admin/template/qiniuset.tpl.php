<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">

<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
<h3>请配合七牛API使用</h3>
    <h4><a href="http://www.kancloud.cn/ali-project/alicms/226124" target="_blank">开发文档</a></h4>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">


            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">domain(无http://)</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[domain]" color="#000000" value="<?php echo output($setting,'domain');?>" >
                </div>
            </div>

            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">accessKey</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[accessKey]" color="#000000" value="<?php echo output($setting,'accessKey');?>" >
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">secretKey</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[secretKey]" color="#000000" value="<?php echo output($setting,'secretKey');?>" >
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">bucket</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[bucket]" color="#000000" value="<?php echo output($setting,'bucket');?>" >
                </div>
            </div>






            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
</section>
</div>
</div>
<!-- page end-->
</section>

<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>


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
<h3>请配合阿里云邮件API使用<span style="color: red">不支持附件</span></h3>
    <h4><a href="http://www.kancloud.cn/ali-project/alicms/221462" target="_blank">开发文档</a></h4>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">




            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">发件人名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[username]" color="#000000" value="<?php echo output($setting,'username');?>" >
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">发件人地址</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[frommail]" color="#000000" value="<?php echo output($setting,'frommail');?>" >
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">regionId(cn-beijing)</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[regionId]" color="#000000" value="<?php echo output($setting,'regionId');?>" >
                </div>
            </div>

            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">accessKeyId</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[accessKeyId]" color="#000000" value="<?php echo output($setting,'accessKeyId');?>" >
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">accessSecret</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[accessSecret]" color="#000000" value="<?php echo output($setting,'accessSecret');?>" >
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


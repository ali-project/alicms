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
<h3>请配合JpushAPI使用</h3>
    <h4>仅测试通畅性和到达率,详情调用请参考<a href="#" target="_blank">开发文档</a></h4>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">

            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">平台</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <select name="form[plotform]" id="plotform">

                        <option value="1">Android</option>
                        <option value="2">iOS</option>


                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">alert</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[alert]" color="#000000" " >
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">title(ios不填)</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[title]" color="#000000" " >
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-xs-4 control-label">deviceId</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[deviceId]" color="#000000" " >
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


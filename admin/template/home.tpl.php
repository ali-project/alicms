<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
$show_dialog = true;
include $this->template('header','core');
?>
<style type="text/css">
div#wz_linkage{display: inline;}
</style>
<body>




<section class="wrapper">
	<div class="panel mr0">
	<header><?php echo $this->menu($GLOBALS['_menuid']);?></header>



<div class="panel-body" id="panel-bodys">
<h1>当前版本v<?php echo $version;?>|最新版本:v<span id="newest"><?php echo file_get_contents("http://alicms.9hlh.com/index.php?m=alicms&v=getv"); ?></span></h1>



    <h1><a href="/index.php?m=alicms&f=init">初始化</a></h1>
    <p style="color: red">点击初始化不会破坏数据,请放心升级</p>

    <h3>下载地址:<a href="https://github.com/alicms/alicms" target="_blank">https://github.com/alicms/alicms</a></h3>
    <h3>文档地址:<a href="http://www.kancloud.cn/ali-project/alicms" target="_blank">http://www.kancloud.cn/ali-project/alicms</a></h3>


</div>
	<div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

            <div class="pull-right">
                <ul class="pagination pagination-sm mr0">
                    <?php echo $pages;?>
                </ul>
            </div>
        </div>
    </div>
</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script src="<?php echo R;?>js/jquery.tagsinput.js"></script>


</body>
</html>

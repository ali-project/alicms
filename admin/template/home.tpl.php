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
<h1>当前版本v<?php echo $version;?></h1>
    <h1><a href="/index.php?m=alicms&f=init">初始化</a></a></h1>
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

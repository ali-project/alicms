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
	<header class="panel-heading">


		<button type="submit" class="btn btn-info btn-sm back">返回</button>
		<button type="submit" class="btn btn-info btn-sm flush">刷新</button>

	</header>


<div class="panel-body" id="panel-bodys">
	<textarea style='width: 800px;height: 500px;'>
	<?php echo $return ;?>
</textarea>
	</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script src="<?php echo R;?>js/jquery.tagsinput.js"></script>

<script type="text/javascript">

	function edit(id){
		top.openiframe('index.php?m=alicms&f=index&v=edit&id='+id+'<?php echo $this->su();?>', 'edit', '配置字段', 500, 240);
	}






$(function(){

	$(".back").click(function () {
		location.href =('index.php?m=alicms&f=index&v=listing'+'<?php echo $this->su();?>');
	});
	$(".flush").click(function () {
		location.reload();
	});



})


</script>
</body>
</html>

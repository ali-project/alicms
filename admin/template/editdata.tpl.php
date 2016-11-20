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
		<button type="submit" class="btn btn-info btn-sm addnew">新增</button>
		<button type="submit" class="btn btn-info btn-sm flush">刷新</button>

	</header>


<div class="panel-body" id="panel-bodys">
<table class="table table-striped table-advance table-hover">
	<thead>
	    <tr>
		<th class="tablehead">ID</th>
		<th class="tablehead">类型</th>
		<th class="tablehead">描述</th>
		<th class="tablehead">操作</th>


	    </tr>
    </thead>
    <tbody>
<?php
foreach($result as $r)
{
?>
      <tr>
      <td><?php echo $r['dbcum'];?></td>
      <td><?php echo $r['dbtype'];?></td>
      <td><?php echo $r['dbdescribe'];?></td>

      <td> <a href="javascript:makedo('index.php?m=alicms&f=index&v=deletecum&cum=<?php echo $r['dbcum'];?>&dbname=<?php echo $r['dbname'];?><?php echo $this->su();?>', '确认删除该记录？')"
			  class="btn btn-danger btn-xs">删除</a>



      </tr>
<?php } ?>
    </tbody>
</table>
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

<script type="text/javascript">

	function edit(id){
		top.openiframe('index.php?m=alicms&f=index&v=edit&id='+id+'<?php echo $this->su();?>', 'edit', '配置字段', 500, 240);
	}






$(function(){
	$(".back").click(function () {
		location.href =('index.php?m=alicms&f=index&v=listing'+'<?php echo $this->su();?>');
	});
	$(".addnew").click(function () {
		location.href =('index.php?m=alicms&f=index&v=addx&dbname=<?php echo $GLOBALS['dbname']; echo $this->su();?>');
	});
	$(".flush").click(function () {
		location.reload();
	});



	$('.tagsinput').tagsInput({
	"width": "100%",
	'height':'75px',
	'minChars':2,
	'onAddTag':function(tag){callback_tags( tag, 1, $(this) )}, //增加标签的回调函数
	'onRemoveTag':function(tag){callback_tags( tag, 2, $(this) )}, //删除标签的回调函数
	});
})

function callback_tags(tag,type,obj)
{
	var att_id = obj.attr('data-id');
	var tags_new = obj.val();//处理过后的新标签内容
	var api = '<?php echo link_url( array('v'=>'tags') );?>';
	
	$.get(api, { tags: tags_new, tag: tag, att_id:att_id, _su:'<?php echo _SU;?>', act_type:type },
	function(data){
		if(data != 1){
			msg = data;
			var d = top.dialog({
			content: msg,
			title: '<?php echo L('tips');?>',
			});
			d.showModal();
			setTimeout(function () {
			d.close().remove();
			}, 2000);
		}
	});
}
</script>
</body>
</html>

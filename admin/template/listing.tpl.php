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

		<button type="submit" class="btn btn-info btn-sm addnew">新增</button>
		<button type="submit" class="btn btn-info btn-sm flush">刷新</button>

	</header>


<div class="panel-body" id="panel-bodys">
<table class="table table-striped table-advance table-hover">
	<thead>
	    <tr>
		<th class="tablehead">ID</th>
	    <th class="tablehead">表名</th>
	    <th class="tablehead">描述</th>
	    <th class="tablehead">是否提醒</th>
	    <th class="tablehead">提醒邮箱</th>
	    <th class="tablehead">管理</th>

	    </tr>
    </thead>
    <tbody>
<?php
foreach($result as $r)
{
?>
      <tr>
      <td><?php echo $r['id'];?></td>
      <td><?php echo $r['dbname'];?></td>
          <td><a href="javascritp:;" myid="<?php echo $r['id'];?>" class="discribe"><?php echo $r['discribe'];?></a></td>
          <td><a href="javascritp:;" myid="<?php echo $r['id'];?>" myvalue="<?php echo $r['tixing'];?>" class="tixing"><?php $a =  $r['tixing']; if($a==0)echo "不提醒"; else if($a==1)echo "stmp发送";else if($a==2)echo "阿里云发送";?></a></td>
          <td><a href="javascritp:;" myid="<?php echo $r['id'];?>" class="emails"><?php echo $r['targetmail'];?></a></td>
      <td> <a href="javascript:makedo('?m=alicms&f=index&v=delete&dbname=<?php echo $r['dbname'];?><?php echo $this->su();?>', '确认删除该记录？')"
			  class="btn btn-danger btn-xs">删除</a>

       <a href="index.php?m=alicms&f=index&v=edit&dbname=<?php echo $r['dbname'];?><?php echo $this->su();?>"
			  class="btn btn-danger btn-xs">设置</a>
       <a href="index.php?m=alicms&f=index&v=listdata&dbname=<?php echo $r['dbname']; echo $this->su();?>"
			  class="btn btn-danger btn-xs">数据</a>
       <a href="index.php?m=alicms&f=index&v=gencode&dbname=<?php echo $r['dbname']; echo $this->su();?>"
			  class="btn btn-danger btn-xs">生成表单</a>
		  </td>

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

	$(".addnew").click(function () {
		location.href =('index.php?m=alicms&f=index&v=add'+'<?php echo $this->su();?>');
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
    $(".emails").click(function () {

        var id = $(this).attr("myid");
        var value = $(this).html();
        var newvalue = prompt("请输入新邮箱地址",value);
        if(newvalue != null){
            $.ajax({
                url:"/index.php?m=alicms&f=ajaxapi&v=updatetargetmail&id="+id+"&targetmail="+newvalue+"&code=aaacccxddd111bbbsssccc009ip",
                method:"get",
                dataType:"json",
                success:function (data) {
                    if(data.status==0){
                        location.reload();
                    }else{
                        alert(JSON.stringify(data))
                    }
                }
            });
        }



    })
    $(".tixing").click(function () {

        var id = $(this).attr("myid");
        var value = $(this).attr("myvalue");
        var newvalue = prompt("0:不提醒,1:stmp发送,2:aliyun发送",value);

        if(newvalue == null){return ;}


        if(!(newvalue==1||newvalue==2||newvalue==0))
        {
            alert("必须在0,1,2之间取值")
            return ;
        }





        $.ajax({
            url:"/index.php?m=alicms&f=ajaxapi&v=updatetixing&id="+id+"&tixing="+newvalue+"&code=aaacccxddd111bbbsssccc009ip",
            method:"get",
            dataType:"json",
            success:function (data) {
                if(data.status==0){
                    location.reload();
                }else{
                    alert(JSON.stringify(data))
                }
            }
        });


    })
    $(".discribe").click(function () {

        var id = $(this).attr("myid");
        var value = $(this).html();
        var newvalue = prompt("请输入新描述",value);

        if(newvalue != null){
            $.ajax({
                url:"/index.php?m=alicms&f=ajaxapi&v=updatediscribe&id="+id+"&discribe="+newvalue+"&code=aaacccxddd111bbbsssccc009ip",
                method:"get",
                dataType:"json",
                success:function (data) {
                    if(data.status==0){
                        location.reload();
                    }else{
                        alert(JSON.stringify(data))
                    }
                }
            });
        }



    })
</script>
</body>
</html>

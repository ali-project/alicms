
<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$qiniu = load_class("qiniuapi","alicms");
?>
<body class="body pxgridsbody">
<link rel=stylesheet type=text/css href="/index.php?m=alicms&f=css&v=iconfont">
<section class="wrapper">
    <header><?php echo $this->menu($GLOBALS['_menuid']);?></header>
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php //echo $this->menu($GLOBALS['_menuid']);?>
    <h4 style="color :red ;">前缀:<?php echo $GLOBALS['p']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[总和]超过5M的文件,请到七牛网页端上传,并添加前缀</h4>
    <h5 style="color :red ;"> 因七牛是KEY-VALUE模式存储,请上传前善于使用子目录,勿将文件堆放在根目录</h5>
    <header class="panel-heading">

        <button type="submit" class="btn btn-info btn-sm home" onclick="tohome()">首页</button>
        <button type="submit" class="btn btn-info btn-sm privbtn" onclick="topriv()">上级目录</button>
        <button type="submit" class="btn btn-info btn-sm " onclick="adddir()">新增目录</button>
        <button type="submit" class="btn btn-info btn-sm " onclick="flush()">刷新</button>


    </header>

    <form enctype="multipart/form-data" id="aaabbb" action="" method="post">
        <input  type="file"  name="file[]" multiple="multiple" />
        <input  type="hidden"  name="submit" />
        <input  type="hidden"  name="qiniudir" value="<?php echo $GLOBALS['p'] ;?>" />

        <input type="submit" class="btn btn-warning btn-sm " id="upload">
    </form>
    <hr>

    <div class="panel-body">
        <?php
            $result = $qiniu->getdirs2($GLOBALS['p']);
            $dirs = $result['dir'];
            $files = $result['files'];
            foreach ($dirs as $key=>$value)
            {
                if($GLOBALS['code']=="alicms"){
                    $deletedir = "<span class='iconfont icon-cuowu deletedir' mykey='".$key."' style='color: red;font-size: 20px;'></span>";
                }
                echo '<span class="iconfont icon-folder"></span><a  style="font-size:20px;" href="javascript:to(\''.$key.'\')">'.$key.'</a>&nbsp;'.$deletedir.'&nbsp;&nbsp;&nbsp;';
            }

        ?>




        <hr>
       勾选文件前,请配置最大宽度和最大高度.注意仅对图片文件有效
        <hr>
        <button type="submit" class="btn btn-danger btn-sm checkall">全选</button>
        <button type="submit" class="btn btn-danger btn-sm checkno">全不选</button>


        最大宽度:<input id="maxw" value="1200" style="width:40px;">|最大高度:<input id="maxh" value="0" style="width:40px;">
        <input id="onlyjpg" type="checkbox"><label for="onlyjpg">只看图片</label>
        <hr>
        <?php

        foreach ($files as $key=>$value)
        {


            if($GLOBALS['code']=="alicms"){
                $delete = "<span class='iconfont icon-cuowu delete' mykey='".$key."' style='color: red;font-size: 20px;'></span>";
            }



            $fsize = $result['detail'][$key]['fsize'];
            if($fsize<1000){
                $fsize = "(".$fsize."字节)";
            }else if ($fsize<1000000){
                $fsize = "(".sprintf("%.1f",$fsize/1024)."KB)";
            }else if ($fsize<1000000000){
                $fsize = "(".sprintf("%.1f",$fsize/1024/1024)."MB)";
            }

            $puttime = $result['detail'][$key]['putTime']."";
            $puttime = str_replace(".","",$puttime);
            $puttime =  intval(substr($puttime,0,10));
            $puttime=date("Y-m-d H:i:s",$puttime);

            $a = explode(".",$key);
            $a =$a[count($a)-1];
            $a = strtolower($a);

            if($a=="jpg"||$a=="png"||$a=="gif"||$a=="bmp"){
                $url = "http://".$qiniu->getdomain()."/".$GLOBALS['p'].$key."?imageView2/1/w/50/h/50/interlace/0/q/100";
                $img = "<img src='".$url."' >";
            }else if($a=="ppt"||$a=="pptx"){
                $img = "<span class=\"iconfont icon-pptx\"></span>";

            }else if($a=="doc"||$a=="docx"){
                $img = "<span class=\"iconfont icon-word\"></span>";

            }else if($a=="pdf"){
                $img = "<span class=\"iconfont icon-pdf\"></span>";

            }else if($a=="zip"||$a=="7z"||$a=="gz"){
                $img = "<span class=\"iconfont icon-zip\"></span>";

            }else if($a=="rar"){
                $img = "<span class=\"iconfont icon-rar\"></span>";

            }else if($a=="exe"){
                $img = "<span class=\"iconfont icon-exe\"></span>";

            }else if($a=="xls"||$a=="xlsx"){
                $img = "<span class=\"iconfont icon-excel\"></span>";

            }else if($a=="html"||$a=="htm"){
                $img = "<span class=\"iconfont icon-html\"></span>";

            }else if($a=="apk"){
                $img = "<span class=\"iconfont icon-shengchengapkbaozhuangbinganzhuang\"></span>";

            }else if($a=="txt"||$a=="log"){
                $img = "<span class=\"iconfont icon-txt\"></span>";

            }else if($a=="mp3"||$a=="wav"){
                $img = "<span class=\"iconfont icon-filesmp3\"></span>";

            }else if($a=="mp4"||$a=="avi"){
                $img = "<span class=\"iconfont icon-shipin\"></span>";

            }else if($a=="js"){
            $img = "<span class=\"iconfont icon-js\"></span>";

            }else if($a=="css"){
                $img = "<span class=\"iconfont icon-css\"></span>";

            }
            else{
                $img = "<span class=\"iconfont icon-wenjian\"></span>";
            }

            $temp = "a".rand(1000000,9999999);
            echo '<p class="items '.$a.'" >   <input  type="checkbox" id="'.$temp.'" class="check" key="'.$GLOBALS['p'].$key.'"><label  for="'.$temp.'">'.$img.$key.'</label>&nbsp;&nbsp;'.$fsize.'|'.$puttime.'<a style="font-size:15px;" href="http://'.$qiniu->getdomain().'/'.$GLOBALS['p'].$key.'" target="_blank">查看文件</a>'.$delete.'</p>';
        }




        ?>


    </div>
</section>
</div>
</div>
<!-- page end-->
</section>

<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script src="/index.php?m=alicms&f=js&v=jqueryform"></script>
<script>
     parent.returnimg = "";
    function to(newvalue) {
        var query=location.search.substring(1);//获取查询串
        var pairs=query.split("&");//在逗号处断开
        var x = "";
        for(var i=0;i<pairs.length;i++)   {
            var pos=pairs[i].indexOf('=');//查找name=value
            if(pos==-1) continue;//如果没有找到就跳过
            var argname=pairs[i].substring(0,pos);//提取name
            var value=pairs[i].substring(pos+1);//提取value
            if(argname=="p"){
                x+= "p="+value+newvalue+"$&";
            }else{
                x+= argname+"="+unescape(value) ;
                x+="&";
            }
        }
        location.href = (location.pathname+"?"+x);



    }

    function tohome() {
        var query=location.search.substring(1);//获取查询串
        var pairs=query.split("&");//在逗号处断开
        var x = "";
        for(var i=0;i<pairs.length;i++)   {
            var pos=pairs[i].indexOf('=');//查找name=value
            if(pos==-1) continue;//如果没有找到就跳过
            var argname=pairs[i].substring(0,pos);//提取name
            var value=pairs[i].substring(pos+1);//提取value
            if(argname=="p"){
                x+= "p=&";
            }else{
                x+= argname+"="+unescape(value) ;
                x+="&";
            }
        }
        location.href = (location.pathname+"?"+x);



    }


    function flush() {
        location.reload();
    }

    function adddir() {
        var value = prompt("请输入新文件夹");


        if(value.indexOf("&") >= 0 ||value.indexOf("$") >= 0 ||value.indexOf("`") >= 0
        ||value.indexOf("~") >= 0||value.indexOf("@") >= 0 ||value.indexOf("#") >= 0
        ||value.indexOf("%") >= 0||value.indexOf("^") >= 0 ||value.indexOf("&") >= 0
        ||value.indexOf("*") >= 0||value.indexOf("(") >= 0 ||value.indexOf(")") >= 0
        ||value.indexOf(">") >= 0||value.indexOf("<") >= 0 ||value.indexOf("/") >= 0
        ||value.indexOf("\\") >= 0||value.indexOf("{") >= 0 ||value.indexOf("}") >= 0
        ||value.indexOf("[") >= 0||value.indexOf("]") >= 0 ||value.indexOf("|") >= 0
        ||value.indexOf("!") >= 0 ||value.indexOf("?") >= 0
        ){
            alert("不能有特殊符号");
            return;
        }



        $.ajax(
            {
             url:"/index.php?m=alicms&f=qiniu&v=mkdir&dir=<?php echo $GLOBALS['p']; ?>"+value+"$<?php echo $this->su(); ?>",
             method:"get",
             dataType : "json",
             success:function (e) {
                 location.reload();
             }
            })

    }

    function topriv() {
        var query=location.search.substring(1);//获取查询串
        var pairs=query.split("&");//在逗号处断开
        var x = "";
        for(var i=0;i<pairs.length;i++)   {
            var pos=pairs[i].indexOf('=');//查找name=value
            if(pos==-1) continue;//如果没有找到就跳过
            var argname=pairs[i].substring(0,pos);//提取name
            var value=pairs[i].substring(pos+1);//提取value
            if(argname=="p"){

                x+= "p=";
                if(value!=""){

                    var arr = value.split("$");
                    for(var j=0;j<arr.length-2;j++){
                        x+= arr[j]+"$";
                    }
                }
                x+="&";

            }else{
                x+= argname+"="+unescape(value) ;
                x+="&";
            }
        }
        location.href =(location.pathname+"?"+x);
    }

    $(document).ready(function () {
        if(""=="<?php echo $GLOBALS['p']; ?>"){
            $(".privbtn").attr("disabled","disabled");
            $(".home").attr("disabled","disabled");
            $("#upload").attr("disabled","disabled");
        }

        $(".checkall").click(function () {
            $(".check").prop("checked",true);
            gen();
        })
        $(".checkno").click(function () {
            $(".check").prop("checked",false);
            gen();
        })

        $(".check").change(function () {
            gen();
        })
        
        $("#onlyjpg").change(function () {
            parent.returnimg = "";

            if ($(this).is(':checked'))
            {
                $(".check").prop("checked",false);
                $(".items").hide();
                $(".jpg").show();
                $(".png").show();
                $(".bmp").show();
                $(".gif").show();
            }else{
                $(".items").show();
            }
        })
        
        
        
        
        
        $("#upload2").click(function () {
            var form = $("#aaabbb"); //其中的form1是我form的名称
            var options  = {
                //url:'',
                type:'post',
                dataType : 'json',
                success:function(data){

                    if(data.status==0){
                        location.reload();
                    }else{

                        alert(JSON.stringify(data))
                    }

                    //location.reload();

                },
                error:function (data) {

                    alert(JSON.stringify(data))
                }
            };
            form.ajaxSubmit(options);

        })








    })

     function gen() {
         parent.returnimg = "";
         var wh = "";
         var w_val = $("#maxw").val();
         var h_val = $("#maxh").val();
         if(w_val==0 && h_val>0){
             wh = "?imageView2/2/h/"+h_val+"/interlace/0/q/100";
         }else if(w_val>0 && h_val==0){
             wh = "?imageView2/2/w/"+w_val+"/interlace/0/q/100";
         }else if(w_val>0 && h_val>0){
             wh ="?imageView2/1/w/"+w_val+"/h/"+h_val+"/interlace/0/q/100";
         }


         var  ispp="<p>";
         var  ispn = "</p>";

         //alert("fasd");
         var all = $(".check");
         $.each(all,function (e,f) {

             if ($(this).is(':checked')) {
                 var key = ($(this).attr("key"));


                 if(isImg(key)){
                     key += wh ;
                 }

                 if(isImg($(this).attr("key")) ){
                     parent.returnimg = (parent.returnimg+ispp+"<img src='http://<?php echo $qiniu->getdomain()."/".$_GET['p'] ?>"+key+"' />"+ispn+"\n");
                 }

             }
         });

         //alert(parent.returnimg)
     }





    function isImg(target) {
        target = target.toLowerCase();
        var d=target.length-4;
        return (d>=0&&target.lastIndexOf(".jpg")==d)||(d>=0&&target.lastIndexOf(".png")==d)
            ||(d>=0&&target.lastIndexOf(".ico")==d) || (d>=0&&target.lastIndexOf(".bmp")==d) ;

    }
    
    $(".deletedir").click(function () {

        if(!confirm("确定删除")) return ;



        var p =("<?php echo $GLOBALS['p'];?>"+$(this).attr("mykey")+"$")
        //alert(p)
        //document.writeln("/index.php?m=alicms&f=qiniu&v=deletedir&p="+p+"<?php echo $this->su(); ?>")
        $.ajax({
                url:"/index.php?m=alicms&f=qiniu&v=deletedir&p="+p+"<?php echo $this->su(); ?>",
                method:"get",

                dataType:"json",
                success:function (data) {
                    //alert(JSON.stringify(data))
                    location.reload();
                },
                error:function (data) {
                    alert(JSON.stringify(data))

                }

            })
    })
    $(".delete").click(function () {

        if(!confirm("确定删除")) return ;



        var p =("<?php echo $GLOBALS['p'];?>"+$(this).attr("mykey"))
        //alert(p)
//        alert("/index.php?m=alicms&f=qiniu&v=delete"+"<?php //echo $this->su(); ?>//|"+p)
        $.ajax({
                url:"/index.php?m=alicms&f=qiniu&v=delete"+"<?php echo $this->su(); ?>",
                method:"post",
                data:{
                    key:p



                },
                dataType:"json",
                success:function (data) {
//                    alert(JSON.stringify(data))
                    location.reload();
                },
                error:function (data) {
                    alert(JSON.stringify(data))

                }

            })
    })




</script>
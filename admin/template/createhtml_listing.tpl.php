<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel tasks-widget">
                <header class="panel-heading">
                    <span>一键生成内容页自定义静态文件,不需要栏目页配置为静态,只需要内容页自定义url(但需要手动删除)</span>
                </header>
                <div class="panel-body">
                        <!--批量生成栏目页开始-->
                        <div class="col-sm-12">
                        <form name="form1" method="post" >
                           <div class="createhtmllist">
                                 <?php
                                 echo $formcategorys = $form->tree_select($categorys, 0, 'name="catids[]" class="form-control" multiple="multiple" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择"', '≡ 全部 ≡');

                                 ?>
                            </div>
                            <div class="text-center createhtmlbtn">
                            <button type="submit" class="btn btn-primary"><i class="icon-cycle btn-icon"></i>一键生成内容页自定义静态文件</button>
                            </div>
                        </form>
                        </div>
                        <!--批量生成栏目页结束-->




                        
                </div>
            </section>
        </div>
    </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    window.scrollTo(0,0);
</script>
</body>
</html>
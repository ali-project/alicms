<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>

<body>

<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>


<div class="panel-body" id="mybody">

<form method="post">
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">表名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text"  class="form-control" name="dbname" value="" />
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">描述</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text"  class="form-control" name="discribe" value="" />
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">是否邮箱提醒</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                   <select name="tixing">
                       <option value="0">不提醒</option>
                       <option value="1">提醒(stmp)</option>
                       <option value="2">提醒(aliyun)</option>
                   </select>


                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">邮箱地址(用;隔开)</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text"  class="form-control" name="email" value="" />
                </div>
            </div>




             <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" name="submit"  type="submit" value="提交">
                </div>
            </div>
</form>

    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
    <script>

        $(document).ready(function () {






        });




    </script>







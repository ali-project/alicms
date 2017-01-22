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
        <div style="margin-left: 40px;margin-top: 20px;">

            <button type="submit" class="btn btn-info btn-sm addnew">新增</button>
            <button type="submit" class="btn btn-info btn-sm flush">刷新</button>

        </div>

        <div class="panel-body" id="mybody">
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
                <tr>
                    <td>111111</td>
                    <td>111111</td>
                    <td>111111</td>
                    <td>111111</td>
                    <td>111111</td>
                    <td>111111</td>


                </tbody>

            </table>

        </div>


    </div>
</section>

</body>



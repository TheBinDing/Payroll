<?php
    @session_start();
    require("../inc/connect.php");
    require("../inc/function.php");
    require("PasswordSearch.php");
    // echo base64_decode('MTIzNDU2Nzg=');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="../css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="../css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/blue/pace-theme-loading-bar.css" />
    <link href="../css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body>
    <div class="row">
        <div id="page-wrapper" class="gray-bg">
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <h1>
                <span> รหัสผ่าน </span>
            </h1>
            <div class="ibox-content">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-2">ทำงาน</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-2" class="tab-pane active">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="editable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">#</th>
                                            <th style="text-align: center;">ชื่อ/นามสกุล</th>
                                            <th style="text-align: center;">ชื่อผู้ใช้งานระบบ</th>
                                            <th style="text-align: center;">รหัส</th>
                                            <th style="text-align: center;">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i=1;$i<=$num;$i++)
                                            {
                                                $row = mssql_fetch_array($query);

                                                $pass = base64_decode($row['pass']);
                                        ?>
                                        <tr>
                                            <td scope="row" style="text-align: center;"><?php echo $i?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8', $row['name']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8', $row['users']); ?></a>
                                            <td style=""><?php echo $pass; ?></a>
                                            <td style=""><?php echo $row['mails']; ?></a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../js/inspinia.js"></script>
<script src="../js/plugins/pace/pace.min.js"></script>
<script src="../js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="../js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="../js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="../js/plugins/dataTables/dataTables.tableTools.min.js"></script>
<script src="../js/plugins/iCheck/icheck.min.js"></script>
<script src="../js/pace.js"></script>
<script type="text/javascript">
    (function ( $ ) {
        var oTable = $('#editable').dataTable();
        var oTable = $('#editableOut').dataTable();
        var oTable = $('#editableBlacklist').dataTable();

        $('#Excel').click(function(event) {
            window.open("excel/ExportToExcel.php");
        });
    } (jQuery));

    paceOptions = {
      elements: true
    };
</script>

<html>
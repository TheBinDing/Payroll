<?php
    @session_start();
    require("inc/connect.php");
    require('func/StructureSearch.php');
    require("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'Structure';
    $_SESSION['Link'] = 'Structure.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<style>
    .showImg {
        width:100%;
        height:150px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background-color: #fff;
        background-image: url('img/tpoly_load.gif');
        background-repeat: no-repeat;
        background-position:center 50%;
    }

    .shows {
        position:fixed;
        top:0px;
        left:0px;
        width:100%;
        height:100%;
        z-index:99;
        display: none;
    }
</style>
<body>
    <div class="row">        
        <?php
            require("Head2.php");
        ?>
        <div id="page-wrapper" class="gray-bg">
        <?php require("MenuSite.php"); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <h1>
                <span> โครงการ </span>
                <a data-toggle="modal" data-target="#myModal1" class="open-sendnames glyphicon glyphicon-plus-sign" ></a>
            </h1>
            <?php require('StructureDetail.php'); ?> 
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
    </div>
    <div id="block" class="sweet-overlay">
        <div id="loading" class="shows">
            <div style="margin:20% auto;width: 250px;">
                <div class="showImg"></div>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/plugins/datapicker/bootstrap-datepicker-thai.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/footable/footable.all.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/pace.js"></script>
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>
<script type="text/javascript">
    (function($){
        $('.footable').footable();

        var oTable = $('#editable').dataTable();

        $('#data_2 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $("td").click(function(){
            if($(this).attr("contentEditable") == true){
                $(this).attr("contentEditable","false");
            } else {
                $(this).attr("contentEditable","true");
            }
        })
    } (jQuery));
</script>
<script type="text/javascript">
    $(document).ready(function()
        {$('.SubmitData').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 2000,
                showConfirmButton: false
            },function(){
                window.location='Structure.php';
            });
        });

        $('.Soc').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 2000,
                showConfirmButton: false
            },function(){
                swal("บันทึกข้อมูลเรียบร้อย")
            });
        });
    });

    $('.open-sendname').click(function(event) {
        var name = $(this).data('id');
        var code = $(this).data('code');
        var status = $(this).data('a');
        var id = $(this).data('b');

        $('#Site_Codes').val(code);
        $('#Site_Names').val(name);
        $('#Site_IDs').val(id);

        if(status == '1') {
            document.getElementById("Status11").checked = true;
        }
        if(status == '0') {
            document.getElementById("Status12").checked = true;
        }
    });
</script>
<script>
    paceOptions = {
      elements: true
    };
</script>

<html>
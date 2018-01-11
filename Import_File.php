<?php
    @session_start();
    require("inc/connect.php");
    require("func/FileSearch.php");
    include("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'Import_File';
    $_SESSION['Link'] = 'Import_File.php';
    // if($_SESSION['user_name'] == "")
    // {
    //     echo "Please Login!";
    //     exit("<script>alert('Please Login');window.location='login.php';</script>");
    // }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" style="overflow: hidden;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <link href="css/clockpicker.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
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
        <div id="page-wrapper" class="gray-bg" style="height: auto;">
        <?php require("MenuSite.php"); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <h1>
                                <span> นำเข้าเวลาทำงาน </span>
                            </h1>
                            <div class="ibox-content">
                                <form name="frmMain" method="post" action="func/ImportSaveFile.php" enctype="multipart/form-data">
                                <!-- <form name="frmMain" method="post" action="func/ImportSaveFile.php" enctype="multipart/form-data" target="iframe_target">
                                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe> -->
                                    <input type="file" name="filUpload"><br>
                                    <input name="btnSubmit" type="submit" value="นำเข้าไฟล์" onclick="show();" class="btn btn-success demo1">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="block" class="sweet-overlay" onClick="">
        <div id="loading" class="shows">
            <div style="margin:20% auto;width: 250px;">
                <div class="showImg"></div>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/clockpicker.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/footable/footable.all.min.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/pace.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        // $('.demo1').click(function(event) {
        //     swal({
        //         title : "โปรดรอซักครู่!",
        //         text : "กำลังบันทึกข้อมูล",
        //         timer : 300000,
        //         showConfirmButton : false
        //     },function(){
        //         // window.location.assign("TimeCal.php")
        //         window.location='TimePlan.php';
        //     });
        // });

        $('.Soc').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 2000,
                showConfirmButton: false
            },function(){
                swal("บันทึกข้อมูลเรียบร้อย");
            });
        });

        $('.footable').footable();
    });

</script>
<script type="text/javascript">
    function show() {
        $('#loading').css('display','block');
        $('#block').css('display','block');
        $('html').css('overflow','hidden');
    }
</script>

<html>
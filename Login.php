<?php
    require("inc/connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
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
    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <img src="img/Thaipolycons.jpg">

            </div>
            <!-- <form class="m-t" role="form" action="checklogin.php" method="POST"> -->
            <form class="m-t" role="form" action="checklogin.php" method="POST" enctype="multipart/form-data" target="iframe_target">
            <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                <div class="form-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="ชื่อผู้ใช้งาน" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผู้ใช้งาน" required>
                </div>
                <button type="submit" class="btn btn-success block full-width m-b SubmitData">Login</button>

                <!-- <a href="#"><small>Forgot password?</small></a> -->
                <!-- <a class="btn btn-sm btn-white btn-block" href="register.php">Create an account</a> -->
            </form>
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
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function()
        {$('.SubmitData').click(function(){
            if($('#username').val() != '' && $('#password').val() != ''){
                swal({
                    title: "โปรดรอซักครู่!",
                    timer: 3000,
                    showConfirmButton: false
                },function(){
                    window.location='News.php';
                });
            }
        });
    });
</script>
<html>
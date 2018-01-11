<?php
    @session_start();
    require("inc/connect.php");
    require("inc/function.php");
    checklogin($_SESSION['user_name']);
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
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body>
    <div class="row">
        <?php
            require("Head2.php");
            require('func/ProfileSearch.php');
        ?>
        <div id="page-wrapper" class="gray-bg">
        <?php require("MenuSite.php"); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
                <h1>
                    <span> ประวัติผู้ใช้งาน .. </span>
                </h1>
                <br>
                <!-- <form action="func/ProfileSave.php" method="POST" enctype="multipart/form-data"> -->
                <form action="func/ProfileSave.php" method="POST" enctype="multipart/form-data" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-4">
                        <a href="#">
							<?php if(iconv('UTF-8','TIS-620', $row['pic']) != '') { ?>
								<img alt="" src="img/<?php echo iconv('UTF-8','TIS-620', $row['pic']); ?>" data-holder-rendered="true" style="width: 300px;">
							<?php } else { ?>
								<img alt="" src="img/admin.jpg" data-holder-rendered="true" style="width: 300px;">
							<?php } ?>
                        </a>
                        <fieldset class="form-group">
                            <label for="exampleInputFile">ภาพประจำตัว</label>
                            <input type="file" name="filUpload"><br>
                            <small class="text-muted"></small>
                        </fieldset>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group required ">
                            <label>ผู้ใช้งานระบบ</label>
                            <input type="text" value="<?php echo $row['users']; ?>" id="name" name="name" class="form-control" readonly>
                        </div>

                        <div class="form-group required ">
                            <label>E-mail</label>
                            <input type="mail" value="<?php echo $row['mails']; ?>" id="mail" name="mail" class="form-control" />
                        </div>

                        <div class="form-group required ">
                            <label>รหัสเข้าใช้งาน</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>

                        <div class="form-group required ">
                            <label>ยืนยันรหัสเข้าใช้งาน</label>
                            <input type="password" id="confirm" name="confirm" class="form-control">
                        </div>

                        <div class="form-group required " style="padding:20px 15px;">
                            <button type="submit" class="btn btn-success demo1">แก้ไขข้อมูล</button>
                            <a href="" class="btn btn-danger" role="button">กลับ</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/pace.js"></script>
<script type="text/javascript">
    $('.demo1').click(function(){
        if( $('#password').val() != $('#confirm').val() ) {
            swal("รหัสผ่านไม่ตรงกัน!")
        }
        else if( $('#password').val() == $('#confirm').val() ) {
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 2000,
                showConfirmButton: false
            },function(){
                window.location='News.php';
            });
        }
    });
</script>

<html>
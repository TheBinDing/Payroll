<?php
    @session_start();
    require("inc/connect.php");
    include("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'Plan';
    $_SESSION['Link'] = 'Plan.php';
    // if($_SESSION['user_name'] == "")
    // {
    //     echo "Please Login!";
    //     exit("<script>alert('Please Login');window.location='login.php';</script>");
    // }
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
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body>
    <div class="row">
        <?php
            require("Head2.php");
        ?>
        <div id="page-wrapper" class="gray-bg">
        <?php require("MenuSite.php"); ?>
            <?php require('func/PlanSearch.php'); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <h1>
                <!-- <a class="glyphicon glyphicon-user" href="Plan.php?Page=New"><span> ตั้งค่าแผนเวลา </span></a> -->
            <?php if(!empty($TimePlan_ID)) { echo '<span> ตั้งค่าแผนเวลา </span>'; }else if($Page == 'New'){ echo '<span> ตั้งค่าแผนเวลา </span>'; }else{ echo '<span> ตั้งค่าแผนเวลา </span><a class="glyphicon glyphicon-plus-sign" href="Plan.php?Page=New"></a>'; } ?>
            </h1>
            <?php if(!empty($TimePlan_ID)) { require('PlanEdit.php'); }else if($Page == 'New'){ require('PlanEdit.php'); }else{ require('PlanDetail.php'); } ?>
            <?php
                // include("footer.php");
            ?>            
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker-thai"></script>
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
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script>

    function load(time){
      var x = new XMLHttpRequest();
      // x.open('GET', "http://localhost:5646/walter/" + time, true);
      // x.send();
    };

    paceOptions = {
      elements: true
    };

    load(20);
    load(100);
    load(500);
    load(2000);
    load(3000);

    setTimeout(function(){
      Pace.ignore(function(){
        load(3100);
      });
    }, 4000);

    Pace.on('hide', function(){
      console.log('done');
    });

    range.addEventListener('input', function(){
        document.querySelector('.pace').classList.remove('pace-inactive');
        document.querySelector('.pace').classList.add('pace-active');

        document.querySelector('.pace-progress').setAttribute('data-progress-text', range.value + '%');
        document.querySelector('.pace-progress').setAttribute('style', '-webkit-transform: translate3d(' + range.value + '%, 0px, 0px)');
    });
</script>
<script type="text/javascript">
    (function($){
        // $('#CK_in').clockpicker();
        // $('#CK_in2').clockpicker();
        // $('#Ck_Out1').clockpicker();
        // $('#Ck_Out2').clockpicker();
        // $('#CKOT_in1').clockpicker();
        // $('#CKOT_Out1').clockpicker();
        // $('#CKOT_in2').clockpicker();
        // $('#CKOT_Out2').clockpicker();
        $('#data_5 .input-daterange').datepicker({
            dateFormat: 'dd-mm-yy',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            isBuddhist: true
        });
        $('.footable').footable();

        $('.demo1').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 2000,
                showConfirmButton: false
            },function(){
                window.location='Plan.php';
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
    } (jQuery));

    function calcu() {
        var a = $('#CK_in').val();
        var res = a.split(":");
        var n1 = parseInt(res[0]);
        var n2 = parseInt(res[1]);
        var Ck_Out1_1 = (n1 + 4);
        var Ck_Out1_2 = (n2 + 30);
        if(Ck_Out1_2 == '60') {
            Ck_Out1_1 = (Ck_Out1_1 + 1);
            Ck_Out1_2 = '00';
        }
        Ck_Out1 = Ck_Out1_1+':'+Ck_Out1_2;

        CK_in2_1 = (Ck_Out1_1 + 1);
        Ck_Out2_1 = (CK_in2_1 + 4);
        Ck_Out2_2 = (parseInt(Ck_Out1_2) + 30);
        if(Ck_Out2_2 == '60') {
            Ck_Out2_1 = (Ck_Out2_1 + 1);
            Ck_Out2_2 = '00';
        }
        CK_in2 = CK_in2_1+':'+Ck_Out1_2;

        Ck_Out2 = Ck_Out2_1+':'+Ck_Out2_2;

        CKOT_in1 = (Ck_Out2_1 + 1)+':'+Ck_Out2_2;

        CKOT_Out1_1 = ((Ck_Out2_1 + 1) + 5);
        CKOT_Out1_2 = (parseInt(Ck_Out2_2) + 29);
        if(Ck_Out2_2 == '60') {
            CKOT_Out1_1 = (CKOT_Out1_1 + 1);
            CKOT_Out1_2 = '00';
        }
        CKOT_Out1 = CKOT_Out1_1+':'+CKOT_Out1_2;

        CKOT_in2_1 = (CKOT_Out1_1 - 1);
        CKOT_in2_2 = (parseInt(CKOT_Out1_2) + 1);
        if(CKOT_in2_2 == '60') {
            CKOT_in2_1 = (CKOT_in2_1 + 1);
            CKOT_in2_2 = '00';
        }
        CKOT_in2 = (CKOT_in2_1 + 1)+':'+CKOT_in2_2;

        $('#Ck_Out1').val(Ck_Out1);
        $('#CK_in2').val(CK_in2);
        $('#Ck_Out2').val(Ck_Out2);
        $('#CKOT_in1').val(CKOT_in1);
        $('#CKOT_Out1').val(CKOT_Out1);
        $('#CKOT_in2').val(CKOT_in2);
    }
</script>

<html>
<?php
    @session_start();
    require("inc/connect.php");
    require('func/CalcuMoneySaveIT.php');
    require("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'CalcuMoney';
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
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body onload="display();">
    <div class="row">
        <?php
            require("Head2.php");
        ?>
        <div id="page-wrapper" class="gray-bg">
        <?php require("MenuSite.php"); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <h1>
                <span> คำนวณเงิน </span>
                <?php if($lable == 1 || $lable == 0) { ?>
                    <button class="btn btn-success pull-right" id="Report1" style="margin-right: 5px;">ใบสลิป</button>
                    <button class="btn btn-success pull-right" id="Report3" style="margin-right: 5px;">ใบปะหน้าเพิ่มเติม</button>
                    <button class="btn btn-success pull-right" id="Report2" style="margin-right: 5px;">ใบปะหน้า</button>
                <?php } ?>
            </h1>
            <?php require('CalcuMoneyDetailIT.php'); ?>      
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
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

    // range.addEventListener('input', function(){
    //     document.querySelector('.pace').classList.remove('pace-inactive');
    //     document.querySelector('.pace').classList.add('pace-active');

    //     document.querySelector('.pace-progress').setAttribute('data-progress-text', range.value + '%');
    //     document.querySelector('.pace-progress').setAttribute('style', '-webkit-transform: translate3d(' + range.value + '%, 0px, 0px)');
    // });
</script>
<script type="text/javascript">
    (function ( $ ) {
        $('#start').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
        $('#end').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
            }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

        var site = $('#Site_ID').val();
        var position = $('#Pos').val();
        var group = $('#Group').val();
        var period = $('#Period').val();

        $('#Report1').click(function(event) {
            window.open("pdf/PDF02.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
        });
        $('#Report2').click(function(event) {
            window.open("pdf/PDF01.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
        });
        $('#Report3').click(function(event) {
            window.open("pdf/PDF04.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
        });
        
        $('.footable').footable();

        $('#CalcuV').click(function(event) {
            $('#Check').val('0');
        });
        $('#CalcuN').click(function(event) {
            $('#View').val('0');
        });
        $('#CalcuD').click(function(event) {
            $('#View').val('0');
            $('#Check').val('0');
        });

        var lable = $('#lable').val();
        var lableDT = $('#lableDT').val();
        if(lable != '') {
            if(lable == 3 ) {
                text = 'สถานะ : ทำการตัดวีคซ้ำ';
                $('#tlable').text(text);
                $('#tlable').css('color','#FF3333');
            }
            if(lable == 1 ) {
                text = 'สถานะ : คำนวณเงินแล้ว'+ 'วันที่ตัดวีค : ' +lableDT;
                $('#tlable').text(text);
                $('#tlable').css('color','#FF3333');
            }
            if(lable == 2 ) {
                text = 'สถานะ : รอการคำนวณ';
                $('#tlable').text(text);
                $('#tlable').css('color','#00CC00');
            }
        }

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

    function display() {
        var a  = $('#Period').val();
        if(a == '') {
            $('#Report1').css('display', 'none');
            $('#Report2').css('display', 'none');
            $('#Report3').css('display', 'none');
        } else {
            $('#Report1').css('display', '');
            $('#Report2').css('display', '');
            $('#Report3').css('display', '');
        }
    }
</script>

<html>
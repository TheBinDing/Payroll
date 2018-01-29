<?php
    /**
    * Simple example script using PHPMailer with exceptions enabled
    * @package phpmailer
    * @version $Id$
    */

    @session_start();
    date_default_timezone_set('Asia/Bangkok');

    require("PHPMailer_5.2.4/class.phpmailer.php");
    require("inc/connect.php");
    require('func/CalcuMoneySearch.php');
    require("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'CalcuMoney';
    $_SESSION['Link'] = 'CalcuMoney.php';
    ini_set('max_execution_time', 600);
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
    <link href="css/plugins/switchery/switchery.css" rel="stylesheet">
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
                <span> คำนวณเงิน </span><br><br>
                <?php if(($lable == 1 || $lable == 0 || $lable == 3) && $lable != '') { ?>
                    <!-- <button class="btn btn-success pull-right" id="Report1" style="margin-right: 5px;">ใบสลิป</button>
                    <button class="btn btn-success pull-right" id="Report3" style="margin-right: 5px;">ใบปะหน้าเพิ่มเติม</button>
                    <button class="btn btn-success pull-right" id="Report2" style="margin-right: 5px;">ใบปะหน้า</button> -->

					<div class="btn-group">
						<button class="btn btn-success" id="Report1">ใบสลิป</button>
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">ปริ้นใบปะหน้า <span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="#" id="Report2">ใบปะหน้า</a></li>
								<li><a href="#" id="Report3">ใบปะหน้าเพิ่มเติม</a></li>
							</ul>
						</div>
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-warning dropdown-toggle">ธนาคาร <span class="caret"></span></button>
							<ul class="dropdown-menu">
                                <li><a href="#" id="Report4">ใบรับเงิน</a></li>
								<li><a href="#" id="Report5">Text File ส่งธนาคาร กสิกรไทย</a></li>
								<!-- <li><a href="#">Text File ส่งธนาคาร บัตรเงินสด กสิกรไทย (16 หลัก)</a></li> -->
							</ul>
						</div>
						<div class="col-lg-2" id="data_1">
							<div class="input-group date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" style="padding-left: 20px;">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="Date" id="Date" class="form-control" value="<?php echo date('d-m-Y'); ?>" style="width: 100px;height: 30px;" readonly>
							</div>
						</div>
                        <?php if($_SESSION['Rule'] != 2) { ?>
                        <a class="btn btn-success pull-right" role="button" onClick="cancelAnnounce();">แจ้งยกเลิก</a>
                        <?php } ?>
					</div>
                <?php } if($lable == '2') { ?>
                    <a class="btn btn-success pull-right" style="margin-bottom: 10px;" role="button" onClick="Announce();">แจ้งตัดวีค</a>
                <?php } ?>
            </h1>
            <?php require('CalcuMoneyDetail.php'); ?>      
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/plugins/datapicker/bootstrap-datepicker-thai.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/clockpicker.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/footable/footable.all.min.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/switchery/switchery.js"></script>
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
        $('#Report4').click(function(event) {
            window.open("func/ReportBank.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
        });
        $('#Report5').click(function(event) {
            var day = $('#Date').val();
            window.open("func/ReportBankText.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period +"&Day="+ day);
        });
        $('#Cancel').click(function(event) {
            window.open("func/SendMailC.php?Site="+ site +"&Period="+ period);
        });
        $('#Report6').click(function(event) {
            window.open("test.php");
        });

        $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
        
        $('.footable').footable();

        $('#CalcuV').click(function(event) {
            $('#Check').val('0');
            $('#Back').val('0');
        });
   //      $('#CalcuC').click(function(event) {
   //          $('#Check').val('0');
			// $('#Back').val('0');
            
   //          var site = $('#Site_ID').val();
   //          var period = $('#Period').val();

   //          window.open("func/SendMailC.php?Site="+ site +"&Period="+ period);
   //      });
        $('#CalcuN').click(function(event) {
            $('#View').val('0');
			$('#Back').val('0');
            
            var site = $('#Site_ID').val();
            var period = $('#Period').val();

            // window.open("func/SendMailW.php?Site="+ site +"&Period="+ period);
        });
        $('#CalcuB').click(function(event) {
            $('#Check').val('0');
            $('#View').val('0');
        });
        $('#CalcuD').click(function(event) {
            $('#View').val('0');
            $('#Check').val('0');
        });

        var lable = $('#lable').val();
        var lableDT = $('#lableDT').val();
        if(lable != '') {
            if(lable == 0 ) {
                text = 'สถานะ : ทำการตัดวีค';
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
            if(lable == 3 ) {
                text = 'สถานะ : คำนวณเงินแล้ว'+ 'วันที่ตัดวีค : ' +lableDT;
                $('#tlable').text(text);
                $('#tlable').css('color','#FF3333');
            }
        }

        $('.SubmitData').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 10000,
                showConfirmButton: false
            },function(){
                window.location='CalcuMoney.php';
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

    var travflex = {
        compulsory: new Object()
    };

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
<script type="text/javascript">
    jQuery(function( $ ) {
        travflex.compulsory.Criteria = {};

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
    });

    var travflex = {
        compulsory: new Object()
    };

    function Announce() {
        travflex.compulsory.Criteria['mode'] = 'sendAnnounce';
        travflex.compulsory.Criteria['Period'] = $('#Period').val();
        travflex.compulsory.Criteria['Site'] = $('#Site_ID').val();
        travflex.compulsory.Criteria['pass'] = 'tpolypassword';
        travflex.compulsory.Criteria['from'] = '<?php echo $_SESSION['SuperMail']; ?>';
        travflex.compulsory.Criteria['name'] = '<?php echo $_SESSION['SuperName']; ?>';
        travflex.compulsory.Criteria['send'] = '1';

        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            if(response == 1) {
                swal("แจ้งตัดวีคเรียบร้อย!");
            } else {
                swal("ไม่สามารถแจ้งตัดวีคได้!");
            }
        });
    }

    function cancelAnnounce() {
        travflex.compulsory.Criteria['mode'] = 'sendCAnnounce';
        travflex.compulsory.Criteria['Period'] = $('#Period').val();
        travflex.compulsory.Criteria['Site'] = $('#Site_ID').val();
        travflex.compulsory.Criteria['pass'] = 'tpolypassword';
        travflex.compulsory.Criteria['from'] = '<?php echo $_SESSION['SuperMail']; ?>';
        travflex.compulsory.Criteria['name'] = '<?php echo $_SESSION['SuperName']; ?>';
        travflex.compulsory.Criteria['send'] = '1';

        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            if(response == 1) {
                swal("แจ้งยกเลิกการตัดวีคเรียบร้อย!");
            } else {
                swal("ไม่สามารถแจ้งตัดวีคได้!");
            }
        });
    }
</script>

<html>
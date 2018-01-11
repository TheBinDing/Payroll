<?php
    @session_start();
    require("inc/connect.php");
    require('func/TimePlanDetailSearch.php');
    require("inc/function.php");
    checklogin($_SESSION[user_name]);
    $HeadCheck = 'TimePlan';
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
    <link href="css/plugins/iCheck/custom.css" rel="stbylesheet">
    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
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
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <h1>
                <span> แก้ไขเวลา </span>
            </h1>
            <div class="ibox-content">
                <!-- <form name="form1" method="POST" action="func/TimePlanDetailSave.php"> -->
                <form  method="POST" action="func/TimePlanDetailSave.php" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="bs-callout">
                        <div class="form-group">
                            <label class="radio-inline" style="height: 20px;width: 140px;">ชื่อ-สกุล</label>
                            <input type="text" class="form-control-normal" style="height: 30px;text-align: center;" id="name" name="name" value="<?php echo $names;?>" readonly>

                            <div class="radio radio-info radio-inline pull-right" style="background-color: red;color: white;">
                                <input type="radio" name="Del" id="Del" value="1"  >
                                <label for="inlineRadio1"> ลบลายสแกนนิ้ว </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-inline width-text2 " id="LogTime" data-date="<?php echo $LogTime; ?>" data-date-format="dd-mm-yyyy">
                                <label class="radio-inline" style="height: 30px;width: 120px;"> วันที่ </label>
                                <input class="span2" name="LogTime" id="LogTime" type="text" value="<?php echo $LogTime; ?>" readonly style="text-align: center;height: 30px;">&nbsp;&nbsp;&nbsp;<a class="close-link" id="pCK_in"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="form-group">
							<input type="hidden" id="PCK_in" value="<?php echo $PCK_in; ?>" >
							<input type="hidden" id="PCk_Out1" value="<?php echo $PCk_Out1; ?>" >
							<input type="hidden" id="PCK_in2" value="<?php echo $PCK_in2; ?>" >
							<input type="hidden" id="PCk_Out2" value="<?php echo $PCk_Out2; ?>" >
							<input type="hidden" id="PCKOT_in1" value="<?php echo $PCKOT_in1; ?>" >
							<input type="hidden" id="PCKOT_Out1" value="<?php echo $PCKOT_Out1; ?>" >
							<input type="hidden" id="PCKOT_in2" value="<?php echo $PCKOT_in2; ?>" >
							<input type="hidden" id="PCKOT_Out2" value="<?php echo $PCKOT_Out2; ?>" >
							<input type="hidden" id="SuperSite" value="<?php echo $_SESSION['SuperSite']; ?>" >
                            <div class="radio-inline width-text2">
                                <label class="radio-inline" style="height: 20px;width: 120px;"><span>เข้างานเช้า</span>&nbsp;<a class="close-link" id="xCK_in"><i class="fa fa-times"></i></a></label>
                                <input class="form-control-normal" name="CK_in" id="CK_in" type="text" value="<?php echo $CK_in;?>" data-mask="99:99" style="text-align: center;height: 30px;">
                            </div>
                            <div class="radio-inline width-text2">
                                <label class="radio-inline" style="height: 20px;width: 120px;margin-left: 50px;"><span>ออกงานเช้า</span>&nbsp;<a class="close-link" id="xCk_Out1"><i class="fa fa-times"></i></a></label>
                                <input class="form-control-normal" name="Ck_Out1" id="Ck_Out1" type="text" value="<?php echo $Ck_Out1;?>" data-mask="99:99" style="text-align: center;height: 30px;margin-left: 50px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio-inline width-text2">
                                <label class="radio-inline" style="height: 20px;width: 120px;"><span>เข้างานบ่าย</span>&nbsp;<a class="close-link" id="xCK_in2"><i class="fa fa-times"></i></a></label>
                                <input class="form-control-normal" name="CK_in2" id="CK_in2" type="text" value="<?php echo $CK_in2;?>" data-mask="99:99" style="text-align: center;height: 30px;">
                            </div>
                            <div class="radio-inline width-text2">
                                <label class="radio-inline" style="height: 20px;width: 120px;margin-left: 50px;"><span>ออกงานบ่าย</span>&nbsp;<a class="close-link" id="xCk_Out2"><i class="fa fa-times"></i></a></label>
                                <input class="form-control-normal" name="Ck_Out2" id="Ck_Out2" type="text" value="<?php echo $Ck_Out2;?>" data-mask="99:99" style="text-align: center;height: 30px;margin-left: 50px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio-inline width-text2">
                                <label class="radio-inline" style="height: 20px;width: 120px;"><span>เข้าOT1.5</span>&nbsp;<a class="close-link" id="xCKOT_in1"><i class="fa fa-times"></i></a></label>
                                <input class="form-control-normal" name="CKOT_in1" id="CKOT_in1" type="text" value="<?php echo $CKOT_in1;?>" data-mask="99:99" style="text-align: center;height: 30px;">
                            </div>
                            <div class="radio-inline width-text2">
                                <label class="radio-inline" style="height: 20px;width: 120px;margin-left: 50px;"><span>ออกOT1.5</span>&nbsp;<a class="close-link" id="xCKOT_Out1"><i class="fa fa-times"></i></a></label>
                                <input class="form-control-normal" name="CKOT_Out1" id="CKOT_Out1" type="text" value="<?php echo $CKOT_Out1;?>" data-mask="99:99" style="text-align: center;height: 30px;margin-left: 50px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio-inline width-text2">
                                <label class="radio-inline" style="height: 20px;width: 120px;"><span>เข้าOT2</span>&nbsp;<a class="close-link" id="xCKOT_in2"><i class="fa fa-times"></i></a></label>
                                <input class="form-control-normal" name="CKOT_in2" id="CKOT_in2" type="text" value="<?php echo $CKOT_in2;?>" data-mask="99:99" style="text-align: center;height: 30px;">
                            </div>
                            <div class="radio-inline width-text2">
                                <label class="radio-inline" style="height: 20px;width: 120px;margin-left: 50px;"><span>ออกOT2</span>&nbsp;<a class="close-link" id="xCKOT_Out2"><i class="fa fa-times"></i></a></label>
                                <input class="form-control-normal" name="CKOT_Out2" id="CKOT_Out2" type="text" value="<?php echo $CKOT_Out2;?>" data-mask="99:99" style="text-align: center;height: 30px;margin-left: 50px;">
                            </div>
                        </div>

                        <div class="form-group col-sm-4"></div>
                        <div class="form-group col-sm-8">
                            <input type="hidden" name="Em_ID" id="Em_ID" value="<?php echo $Em_ID; ?>" />
                            <button type="submit" id="SubM" class="btn btn-success SubmitData">เพิ่มข้อมูล</button>
                            <button type="submit" id="Deld" class="btn btn-success SubmitData" style="display: none;">ลบข้อมูล</button>
                            <a href="TimePlan.php?Check=2" class="btn btn-danger" role="button">ย้อนกลับ</a>
                        </div>
                    </div>
                </form>
            </div>
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
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script type="text/javascript">
    (function($){
        $('#pCK_in').click(function(event) {
            var CK_in = $('#CK_in').val();
            var Ck_Out1 = $('#Ck_Out1').val();
            var CK_in2 = $('#CK_in2').val();
            var Ck_Out2 = $('#Ck_Out2').val();
            var CKOT_in1 = $('#CKOT_in1').val();
            var CKOT_Out1 = $('#CKOT_Out1').val();
            var CKOT_in2 = $('#CKOT_in2').val();
            var CKOT_Out2 = $('#CKOT_Out2').val();
			var SuperSite = $('#SuperSite').val();

			if(CK_in == ' ' || CK_in == '') {
				$('#CK_in').val($('#PCK_in').val());
			}
			if(Ck_Out1 == ' ' || Ck_Out1 == '') {
				$('#Ck_Out1').val($('#PCk_Out1').val());
			}
			if(CK_in2 == ' ' || CK_in2 == '') {
				$('#CK_in2').val($('#PCK_in2').val());
			}
			if(Ck_Out2 == ' ' || Ck_Out2 == '') {
				$('#Ck_Out2').val($('#PCk_Out2').val());
			}
			if(SuperSite == '19' || SuperSite == '20' || SuperSite == '21') {
				if(CKOT_in1 == ' ' || CKOT_in1 == '') {
					$('#CKOT_in1').val('18:00');
				}
			} else {
				if(CKOT_in1 == ' ' || CKOT_in1 == '') {
					$('#CKOT_in1').val($('#PCKOT_in1').val());
				}
			}
			if(CKOT_Out1 == ' ' || CKOT_Out1 == '') {
				$('#CKOT_Out1').val($('#PCKOT_Out1').val());
			}
			if(CKOT_in2 == ' ' || CKOT_in2 == '') {
				$('#CKOT_in2').val($('#PCKOT_in2').val());
			}
			if(CKOT_Out2 == ' ' || CKOT_Out2 == '') {
				$('#CKOT_Out2').val($('#PCKOT_Out2').val());
			}
        });
		$('#xCK_in').click(function(event) {
            var test = ' ';
            $('#CK_in').val(test);
        });
        $('#xCK_in2').click(function(event) {
            var test = ' ';
            $('#CK_in2').val(test);
        });
        $('#xCk_Out1').click(function(event) {
            var test = ' ';
            $('#Ck_Out1').val(test);
        });
        $('#xCk_Out2').click(function(event) {
            var test = ' ';
            $('#Ck_Out2').val(test);
        });
        $('#xCKOT_in1').click(function(event) {
            var test = ' ';
            $('#CKOT_in1').val(test);
        });
        $('#xCKOT_Out1').click(function(event) {
            var test = ' ';
            $('#CKOT_Out1').val(test);
        });
        $('#xCKOT_in2').click(function(event) {
            var test = ' ';
            $('#CKOT_in2').val(test);
        });
        $('#xCKOT_Out2').click(function(event) {
            var test = ' ';
            $('#CKOT_Out2').val(test);
        });

        $('#Del').click(function() {
            $('#SubM').css('display', 'none');
            $('#Deld').css('display', '');
        })

        $('.SubmitData').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 4000,
                showConfirmButton: false
            },function(){
                window.location='TimePlan.php?Check=2';
            });
        });
    } (jQuery));
</script>

<html>
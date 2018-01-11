<?php
    @session_start();
    require("inc/connect.php");
    include("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'Report';
    $_SESSION['Link'] = 'Report.php';
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
                <span> รายงานอื่นๆ </span><br><br>
                <div class="btn-group">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">ประกันสังคม <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="Report5">ประกันสังคม</a></li>
                            <li><a href="#" id="Report6">ข้อมูลพนักงาน</a></li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">ค่าแรง <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="Report1">ค่าครองชีพ</a></li>
                            <li><a href="#" id="Report2">เบี้ยเลี้ยง</a></li>
                            <li><a href="#" id="Report8">ภ.ง.ด.1</a></li>
                        </ul>
                    </div>
                </div>
            </h1>
            <?php require('ReportDetail.php'); ?>          
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
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/plugins/switchery/switchery.js"></script>
<script type="text/javascript">
    (function($){
        $('.footable').footable();

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
    } (jQuery));
</script>
<script type="text/javascript">
    function Report() {
        site = $('#Site').val();
        position = $('#Position').val();
        group = $('#Group').val();
        period = $('#Period').val();
        report = $('#Report').val();

        if(report == 1) {
            window.open("pdf/PDF02.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
        }
        if(report == 2) {
            window.open("pdf/PDF01.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
        }
        if(report == 3) {
            window.open("pdf/PDF04.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
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

    function SelectYear() {
        travflex.compulsory.Criteria['mode'] = 'load_year_list';
        travflex.compulsory.Criteria['Site'] = $('#Site').val();
        travflex.compulsory.Criteria['Year'] = $('#Year').val();
        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            YearList = response;
            setYear();
        });
    }

    function setYear() {
        result = YearList;
        div = document.getElementById('Period');
        div.innerHTML = '';
        div.add(new Option('โปรดเลือกงวด', ''));
        for(i in result){
            div.add(new Option(result[i]['LongName'], result[i]['Code']));
        }
    }

    $('#Report5').click(function(event) {
        site = $('#Site').val();
        year = $('#Year').val();
        period = $('#Period').val();
        month = $('#Month').val();

        window.open("func/ReportSocie.php?Site="+ site +"&Year="+ year +"&Period="+ period +"&Month="+ month);
    });

    $('#Report6').click(function(event) {
        site = $('#Site').val();
        year = $('#Year').val();
        period = $('#Period').val();
        month = $('#Month').val();

        window.open("func/ReportEmployee.php?Site="+ site +"&Year="+ year +"&Period="+ period +"&Month="+ month);
    });

    $('#Report1').click(function(event) {
        site = $('#Site').val();
        year = $('#Year').val();
        period = $('#Period').val();
        month = $('#Month').val();

        window.open("func/ReportCost.php?Site="+ site +"&Year="+ year +"&Period="+ period +"&Month="+ month);
    });

    $('#Report2').click(function(event) {
        site = $('#Site').val();
        year = $('#Year').val();
        period = $('#Period').val();
        month = $('#Month').val();

        window.open("func/ReportAllowance.php?Site="+ site +"&Year="+ year +"&Period="+ period +"&Month="+ month);
    });

    $('#Report8').click(function(event) {
        site = $('#Site').val();
        year = $('#Year').val();
        period = $('#Period').val();
        month = $('#Month').val();

        window.open("func/ReportTax.php?Site="+ site +"&Year="+ year +"&Period="+ period +"&Month="+ month);
    });

    $('#one').click(function(event) {
        $('#ChiosePeriod').css('display', 'none');
        $('#ChioseMonth').css('display', '');
    });
    $('#zero').click(function(event) {
        $('#ChiosePeriod').css('display', '');
        $('#ChioseMonth').css('display', 'none');
    });
</script>

<html>
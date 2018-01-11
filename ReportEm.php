<?php
    @session_start();
    require("inc/connect.php");
    include("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'ReportEm';
    $_SESSION['Link'] = 'ReportEm.php';
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
                <span> รายงานพนักงานเข้า - ออก </span><br><br>
                <div class="btn-group">
                    <div class="btn-group">
                        <button class="btn btn-success" id="Report7">ออกรายงาน Excel</button>
                    </div>
                </div>
            </h1>
            <?php require('ReportEmDetail.php'); ?>
            <input type="hidden" id="choise" />
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
<script type="text/javascript">
    (function($){
        $('.footable').footable();

        $('#data_5 .input-daterange').datepicker({
            dateFormat: 'dd-mm-yy',
            keyboardNavigation: false,
            forceParse: false,
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
    } (jQuery));
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

    $('#Report7').click(function(event) {
        site = $('#Site').val();
        start = $('#start').val();
        end = $('#end').val();
        choise = $('#choise').val();
        position = $('#Position').val();
        group = $('#Group').val();

        start = start.split("-");
        start = start[2]+'-'+start[1]+'-'+start[0];

        end = end.split("-");
        end = end[2]+'-'+end[1]+'-'+end[0];

        window.open("func/ReportEmployeeIO.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Start="+ start +"&End="+ end +"&Choise="+ choise);
    });

    function SelectGroup() {
        travflex.compulsory.Criteria['mode'] = 'load_group_list';
        travflex.compulsory.Criteria['Site'] = $('#Site').val();
        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            GroupList = response;
            setGroup();
        });
    }
    
    function setGroup() {
        result = GroupList;
        div = document.getElementById('Group');
        div.innerHTML = '';
        div.add(new Option('โปรดเลือกชุด', ''));
        for(i in result){
            div.add(new Option(result[i]['LongName'], result[i]['Code']));
        }
    }

    $('#zero').click(function(event) {
        $('#choise').val('W');
    });
    $('#one').click(function(event) {
        $('#choise').val('O');
    });
    $('#two').click(function(event) {
        $('#choise').val('B');
    });
</script>

<html>
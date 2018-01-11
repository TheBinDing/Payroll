<?php
    @session_start();
    require('inc/connect.php');
    require('func/ExpensesSearch.php');
    include("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'Expenses';
    $_SESSION['Link'] = 'Expenses.php';
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
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
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
            <div class="cp-spinner cp-round"></div>
            <?php require("MenuSite.php"); ?>
                <div class="wrapper wrapper-content animated fadeInRight ecommerce">
                    <h1>
                        <span> การเบิกอุปกรณ์หรือค่าใช้จ่ายอื่นๆ </span>
                    </h1>
					<?php require('ExpensesDetail.php'); ?>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/footable/footable.all.min.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/switchery/switchery.js"></script>
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
        // $('#Expen1').click(function() {
        //     $('#group-1').css('display', '')
        //     $('#group-2').css('display', 'none')
        // });
        // $('#Expen2').click(function(){
        //     $('#group-1').css('display', 'none');
        //     $('#group-2').css('display', '');
        // });

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

        $('.footable').footable();

        $('.demo1').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 3000,
                showConfirmButton: false
            },function(){
                window.location='Expenses.php';
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

        $("#checkbox1").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept  
            if($(this).is(":checked")){ // ถ้าเลือก  
                $('#Price1').prop('disabled',false);
            } else {
                $('#Price1').prop('disabled',true);
            }
        });
        $("#checkbox2").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept  
            if($(this).is(":checked")){ // ถ้าเลือก  
                $('#Price2').prop('disabled',false);
            } else {
                $('#Price2').prop('disabled',true);
            }
        });
        $("#checkbox3").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept  
            if($(this).is(":checked")){ // ถ้าเลือก  
                $('#Price3').prop('disabled',false);
            } else {
                $('#Price3').prop('disabled',true);
            }
        });
        $("#checkbox4").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept  
            if($(this).is(":checked")){ // ถ้าเลือก  
                $('#Price4').prop('disabled',false);
            } else {
                $('#Price4').prop('disabled',true);
            }
        });
        $("#checkbox5").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept  
            if($(this).is(":checked")){ // ถ้าเลือก  
                $('#Price5').prop('disabled',false);
            } else {
                $('#Price5').prop('disabled',true);
            }
        });
        $("#checkbox6").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept  
            if($(this).is(":checked")){ // ถ้าเลือก  
                $('#Price6').prop('disabled',false);
            } else {
                $('#Price6').prop('disabled',true);
            }
        });
        $("#checkbox7").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept  
            if($(this).is(":checked")){ // ถ้าเลือก  
                $('#Price7').prop('disabled',false);
            } else {
                $('#Price7').prop('disabled',true);
            }
        });
        $("#checkbox8").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept  
            if($(this).is(":checked")){ // ถ้าเลือก  
                $('#Price8').prop('disabled',false);
                $('#Remark8').css('display', '');
                $('#name1').css('display', '');
            } else {
                $('#Price8').prop('disabled',true);
                $('#Remark8').css('display', 'none');
                $('#name1').css('display', 'none');
            }
        });

        $('#one').click(function(event) {
            window.location='Expenses.php?Status=1';
        });
        $('#zero').click(function(event) {
            window.location='Expenses.php?Status=0';
        });

        if($('#one').is(":checked") == true) {
            $('#button').css('display', 'none');
        } else {
            $('#button').css('display', '');
        }
    } (jQuery));
</script>
<script type="text/javascript">
    function haha() {
        i = $('#Item').val();
        if(i == '8') {
            $('#Remark').css('display', '');
        }
    }
</script>
<script type="text/javascript">
    jQuery(function( $ ) {
        travflex.compulsory.Criteria = {};

        revenue();
        expenditure();

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
    });

    var travflex = {
        compulsory: new Object()
    };

    function revenue() {
        travflex.compulsory.Criteria['mode'] = 'load_revenue_list';
        travflex.compulsory.Criteria['Site'] = $('#Site').val();
        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            $('#revenues').val(response.Price);
        });
    }

    function expenditure() {
        travflex.compulsory.Criteria['mode'] = 'load_expenditure_list';
        travflex.compulsory.Criteria['Site'] = $('#Site').val();
        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            $('#expenditures').val(response.Price);
        });
    }

    function SelectYear() {
        travflex.compulsory.Criteria['mode'] = 'load_year_list';
        travflex.compulsory.Criteria['Year'] = $('#Year').val();
        travflex.compulsory.Criteria['Site'] = $('#Site').val();
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
        div.add(new Option('Period', ''));
        for(i in result){
            div.add(new Option(result[i]['LongName'], result[i]['Code']));
        }
    }

    $('#Report1').click(function(event) {
        var site = $('#Site').val();
        var position = $('#Position').val();
        var group = $('#Group').val();
        var period = $('#Period').val();
        window.open("pdf/PDF02.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
    });
    $('#Report2').click(function(event) {
        var site = $('#Site').val();
        var position = $('#Position').val();
        var group = $('#Group').val();
        var period = $('#Period').val();
        window.open("pdf/PDF01.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
    });
    $('#Report3').click(function(event) {
        var site = $('#Site').val();
        var position = $('#Position').val();
        var group = $('#Group').val();
        var period = $('#Period').val();
        window.open("pdf/PDF04.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
    });
    $('#Report4').click(function(event) {
        var site = $('#Site').val();
        var position = $('#Position').val();
        var group = $('#Group').val();
        var period = $('#Period').val();
        window.open("func/ReportBank.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
    });
    $('#Report5').click(function(event) {
        var site = $('#Site').val();
        var position = $('#Position').val();
        var group = $('#Group').val();
        var period = $('#Period').val();
        window.open("func/ReportBankText.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
    });
    $('#Report6').click(function(event) {
        var site = $('#Site').val();
        var position = $('#Position').val();
        var group = $('#Group').val();
        var period = $('#Period').val();
        window.open("func/ReportSocie.php?Site="+ site +"&Position="+ position +"&Group="+ group +"&Period="+ period);
    });
</script>

<html>
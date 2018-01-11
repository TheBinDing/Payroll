<?php
    @session_start();
    require("inc/connect.php");
    require('func/TimePlanSearch.php');
    require("inc/function.php");
    checklogin($_SESSION[user_name]);
    $HeadCheck = 'TimePlan';
    $_SESSION['Link'] = 'TimePlan.php';
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
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
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
<body onload="test();">
    <div class="row">
        <?php
            require("Head2.php");
        ?>
        <div id="page-wrapper" class="gray-bg">
        <?php require("MenuSite.php"); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <h1>
                <span> ตรวจสอบเวลาทำงาน </span>
                <!-- <input style="margin-left: 1em;display: none;" name="Again" id="Again" value="คำนวณเวลา" class="btn btn-success pull-right"> -->
                <a class="btn btn-success pull-right" role="button" style="margin-left: 1em;display: none;" id="CCAL" data-toggle="modal" data-target="#myModal10">คำนวณเวลา</a>
                <a href="pdf/PDF03.php?Em_ID=<?php echo $names;?>&Period=<?php echo $_SESSION['SubPeriod'];?>&Site=<? echo $_SESSION['SuperSite'];?>&Start=<?php echo $start;?>&End=<?php echo $end;?>" target="_blank" id="RePort" class="btn btn-success pull-right" role="button">รายงาน</a>
            </h1>
            <div class="modal inmodal" id="myModal10" tabindex="-1" role="dialog"    aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content animated flipInY">
                        <div class="modal-header">
                            <h2>ยืนยันข้อมูลถูกต้องครบถ้วน</h2>
                        </div>
                        <div class="modal-body">
                            <p>โปรดตรวจสอบข้อมูลให้ถูกต้อง</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" name="Again" id="Again">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php require('DataTimePlan.php'); ?>      
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
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
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/footable/footable.all.min.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/pace.js"></script>
<script src="js/scrolltopcontrol.js"></script>
<script type="text/javascript">
    (function($){
        $('#data_5 .input-daterange').datepicker({
            dateFormat: 'dd-mm-yy',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

        $('.SubmitData').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังดึงข้อมูล",
                timer: 25000,
                showConfirmButton: false
            });
        });
        
        $('.footable').footable();

        $('#Search').click(function(){
            $('#RePort').css('display', '');
        });

        $('#TimeFix').click(function(){
            $('#data_6').css('display', '');
            $('#data_5').css('display', 'none');
        });

        $('#TimePhase').click(function(){
            $('#data_6').css('display', 'none');
            $('#data_5').css('display', '');
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

        $('#Again').click(function(){
            $('#myModal10').css('display','');
            $('#loading').css('display','block');
            $('#block').css('display','block');
            $('html').css('overflow','hidden');
            // $('body').css('overflow','hidden');
            var period = $('#Period').val();
            var name = $('#name').val();

            window.location=("func/CalcuAgain.php?Name="+ name +"&Period="+ period);
        });

        var Nums = $('#Nums').val();

        if(Nums != '') {
            $('#CCAL').css('display', '');
        }

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

        var oTable = $('#editable').dataTable();

        /* Apply the jEditable handlers to the table */
        oTable.$('td').editable( '../example_ajax.php', {
            "callback": function( sValue, y ) {
                var aPos = oTable.fnGetPosition( this );
                oTable.fnUpdate( sValue, aPos[0], aPos[1] );
            },
            "submitdata": function ( value, settings ) {
                return {
                    "row_id": this.parentNode.getAttribute('id'),
                    "column": oTable.fnGetPosition( this )[2]
                };
            },

            "width": "90%",
            "height": "100%"
        } );

    } (jQuery));

    function test() {
        $('#loading').css('display','none');
        $('#block').css('display','none');
        $('html').css('overflow','auto');
        // $('body').css('overflow','auto');

        var a  = $('#Period').val();
        if(a == '') {
            $('#RePort').css('display', 'none');
        } else {
            $('#RePort').css('display', '');
        }

        var Time = $('#CheckTime').val();
        if(Time == '') {
            $('#data_6').css('display', '');
            $('#data_5').css('display', 'none');
        }else if(Time == 1) {
            $('#data_6').css('display', '');
            $('#data_5').css('display', 'none');
        }else if(Time == 2) {
            $('#data_6').css('display', 'none');
            $('#data_5').css('display', '');
        }
    }

    function Alert() {
        swal("ข้อมูลมีการตัดวีคแล้ว\n\rไม่สามารถแก้ไขได้");
    }
</script>
<style>
    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>
<script>
    paceOptions = {
      elements: true
    };

    function load(time){
      var x = new XMLHttpRequest()
      x.open('GET', "http://localhost:5646/walter/" + time, true);
      x.send();
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

<html>
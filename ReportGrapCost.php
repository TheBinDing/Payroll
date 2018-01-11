<?php
    @session_start();
    require("inc/connect.php");
    include("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'GrapCost';
    $_SESSION['Link'] = 'ReportGrapCost.php';
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
    <link href="css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
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
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                            <?php
                                $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '".$row['Site_ID']."' ";
                                $query_site = mssql_query($sql_site);
                                $num_site = mssql_num_rows($query_site);
                            ?>
                            <label class="radio-inline width-text1"> โครงการ </label>
                            <select class="form-control chosen-select" name="Site" id="Site" required="required" style="height: 30px;" onchange="showGrap()">
                                <!-- <option value=""></option> -->
                                <?php
                                for($i=1;$i<=$num_site;$i++)
                                {
                                    $row_site = mssql_fetch_array($query_site);
                                ?>
                                    <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <?php
                                $dy = new datetime();
                                $dy = $dy->format('Y');

                                $sql_y = "SELECT
                                            MT_Year AS Year
                                        FROM
                                            [HRP].[dbo].[MoneyTotal]
                                        WHERE
                                            Site_ID = '". $_SESSION['SuperSite'] ."'
                                            AND MT_Year != '". $dy ."'
                                        GROUP BY
                                            MT_Year
                                        ORDER BY
                                            MT_Year ";
                                $query_y = mssql_query($sql_y);
                                $num_y = mssql_num_rows($query_y);
                            ?>
                            <label class="radio-inline width-text1">ปี</label>
                            <select class="form-control" name="Year" id="Year" style="height: 30px;" onchange="showGrap()" required>
                            <option value="<?php echo $dy; ?>"><span><?php echo $dy; ?></span></option>
                            <?php
                                for($l=1;$l<=$num_y;$l++) {
                                    $row_y = mssql_fetch_array($query_y);
                            ?>
                                <option value="<?php echo $row_y['Year'];?>"><?php echo $row_y['Year'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3">
                            <?php
                                $sql_m = "SELECT
                                            mo_id as id,
                                            CAST(mo_name as text) as name
                                        FROM
                                            [HRP].[dbo].[Month] ";
                                $query_m = mssql_query($sql_m);
                                $num_m = mssql_num_rows($query_m);
                            ?>
                            <label class="radio-inline width-text1">เดือน</label>
                            <select class="form-control" name="Month" id="Month" style="height: 30px;" onchange="showGrap()">
                            <option value=""><span>-- โปรดเลือกเดือน --</span></option>
                            <?php
                                for($l=1;$l<=$num_m;$l++) {
                                    $row_m = mssql_fetch_array($query_m);
                            ?>
                                <option value="<?php echo $row_m['id'];?>"><?php echo iconv('TIS-620', 'UTF-8', $row_m['name']);?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                </div>
                <div class="ibox-content m-b-sm border-bottom">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="graph1">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>โครงการ : ทั้งหมด</h5>
                                        <div ibox-tools></div>
                                    </div>
                                    <div class="ibox-content">
                                        <div>
                                            <canvas id="barChart" height="140"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="graph2" style="display: none;">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <div class="col-sm-6">
                                            <h5>
                                                โครงการ : <div type="" id="Text"></div>
                                            </h5>
                                        </div>
                                        <div class="col-sm-2">
                                            <h5>
                                                OT1 : <div type="" id="Text2" style="color: #a3e1d4;"></div>
                                            </h5>
                                        </div>
                                        <div class="col-sm-2">
                                            <h5>
                                                OT1.5 : <div type="" id="Text3" style="color: #dedede;"></div>
                                            </h5>
                                        </div>
                                        <div class="col-sm-2">
                                            <h5>
                                                OT2 : <div type="" id="Text4" style="color: #b5b8cf;"></div>
                                            </h5>
                                        </div>

                                        <div ibox-tools></div>
                                    </div>
                                    <div class="ibox-content">
                                        <div>
                                            <canvas id="polarChart" height="140"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/switchery/switchery.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<!-- ChartJS-->
<script src="js/plugins/chartJs/Chart.min.js"></script>
<!-- ///// -->
<script type="text/javascript">
    (function($){
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

    function showGrap() {
        if($('#Site').val() == 1) {
            $('#graph1').css('display', '');
            $('#graph2').css('display', 'none');
        } else {
            $('#graph1').css('display', 'none');
            $('#graph2').css('display', '');
        }
        
        travflex.compulsory.Criteria['mode'] = 'load_grap_list';
        travflex.compulsory.Criteria['site'] = $('#Site').val();
        travflex.compulsory.Criteria['year'] = $('#Year').val();
        travflex.compulsory.Criteria['month'] = $('#Month').val();
        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            ValueList = response;
            if(travflex.compulsory.Criteria['site'] != 1) {
                setValue2();
                // setSite();
            } else {
                setValue();
            }
        });
    }

    function setValue() {
        var result = ValueList;
        var barData = {
            labels: result[0]['One'],
            datasets: [
                {
                    label: "My First dataset",
                    fillColor: "rgba(220,220,220,0.5)",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: result[0]['Two']
                },
                {
                    label: "My Second dataset",
                    fillColor: "rgba(26,179,148,0.5)",
                    strokeColor: "rgba(26,179,148,0.8)",
                    highlightFill: "rgba(26,179,148,0.75)",
                    highlightStroke: "rgba(26,179,148,1)",
                    data: result[0]['Three']
                },
                {
                    label: "My Third dataset",
                    fillColor: "rgba(135,206,235,0.5)",
                    strokeColor: "rgba(135,206,235,0.8)",
                    highlightFill: "rgba(135,206,235,0.75)",
                    highlightStroke: "rgba(135,206,235,1)",
                    data: result[0]['Four']
                }
            ]
        };

        var barOptions = {
            scaleBeginAtZero: true,
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            barShowStroke: true,
            barStrokeWidth: 2,
            barValueSpacing: 5,
            barDatasetSpacing: 1,
            responsive: true,
        }

        var ctx = document.getElementById("barChart").getContext("2d");
        var myNewChart = new Chart(ctx).Bar(barData, barOptions);
    }

    function setValue2() {
        var result = ValueList;

        var polarData = [
            {
                value: result[0]['Two'],
                color: "#a3e1d4",
                highlight: "#1ab394",
                label: "OT 1"
            },
            {
                value: result[0]['Three'],
                color: "#dedede",
                highlight: "#1ab394",
                label: "OT 1.5"
            },
            {
                value: result[0]['Four'],
                color: "#b5b8cf",
                highlight: "#1ab394",
                label: "OT 2"
            }
        ];

        var polarOptions = {
            scaleShowLabelBackdrop: true,
            scaleBackdropColor: "rgba(255,255,255,0.75)",
            scaleBeginAtZero: true,
            scaleBackdropPaddingY: 1,
            scaleBackdropPaddingX: 1,
            scaleShowLine: true,
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false,
            responsive: true,

        };

        var ctx = document.getElementById("polarChart").getContext("2d");
        var myNewChart = new Chart(ctx).PolarArea(polarData, polarOptions);

        document.getElementById("Text").innerHTML = result[0]['One'];
        document.getElementById("Text2").innerHTML = result[0]['Two'];
        document.getElementById("Text3").innerHTML = result[0]['Three'];
        document.getElementById("Text4").innerHTML = result[0]['Four'];
    }

    function setSite() {

    }
</script>

<html>
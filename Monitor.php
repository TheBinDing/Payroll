<?php
    @session_start();
    require("inc/connect.php");
    require("inc/function.php");
    require("func/MonitorSearch.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'Monitor';
    $_SESSION['Link'] = 'Monitor.php';
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
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body>
    <div class="row">
        <?php
            require("Head2.php");
        ?>
        <div id="page-wrapper" class="gray-bg">
            <?php require("MenuSite.php"); ?>
            <div class="row" style="margin-top: 50px;">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="form-group">
                                <?php
                                    $period = "";
                                ?>
                                <label class="" style="width: 85px;">งวดเวลา</label>
                                <select class="form-control-normal" style="width: 250px;height: 30px;margin-left: 20px;" name="Period" id="Period" onblur="check();" readonly>
                                <?php
                                    if($num_per_id == '0') {
                                ?>
                                    <option value=""> โปรดเลือกงวด </option>
                                <?php } else { ?>
                                    <option value="<?php echo $row_Per_id['Per_ID'];?>"><?php echo 'งวดที่ '.$row_Per_id['Per_Week'].' ช่วง '.$row_Per_id['Per_StartDate'].' - '.$row_Per_id['Per_EndDate'];?></option>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<=$num_period;$i++)
                                {
                                    $row_period = mssql_fetch_array($query_period);
                                ?>
                                    <option value="<?php echo $row_period['Per_ID'];?>"><?php echo 'งวดที่ '.$row_period['Per_Week'].' ช่วง '.$row_period['Per_StartDate'].' - '.$row_period['Per_EndDate'];?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <h5>
                                <span>ข้อมูลการทำงาน</span>
                            </h5>
                            <div>
                                <?php
                                    if($getPeriod != '') {
                                ?>
                                <table class="table table-striped table-bordered table-hover " id="editable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">ชื่อ - นามสกุล</th>
                                        <?php
                                            for($t=1;$t<=$num_t;$t++) {
                                                $row_t = mssql_fetch_array($query_t);

                                                $ddmy = new datetime($row_t['DateTimes']);
                                                $ddmy = $ddmy->format('d-m-Y');
                                        ?>
                                            <th style="text-align: center;font-size: 10px;width: 70px;"><?php echo $ddmy; ?></th>
                                        <?php
                                            }
                                        ?>
                                        </tr>
                                    </thead>
                                    <?php
                                        for($p=1;$p<=$num_p;$p++) {
                                            $row_p = mssql_fetch_array($query_p);

                                            $sql = "SELECT
                                                        TB1.m_id,
                                                        TB2_1.Check_day,
                                                        TB2_1.Check_in,
                                                        TB2_1.Check_out
                                                    FROM
                                                        (SELECT
                                                            Check_Name,
                                                            Check_day,
                                                            Check_in,
                                                            Check_out,
                                                            m_id
                                                        FROM
                                                            [HRP].[dbo].[AuditWorkDay]
                                                        GROUP BY
                                                            Check_Name,
                                                            Check_day,
                                                            Check_in,
                                                            Check_out,
                                                            m_id) AS TB2_1
                                                        RIGHT OUTER JOIN
                                                        (SELECT
                                                            U.m_id,
                                                            U.m_name,
                                                            D.Date_,
                                                            D.Day_,
                                                            D.Holiday_
                                                        FROM
                                                            [HRP].[dbo].[Datetable] AS D CROSS JOIN [HRP].[dbo].[Users] AS U
                                                        WHERE
                                                            D.Date_ BETWEEN '". $s ."' AND '". $e ."'
                                                            AND U.m_status = '1'
                                                        GROUP BY
                                                            U.m_id,
                                                            U.m_name,
                                                            D.Date_,
                                                            D.Day_,
                                                            D.Holiday_) AS TB1 ON TB2_1.m_id = TB1.m_id AND TB2_1.Check_day = TB1.Date_
                                                    WHERE
                                                        TB1.m_id = '". $row_p['m_id'] ."'
                                                    /*GROUP BY
                                                        TB1.m_id,
                                                        TB1.m_name,
                                                        TB2_1.Check_day,
                                                        TB2_1.Check_in,
                                                        TB2_1.Check_out*/ ";

                                            $query = mssql_query($sql);
                                            $num = mssql_num_rows($query);
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: left;"><?php echo iconv('TIS-620', 'UTF-8', $row_p['m_name']); ?></td>
                                            <?php
                                                for($l=1;$l<=$num;$l++) {
                                                    $row = mssql_fetch_array($query);

                                                    if($row['Check_in'] != '' && $row['Check_out'] != ''){
                                                        if($row['Check_in'] == '0' && $row['Check_out'] == '0') {
                                                            $color = 'red';
                                                            $bat = '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
                                                        }
                                                        if($row['Check_in'] == '1' || $row['Check_out'] == '0') {
                                                            $color = 'yellow';
                                                            $bat = '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
                                                        }
                                                        if($row['Check_in'] == '1' && $row['Check_out'] == '1') {
                                                            $color = 'green';
                                                            $bat = '<i class="fa fa-star" aria-hidden="true"></i>';
                                                        }
                                                    } else {
                                                        $color = 'gray';
                                                        $bat = '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                                    }
                                            ?>
                                                <td style="text-align: center;">
                                                    <div style="color:<?=$color?>;"><?=$bat?></div>
                                                </td>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                    </tbody>
                                    <?php
                                        }
                                    ?>
                                </table>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/pace.js"></script>
<script type="text/javascript">
    var travflex = {
        compulsory: new Object()
    };

    paceOptions = {
        elements: true
    };

    (function($){
        // var oTable = $('#editable').dataTable();

        travflex.compulsory.Criteria = {};
    } (jQuery));

    function check() {
        vText = $('#Period').val();

        if(vText != '') {
            window.location = ("Monitor.php?Period="+ vText);
        }
    }
</script>
<html>
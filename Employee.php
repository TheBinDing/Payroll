<?php
    @session_start();
    require("inc/connect.php");
    require("inc/function.php");
    require("func/employee.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'Employee';
    $_SESSION['Link'] = 'Employee.php';
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
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
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
        <?php require("MenuSite.php"); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <h1>
                <?php
                    $sql_site = "SELECT Site_ID, CAST(Site_Name as text) as Site_Name FROM [HRP].[dbo].[Sites] where Site_ID = '".$_SESSION['SuperSite']."' ";
                    $q_site = mssql_query($sql_site);
                    $r_site = mssql_fetch_assoc($q_site);

                    $today = date('d-m-Y');
                ?>
                <span> บุคลากร </span><a class="glyphicon glyphicon-plus-sign" href="EmployeeDetail.php"></a>
				<div class="btn-group">
                    <input type="hidden" id="EmployeeIDs" />
					<button class="btn btn-success pull-right" id="Excel" style="margin-left: 55em;">รายชื่อพนักงาน</button>
				</div>
            </h1>
            <div class="ibox-content">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-2" onClick="tab(2);">ทำงาน</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-3" onClick="tab(3);">ออก</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-4" onClick="tab(4);">Blacklist</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-2" class="tab-pane active">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="editableWord">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">#</th>
                                            <th style="text-align: center;">รหัสพนักงาน</th>
                                            <th style="text-align: center;">ชื่อ/นามสกุล</th>
                                            <th style="text-align: center;">โครงการ</th>
                                            <th style="text-align: center;width: 100px;">ตำแหน่ง</th>
                                            <th style="text-align: center;width: 100px;">ชุด/สังกัด</th>
                                            <th style="text-align: center;width: 100px;">ดูข้อมูล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i=1;$i<=$num;$i++)
                                            {
                                                $row = mssql_fetch_array($query);
                                                if($row['Titel'] == 'Mr') {
                                                    $Titel = 'นาย ';
                                                }
                                                if($row['Titel'] == 'Ms') {
                                                    $Titel = 'นางสาว ';
                                                }
                                                if($row['Titel'] == 'Mrs') {
                                                    $Titel = 'นาง ';
                                                }

                                                $_SESSION['ID_View'] = $row['Em_ID'];
                                        ?>
                                        <tr>
                                            <td scope="row" style="text-align: center;"><?php echo $i?></td>
                                            <td style="text-align: center;"><?php echo $row['Em_ID']; ?></td>
                                            <td style="">
                                                <?php echo $Titel.' '.iconv('TIS-620','UTF-8',$row['Fullname']).' '.iconv('TIS-620','UTF-8',$row['Lastname']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row['Site_Name']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row['Pos_Name']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row['Group_Name']); ?></td>
                                            <!-- <td style="text-align: center;">
                                                <a href="EmployeeDetail.php?Em_ID=<?php echo $row['Em_ID']; ?>&page=Edit" class="btn-white btn btn-xs" role="button">ดูข้อมูล</a>
                                            </td> -->
                                            <td style="text-align: center;">
                                                <a data-toggle="modal" data-target="#myModals01" class="open-sendname btn-white btn btn-xs" onclick="CheckNumberEmployee(<?=$row['Em_ID'];?>);" data-id="<?=$row['Em_ID'];?>" >ดูข้อมูล</a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="editableOut">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">#</th>
                                            <th style="text-align: center;">รหัสพนักงาน</th>
                                            <th style="text-align: center;">ชื่อ/นามสกุล</th>
                                            <th style="text-align: center;">โครงการ</th>
                                            <th style="text-align: center;width: 100px;">ตำแหน่ง</th>
                                            <th style="text-align: center;width: 100px;">ชุด/สังกัด</th>
                                            <th style="text-align: center;width: 100px;">ดูข้อมูล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql_s = "SELECT
                                                Em_ID AS Em_ID,
                                                Em_Pic AS Pic,
                                                Em_Titel AS Titel,
                                                Em_Status AS Status,
                                                Socie AS Socie,
                                                CAST(Em_Fullname AS Text) AS Fullname,
                                                CAST(Em_Lastname AS Text) AS Lastname,
                                                CAST(Em_Card AS Text) AS Card,
                                                CAST(Site_Name AS Text) AS Site_Name,
                                                CAST(Group_Name AS Text) AS Group_Name,
                                                CAST(Pos_Name AS Text) AS Pos_Name
                                            FROM
                                                [HRP].[dbo].[Employees] AS E,
                                                [HRP].[dbo].[Sites] AS S,
                                                [HRP].[dbo].[Group] AS G,
                                                [HRP].[dbo].[Position] AS P
                                            WHERE
                                                E.Site_ID = S.Site_ID
                                                AND E.Group_ID = G.Group_ID
                                                AND E.Pos_ID = P.Pos_ID
                                                AND E.Em_Status = 'O' ";
                                            if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
                                                $sql_s .= " AND S.Site_ID = '".$_SESSION['SuperSite']."' ";
                                            }
                                                $sql_s .= " ORDER BY Em_ID DESC ";

                                            $query_s = mssql_query($sql_s);
                                            $num_s = mssql_num_rows($query_s);

                                            for($i_s=1;$i_s<=$num_s;$i_s++)
                                            {
                                                $row_s = mssql_fetch_array($query_s);
                                                if($row_s['Titel'] == 'Mr') {
                                                    $Titel_s = 'นาย ';
                                                }
                                                if($row_s['Titel'] == 'Ms') {
                                                    $Titel_s = 'นางสาว ';
                                                }
                                                if($row_s['Titel'] == 'Mrs') {
                                                    $Titel_s = 'นาง ';
                                                }
                                        ?>
                                        <tr>
                                            <td scope="row" style="text-align: center;"><?php echo $i_s?></td>
                                            <td style="text-align: center;"><?php echo $row_s['Em_ID']; ?></td>
                                            <td style="">
                                                <?php echo $Titel_s.' '.iconv('TIS-620','UTF-8',$row_s['Fullname']).' '.iconv('TIS-620','UTF-8',$row_s['Lastname']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row_s['Site_Name']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row_s['Pos_Name']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row_s['Group_Name']); ?></td>
                                            <td style="text-align: center;">
                                                <a data-toggle="modal" data-target="#myModals01" class="open-sendname btn-white btn btn-xs" onclick="CheckNumberEmployee(<?=$row_s['Em_ID'];?>);" data-id="<?=$row_s['Em_ID'];?>" >ดูข้อมูล</a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="editableBlacklist">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">#</th>
                                            <th style="text-align: center;">รหัสพนักงาน</th>
                                            <th style="text-align: center;">ชื่อ/นามสกุล</th>
                                            <th style="text-align: center;">โครงการ</th>
                                            <th style="text-align: center;width: 100px;">ตำแหน่ง</th>
                                            <th style="text-align: center;width: 100px;">ชุด/สังกัด</th>
                                            <th style="text-align: center;width: 100px;">ดูข้อมูล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql_b = "SELECT
                                                Em_ID AS Em_ID,
                                                Em_Pic AS Pic,
                                                Em_Titel AS Titel,
                                                Em_Status AS Status,
                                                Socie AS Socie,
                                                CAST(Em_Fullname AS Text) AS Fullname,
                                                CAST(Em_Lastname AS Text) AS Lastname,
                                                CAST(Em_Card AS Text) AS Card,
                                                CAST(Site_Name AS Text) AS Site_Name,
                                                CAST(Group_Name AS Text) AS Group_Name,
                                                CAST(Pos_Name AS Text) AS Pos_Name
                                            FROM
                                                [HRP].[dbo].[Employees] AS E,
                                                [HRP].[dbo].[Sites] AS S,
                                                [HRP].[dbo].[Group] AS G,
                                                [HRP].[dbo].[Position] AS P
                                            WHERE
                                                E.Site_ID = S.Site_ID
                                                AND E.Group_ID = G.Group_ID
                                                AND E.Pos_ID = P.Pos_ID
                                                AND E.Em_Status = 'B' ";
                                            if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
                                                $sql_b .= " AND S.Site_ID = '".$_SESSION['SuperSite']."' ";
                                            }
                                                $sql_b .= " ORDER BY Em_ID DESC ";

                                            $query_b = mssql_query($sql_b);
                                            $num_b = mssql_num_rows($query_b);

                                            for($i_b=1;$i_b<=$num_b;$i_b++)
                                            {
                                                $row_b = mssql_fetch_array($query_b);
                                                if($row_b['Titel'] == 'Mr') {
                                                    $Titel_b = 'นาย ';
                                                }
                                                if($row_b['Titel'] == 'Ms') {
                                                    $Titel_b = 'นางสาว ';
                                                }
                                                if($row_b['Titel'] == 'Mrs') {
                                                    $Titel_b = 'นาง ';
                                                }
                                        ?>
                                        <tr>
                                            <td scope="row" style="text-align: center;"><?php echo $i_b?></td>
                                            <td style="text-align: center;"><?php echo $row_b['Em_ID']; ?></td>
                                            <td style="">
                                                <?php echo $Titel_b.' '.iconv('TIS-620','UTF-8',$row_b['Fullname']).' '.iconv('TIS-620','UTF-8',$row_b['Lastname']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row_b['Site_Name']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row_b['Pos_Name']); ?></td>
                                            <td style=""><?php echo iconv('TIS-620','UTF-8',$row_b['Group_Name']); ?></td>
                                            <td style="text-align: center;">
                                                <a data-toggle="modal" data-target="#myModals01" class="open-sendname btn-white btn btn-xs" onclick="CheckNumberEmployee(<?=$row_b['Em_ID'];?>);" data-id="<?=$row_b['Em_ID'];?>" >ดูข้อมูล</a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal inmodal" id="myModals01" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <h2>ข้อมูลพนักงาน</h2>
                            </div>
                            <div class="modal-header">
                                <div class="form-group">
                                    <div class="radio-inline">
                                        <img alt="" src="img/Login.png" id="myImage" data-holder-rendered="true" style="height: 150px; width: 150px; display: block;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <p>ข้อมูลส่วนตัว</p>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Cards"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="IDs"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Name"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="DateBirthDay"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Age"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Address"></p>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="modal-body">
                                <p>สถานะประกันงสังคม</p>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Social"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Hospital"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="InformIn"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="InformOut"></p>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="modal-body">
                                <p>ข้อมูลพนักงาน</p>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="DateOpen"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="DateOpen2"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Site"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Position"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Group"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Personal"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Personal2"></p>
                                    </label>
                                </div>
                                <div class="form-group" id="All01">
                                    <label class="radio-inline width-text2">
                                        <p id="LivingExpenses"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Allowance"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="AllowanceDisaster"></p>
                                    </label>
                                </div>
                                <div class="form-group" id="All02">
                                    <label class="radio-inline width-text2">
                                        <p id="AllowanceSafety"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="SpecialAllowance"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Bank"></p>
                                    </label>
                                </div>
                                <div class="form-group" id="BankD">
                                    <label class="radio-inline width-text2">
                                        <p id="BankDetail"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="BankDetail2"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="BankDetail3"></p>
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="Em_IDs" />
                                <button class="btn btn-success" id="buttons" onclick="swap();">แก้ไขข้อมูล</button>
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
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>
<script src="js/plugins/switchery/switchery.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/pace.js"></script>
<script type="text/javascript">
    (function ( $ ) {
        var oTable1 = $('#editableWord').dataTable();
        var oTable2 = $('#editableOut').dataTable();
        var oTable3 = $('#editableBlacklist').dataTable();

        $('#Excel').click(function(event) {
            var i =  $('#EmployeeIDs').val();
            if(i == 'W' || i == '' || i == ' ') {
                window.open("excel/ExportToExcel.php?Status=W");
            }
            if(i == 'O') {
                window.open("excel/ExportToExcel.php?Status="+ i);
            }
            if(i == 'B') {
                window.open("excel/ExportToExcel.php?Status="+ i);
            }
        });
    } (jQuery));

    paceOptions = {
      elements: true
    };
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

    // $('.open-sendname').click(function(event) {
    //     var idss = $(this).data('id');

    //     CheckNumberEmployee(idss);
    // });

    function tab(va) {
        if(va == 2) {
            $('#EmployeeIDs').val('W');
        }
        if(va == 3) {
            $('#EmployeeIDs').val('O');
        }
        if(va == 4) {
            $('#EmployeeIDs').val('B');
        }
    }

    function CheckNumberEmployee(vars) {
        travflex.compulsory.Criteria['mode'] = 'load_employee_ae';
        travflex.compulsory.Criteria['code'] = vars;
        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            EmList = response;
            setEm(0);
        });
    }

    function setEm(key) {
        result = EmList;

        var permiss = <?php echo $_SESSION['Rule']; ?>;

        $('#Em_IDs').val(result[0]['IDs']);

        if(result[0]['Titel'] == 'Mr') {
            Titel = 'นาย ';
        }
        if(result[0]['Titel'] == 'Ms') {
            Titel = 'นางสาว ';
        }
        if(result[0]['Titel'] == 'Mrs') {
            Titel = 'นาง ';
        }

        if(result[0]['DayCost'] == 'Month') {
            Cost = 'รายเดือน';
        }
        if(result[0]['DayCost'] == 'Day') {
            Cost = 'รายวัน';
        }

        if(result[0]['ChoiceBank'] == 'C') {
            Choice = 'รับเงินสด';
            $('#BankD').css('display', 'none');
        }
        if(result[0]['ChoiceBank'] == 'B') {
            Choice = 'โอนเข้าธนาคาร';
        }
        if(result[0]['Soice'] == 1) {
            social = 'คิด'
        }
        if(result[0]['Soice'] == 0) {
            social = 'ไม่คิด'
        }
        if(result[0]['LivingExpenses'] == 0) {
            $('#LivingExpenses').css('display', 'none');
        }
        if(result[0]['Allowance'] == 0) {
            $('#Allowance').css('display', 'none');
        }
        if(result[0]['AllowanceDisaster'] == 0) {
            $('#AllowanceDisaster').css('display', 'none');
        }
        if(result[0]['AllowanceSafety'] == 0) {
            $('#AllowanceSafety').css('display', 'none');
        }
        if(result[0]['SpecialAllowance'] == 0) {
            $('#SpecialAllowance').css('display', 'none');
        }
        if((result[0]['LivingExpenses'] == 0) && (result[0]['Allowance'] == 0)) {
            $('#All01').css('display', 'none');
        }
        if((result[0]['AllowanceDisaster'] == 0) && (result[0]['AllowanceSafety'] == 0) && (result[0]['SpecialAllowance'] == 0)) {
            $('#All02').css('display', 'none');
        }
        if(result[0]['Status'] == 'B' && permiss == '3') {
            $('#buttons').css('display', 'none');
        } else {
            $('#buttons').css('display', '');
        }

        aDateOpen = result[0]['DateOpen'];
        spTodayA = aDateOpen.split(' ');
        todaya = spTodayA[0] + ' ' + spTodayA[1] + ' ' + spTodayA[2];
        dateTodayA = formatDate(todaya);
        bDateBirthDay = result[0]['DateBirthDay'];
        spTodayB = bDateBirthDay.split(' ');
        todayb = spTodayB[0] + ' ' + spTodayB[1] + ' ' + spTodayB[2];
        dateTodayB = formatDate(todayb);

        tests = Date();
        testsD = tests.split(' ');

        Daied = (testsD[3] - spTodayB[2]);

        dWork = formatDateSeach(todaya);
        var res = dWork.split("-");
        var d = res[0] + '/' + res[1] + '/' + res[2];
        var c = age(new Date(d));
        var c = c.toString();
        var f = c.split("-");

        if(result[0]['Pic'] != '') {
            document.getElementById('myImage').src = 'func/EmployeePicture/' + result[0]['Pic'];
        }
        if(result[0]['Pic'] == '') {
            document.getElementById('myImage').src = 'img/Login.png';
        }
        document.getElementById("Cards").innerHTML = 'เลขบัตรประชาชน : '+result[0]['Cards'];
        document.getElementById("IDs").innerHTML = 'รหัสพนักงาน : '+result[0]['IDs'];
        document.getElementById("Name").innerHTML = 'ชื่อ - นามสกุล : '+Titel+' '+result[0]['Fullname']+' '+result[0]['Lastname'];
        document.getElementById("DateBirthDay").innerHTML = 'วัน/เดือน/ปี เกิด : '+ dateTodayB;
        document.getElementById("Age").innerHTML = 'อายุ : '+ Daied + ' ปี';
        document.getElementById("Address").innerHTML = 'ที่อยู่ : '+result[0]['Address'];
        document.getElementById("DateOpen").innerHTML = 'วันที่เข้าทำงาน : '+dateTodayA;
        document.getElementById("DateOpen2").innerHTML = f[0]+' ปี '+f[1]+' เดือน '+f[2]+' วัน';
        document.getElementById("Site").innerHTML = 'โครงการ : '+result[0]['Site_Name'];
        document.getElementById("Position").innerHTML = 'ตำแหน่ง : '+result[0]['Pos_Name'];
        document.getElementById("Group").innerHTML = 'ชุด/สังกัด : '+result[0]['Group_Name'];
        document.getElementById("Personal").innerHTML = 'พนักงาน : '+ Cost;
        document.getElementById("Personal2").innerHTML = 'ค่าแรง : '+result[0]['Money']+' บาท';
        document.getElementById("LivingExpenses").innerHTML = 'เบี้ยเลี้ยง : '+result[0]['LivingExpenses']+' บาท';
        document.getElementById("Allowance").innerHTML = 'เบี้ยเลี้ยง2 : '+result[0]['Allowance']+' บาท';
        document.getElementById("AllowanceDisaster").innerHTML = 'ค่าเลี้ยงภัย : '+result[0]['AllowanceDisaster']+' บาท';
        document.getElementById("AllowanceSafety").innerHTML = 'เบี้ยเลี้ยงเซตตี้ : '+result[0]['AllowanceSafety']+' บาท';
        document.getElementById("SpecialAllowance").innerHTML = 'เบี้ยเลี้ยงพิเศษ : '+result[0]['SpecialAllowance']+' บาท';
        document.getElementById("Bank").innerHTML = 'การรับเงิน : '+Choice;
        document.getElementById("BankDetail").innerHTML = 'ธนาคาร : '+result[0]['Bank_Name'];
        document.getElementById("BankDetail2").innerHTML = 'สาขา : '+result[0]['BankBranch'];
        document.getElementById("BankDetail3").innerHTML = 'เลขบัญชี : '+result[0]['AccountNumber'];
        document.getElementById("Social").innerHTML = 'ประกันสังคม : '+ social;
        document.getElementById("InformIn").innerHTML = 'แจ้งเข้า : '+result[0]['Inform'];
        document.getElementById("InformOut").innerHTML = 'แจ้งออก : '+result[0]['Notice'];
        document.getElementById("Hospital").innerHTML = 'สถานพยาบาล : '+result[0]['Hos_name'];
    }

    function swap() {
        CodeIDs = $('#Em_IDs').val();

        window.location = "EmployeeDetail.php?Em_ID="+ CodeIDs +"&page=Edit";
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('-');
    }

    function age(dob, today) { 
        var today = today || new Date(), 
            result = { 
              years: 0, 
              months: 0, 
              days: 0, 
              toString: function() { 
                return (this.years ? this.years + '-' : 0 + '-') 
                  + (this.months ? this.months + '-' : 0 + '-') 
                  + (this.days ? this.days : 0);
              }
            };
        result.months = 
          ((today.getFullYear() * 12) + (today.getMonth() + 1))
          - ((dob.getFullYear() * 12) + (dob.getMonth() + 1));
        if (0 > (result.days = today.getDate() - dob.getDate())) {
            var y = today.getFullYear(), m = today.getMonth();
            m = (--m < 0) ? 11 : m;
            result.days += 
              [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m] 
                + (((1 == m) && ((y % 4) == 0) && (((y % 100) > 0) || ((y % 400) == 0))) 
                    ? 1 : 0);
            --result.months;
        }
        result.years = (result.months - (result.months % 12)) / 12;
        result.months = (result.months % 12);
        return result;
    }

    function formatDateSeach(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }
</script>

<html>
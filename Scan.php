<?php
    @session_start();
    include("inc/connect.php");
    include("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'Scan';
    // if($_SESSION['user_name'] == "")
    // {
    //     echo "Please Login!";
    //     exit("<script>alert('Please Login');window.location='login.php';</script>");
    // }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!DOCTYPE html>
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
    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
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
                <span> เครื่องสแกนนิ้วมือ </span><a class="glyphicon glyphicon-plus-sign" href="scanDetail.php"></a>
            </h1>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover " id="editable">
                    <thead>
                        <tr>
                            <th style="text-align: center;">รหัส</th>
                            <th style="text-align: center;">ชื่อเครื่อง</th>
                            <th style="text-align: center;">ยี่ห้อย</th>
                            <th style="text-align: center;">รุ่น</th>
                            <th style="text-align: center;">รายละเอียด</th>
                            <th style="text-align: center;">โครงการ</th>
                            <th style="text-align: center;">สถานะ</th>
                            <th style="text-align: center;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                            
                            $sql = "SELECT F.FingerID AS FingerID, F.FingerCode AS FingerCode, CAST(F.FingerName AS text) AS FingerName, CAST(F.Band AS text) AS Band, CAST(F.Model AS text) AS Model, CAST(F.Discription AS text) AS Discription, T.Status_ID, CAST(T.Status_Name AS Text) AS Status_Name, S.Site_ID AS Site_ID, CAST(S.Site_Name AS Text) AS Site_Name ";
                            $sql .= " FROM [HRP].[dbo].[FingerScanner] F LEFT JOIN [HRP].[dbo].[Sites] S ON F.Site_ID = S.Site_ID LEFT JOIN [HRP].[dbo].[Status] T ON F.Status_ID = T.Status_ID WHERE S.Site_ID = '".$_SESSION['SuperSite']."' ORDER BY FingerCode DESC";
                            $query = mssql_query($sql);
                            $num = mssql_num_rows($query);
                            for($i=1;$i<=$num;$i++)
                            {
                                $row = mssql_fetch_array($query);
                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo iconv('TIS-620','UTF-8',$row['FingerCode']); ?></td>
                            <td style="text-align: center;"><?php echo iconv('TIS-620','UTF-8',$row['FingerName']); ?></td>
                            <td style="text-align: center;"><?php echo iconv('TIS-620','UTF-8',$row['Band']); ?></td>
                            <td style="text-align: center;"><?php echo iconv('TIS-620','UTF-8',$row['Model']); ?></td>
                            <td style="text-align: center;"><?php echo iconv('TIS-620','UTF-8',$row['Discription']); ?></td>
                            <td style="text-align: center;"><?php echo iconv('TIS-620','UTF-8',$row['Site_Name']); ?></td>
                            <td style="text-align: center;"><?php echo iconv('TIS-620','UTF-8',$row['Status_Name']); ?></td>
                            <td style="text-align: center;">
                                <div class="btn-group">
                                    <a href="ScanDetail.php?FingerID=<?php echo $row['FingerID']; ?>" class="btn-white btn btn-xs" role="button">แก้ไข</a>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
                // include("Footer.php");
            ?>
        </div>
        <div class="col-xs-6 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/footable/footable.all.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>
<script type="text/javascript">
    (function($){
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
</script>
<html>

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
    <link href="css/datepicker.css" rel="stylesheet">
    <link href="css/clockpicker.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
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
                <span>เครื่องสแกนนิ้วมือ</span>
            </h1>
            <div class="ibox-content">
                <div class="row">
                    <?php
                        if(isset($_GET['FingerID'])){

                            $str    .= !empty($_GET['FingerID'])?" AND F.FingerID = {$_GET['FingerID']}":"";

                            $sql = "SELECT F.FingerID AS FingerID, F.FingerCode AS FingerCode, CAST(F.FingerName AS text) AS FingerName, CAST(F.Band AS text) AS Band, CAST(F.Model AS text) AS Model, CAST(F.Discription AS text) AS Discription, T.Status_ID, CAST(T.Status_Name AS Text) AS Status_Name, S.Site_ID AS Site_ID, CAST(S.Site_Name AS Text) AS Site_Name, CAST(F.Finger_Pic AS Text) AS Finger_Pic ";
                            $sql .= " FROM [HRP].[dbo].[FingerScanner] F LEFT JOIN [HRP].[dbo].[Sites] S ON F.Site_ID = S.Site_ID LEFT JOIN [HRP].[dbo].[Status] T ON F.Status_ID = T.Status_ID ";
                            $sql .= " WHERE FingerID = '".$_GET['FingerID']."' ";

                            $query = mssql_query($sql);
                            $row = mssql_fetch_array($query);
                        }
                    ?>
                    <form action="func/ScanSave.php" method="POST" enctype="multipart/form-data">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4">
                            <?php if($row['Finger_Pic'] == '') { ?>
                            <a href="#">
                                <img alt="" src="img/New_ImageEm.png" data-holder-rendered="true" alt="100%x180">
                            </a>
                            <?php } else { ?>
                            <a href="#">
                                <img alt="" src="func/FingerPicture/<?php echo $row['Finger_Pic']; ?>" data-holder-rendered="true" alt="100%x180">
                            </a>
                            <?php } ?>
                            <fieldset class="form-group">
                                <label for="exampleInputFile">ภาพประจำตัว</label>
                                <input type="file" name="filUpload"><br>
                                <small class="text-muted"></small>
                            </fieldset>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group required ">
                                <label>รหัส</label>
                                <input type="text" value="<?php echo iconv('TIS-620','UTF-8',$row['FingerCode']);?>" id="FingerCode" name="FingerCode" required="required" class="form-control">
                            </div>

                            <div class="form-group required ">
                                <label>ชื่อเครื่อง</label>
                                <input type="text" value="<?php echo iconv('TIS-620','UTF-8',$row['FingerName']);?>" id="FingerName" name="FingerName" required="required" class="form-control">
                            </div>

                            <div class="form-group required ">
                                <label>ยี่ห้อ</label>
                                <input type="text" value="<?php echo iconv('TIS-620','UTF-8',$row['Band']);?>" id="Band" name="Band" required="required" class="form-control">
                            </div>

                            <div class="form-group required ">
                                <label>รุ่น</label>
                                <input type="text" value="<?php echo iconv('TIS-620','UTF-8',$row['Model']);?>" id="Model" name="Model" required="required" class="form-control">
                            </div>

                            <div class="form-group required ">
                                <label>รายละเอียด</label>
                                <input type="text" value="<?php echo iconv('TIS-620','UTF-8',$row['Discription']);?>" id="Discription" name="Discription" required="required" class="form-control">
                            </div>

                            <div class="form-group required ">
                                <?php
                                    $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '".$row['Site_ID']."' ";
                                    $query_site = mssql_query($sql_site);
                                    $num_site = mssql_num_rows($query_site);
                                ?>
                                <label class="radio-inline width-text1"> โครงการ </label>
                                <select class="input-sm form-control input-s-sm inline" name="Site" id="Site" required="required" style="width: 350px;">
                                    <?php if($row['Site_ID'] == '') { ?>
                                    <option value=""><?php echo '-- โปรดระบุ --'; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $row['Site_ID']; ?>"><?php echo iconv('TIS-620','UTF-8',$row['Site_Name']); ?></option>
                                    <?php } ?>
                                    <?php
                                    for($i=1;$i<=$num_site;$i++)
                                    {
                                        $row_site = mssql_fetch_array($query_site);
                                    ?>
                                        <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group required ">
                                <?php
                                    $sql_status = "SELECT Status_ID, CAST(Status_Name AS Text) AS Status_Name FROM [HRP].[dbo].[Status] WHERE Status_ID != '".$row['Status_ID']."' ";
                                    $query_status = mssql_query($sql_status);
                                    $num_status = mssql_num_rows($query_status);
                                ?>
                                <label class="radio-inline width-text1"> สถานะ </label>
                                <select class="input-sm form-control input-s-sm inline" name="Status" id="Status" required="required" style="width: 350px;">
                                    <?php if($row['Status_ID'] == '') { ?>
                                    <option value=""><?php echo '-- โปรดระบุ --'; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $row['Status_ID']; ?>"><?php echo iconv('TIS-620','UTF-8',$row['Status_Name']); ?></option>
                                    <?php } ?>
                                    <?php
                                    for($s=1;$s<=$num_status;$s++)
                                    {
                                        $row_status = mssql_fetch_array($query_status);
                                    ?>
                                        <option value="<?php echo $row_status['Status_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_status['Status_Name']);?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group required " style="padding:20px 15px;">
                                <input type="hidden" name="FingerID" id="FingerID" value="<?php echo $row['FingerID']; ?>" />
                                <button type="submit" class="btn btn-success">เพิ่มข้อมูล</button>
                                <a href="Scan.php" class="btn btn-danger" role="button">กลับ</a>
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
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
<html>

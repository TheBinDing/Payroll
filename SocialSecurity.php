<?php
    require("inc/connect.php");
    // require('func/DependencySearch.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <link href="css/bselect.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/docs.min.css" rel="stylesheet">
    <link href="css/clockpicker.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body>
    <div class="row">
        <div class="col-xs-12 col-sm-1"></div>
        <div class="col-xs-12 col-sm-10">
            <form action="TimePlan.php" method="get">
                <div class="col-xs-12 col-sm-2"></div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="status">ปี</label>
                        <div class="input-append date " id="Year" data-date="<?=date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
                            <input class="span2" name="Year" type="text" value="" style="text-align: center;height: 30px;" readonly >
                            <span class="add-on" style="height: 30px;"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <label class="control-label">ค่าประกันสังคม (%)</label>
                        <input type="number" value="" name="Security" required="required" class="form-control" style="height: 30px;">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-1">
                    <div class="form-group">
                        <label class="control-label" for="status">&nbsp;</label>
                        <button class="btn-white btn btn-xs"><?php if(isset($Group_ID)){echo 'แก้ไขข้อมูล';}else{echo 'เพิ่มข้อมูล';}?></button>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2"></div>
            </div>
        </form>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bselect.js"></script>
<script src="js/clockpicker.js"></script>
<script type="text/javascript">
    $(function () {
        $('#Year').datepicker();
    });
</script>

<html>


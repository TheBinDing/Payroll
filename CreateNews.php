<?php
    @session_start();
    require("inc/connect.php");
    include("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = '';
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
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
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
                    <span> Create News </span>
                </h1>
            </div>
            <?php
                $sql = "SELECT
                            CAST(N_Subject as Text) AS Subjects,
                            CAST(N_Description as Text) AS Description
                        FROM
                            [HRP].[dbo].[News]";
                $query = mssql_query($sql);
                $row = mssql_fetch_array($query)
            ?>
            <div class="row">
                <!-- <form action="CreateNewsSave.php" method="POST" id="postForm"> -->
                    <div class="col-lg-12 animated fadeInRight">
                        <div class="mail-box-header">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Subject:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="Subject" id="Subject" value="<?php echo iconv('TIS-620','UTF-8',$row['Subjects']); ?>"></div>
                                </div>
                        </div>
                        <div class="mail-box">
                            <div class="mail-text h-200">
                                <?php
                                    if($row['Description'] == '') {
                                ?>
                                <textarea class="summernote" style="width: 83em;height: 16em;" name="Detail" id="Detail" maxlength="200" cols="45" rows="5" value=""></textarea>
                                <?php } else {
                                    echo iconv('TIS-620','UTF-8',$row['Description']);
                                    } ?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="mail-body text-right tooltip-demo">
                                <button type="submit" class="btn btn-success demo1" id="Submit">Submit</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <!-- </form> -->
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="js/plugins/summernote/summernote.min.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });


        $('.summernote').summernote();

    });
    var edit = function() {
        $('.click2edit').summernote({focus: true});
    };
    var save = function() {
        var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
        $('.click2edit').destroy();
    };
</script>
<script type="text/javascript">
    jQuery(function( $ ) {
        travflex.compulsory.Criteria = {};

        var elem = document.querySelector('.js-switch');
    });

    var travflex = {
        compulsory: new Object()
    };

    $("#Submit").on('click', function(){
        travflex.compulsory.Criteria['mode'] = 'insert_subject';
        travflex.compulsory.Criteria['Detail'] = $("#Detail").code();
        travflex.compulsory.Criteria['Subject'] = $("#Subject").val();
        var ajax_config = {
            url: "func/loadTest.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            console.log(response);
        });
    });
</script>

<html>


<?php
    require("inc/connect.php");
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
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body onload="display();">
    <div class="row">
        <?php
            require("Head2.php");
        ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="animated fadeInRight ecommerce">
                <div class="middle-box">
                    <div class="ibox-content">
                        <div>
                            <form class="m-t" role="form" action="RegisterSave.php" method="POST" novalidate>
                                <div class="form-group">
                                    <label class="control-label" required>ชื่อผู้ใช้งาน</label>
                                    <input type="text" id="username" name="username" required="required" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" required>รหัสผ่าน</label>
                                    <input type="password" id="password" name="password" maxlength="20" required="required" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" required>ยืนยันรหัสผ่าน</label>
                                    <input type="password" id="confirm" name="confirm" required="required" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" required>ชื่อ</label>
                                    <input type="text" id="name" name="name" required="required" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" required>อีเมล์</label>
                                    <input type="email" id="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">สิทธิการเข้าถึง</label>
                                    <div class="form-group">
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" name="choise" name="choise" id="Admin" value="Admin" checked>
                                            <label for="inlineRadio1"> Admin </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" name="choise" name="choise" id="HR" value="HR" >
                                            <label for="inlineRadio1"> HR </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" name="choise" name="choise" id="Personal" value="Personal" >
                                            <label for="inlineRadio1"> Personal </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" name="choise" name="choise" id="Report" value="Report" >
                                            <label for="inlineRadio1"> Report </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="test">
                                    <label data-placeholder="โปรดใช้ชื่อที่ต้องการ" class="control-label" style="width: 100px;"> โครงการ </label>
                                    <?php
                                        $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '1' ";
                                        $query_site = mssql_query($sql_site);
                                        $num_site = mssql_num_rows($query_site);
                                    ?>
                                    <select data-placeholder=" โปรดเลือกโครงการ " class="chosen-select" name="Site[]" id="Site" multiple required="required" style="width: 300px;height: 30px;" tabindex="4">
                                        <?php
                                        for($i=1;$i<=$num_site;$i++)
                                        {
                                            $row_site = mssql_fetch_array($query_site);
                                        ?>
                                            <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group" style="text-align: center;">
                                    <button type="submit" class="btn btn-success">ตกลง</button>
                                    <a href="User.php" class="btn btn-danger" role="button">ย้อนกลับ</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
    (function ( $ ) {
        $('#Admin').click(function(event) {
            $('#test').css('display', 'none');
        });
        $('#HR').click(function(event) {
            $('#test').css('display', 'none');
        });
        $('#Personal').click(function(event) {
            $('#test').css('display', '');
        });
        $('#Report').click(function(event) {
            $('#test').css('display', 'none');
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

    function display() {
        $('#test').css('display', 'none');
    }
</script>

<html>
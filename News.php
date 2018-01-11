<?php
    @session_start();
    require("inc/connect.php");
    require("inc/function.php");
    require("func/NewsSearch.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'index';
    $_SESSION['Link'] = 'News.php';
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
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <h5>
                                <span>ข่าวประชาสัมพันธ์</span>
                                <?php
                                    if($_SESSION['Rule'] == '2') {
                                ?>
                                <a data-toggle="modal" data-target="#myModal2" class="open-sendnames glyphicon glyphicon-plus-sign" ></a>
                                <?php } ?>
                            </h5>
                            <div>
                                <?php
                                    if($_SESSION['Rule'] == '2') {
                                ?>
                                <div class="pull-right">
                                    <i class="fa fa-lightbulb-o"></i>
                                    <span style="color: red;">ขนาดไฟล์ไม่เกิน 5 MB</span>
                                </div>
                                <?php } else { ?>
                                <div class="pull-right">
                                    <i class="fa fa-lightbulb-o"></i>
                                    <span style="color: red;">ดับเบิ้ลคลิ๊กเพื่อดูข้อมูล</span>
                                </div>
                                <?php } ?>
                                <table class="table table-striped table-bordered table-hover " id="editable">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">ลำดับ</th>
                                            <th style="width: 44%;">หัวข้อ</th>
                                            <th style="width: 15%;">วันที่เพิ่ม</th>
                                            <th style="width: 15%;">นำเสนอโดย</th>
                                            <th style="width: 7%;"><i class="fa fa-download" aria-hidden="true"></i></th>
                                            <?php
                                                if($_SESSION['Rule'] == '2') {
                                            ?>
                                            <th style="width: 7%;"><i class="fa fa-pencil-square-o"></i></th>
                                            <th style="width: 7%;"><i class="fa fa-trash-o"></i></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i_n=1;$i_n<=$numN;$i_n++) {
                                                $rowN = mssql_fetch_array($queryN);

                                                $n_ids = $rowN['n_id'];
                                                $name = iconv('TIS-620','UTF-8', $rowN['name']);
                                                $file = iconv('TIS-620','UTF-8', $rowN['files']);
                                                $sort = iconv('TIS-620','UTF-8', $rowN['sort']);
                                                $present = iconv('TIS-620','UTF-8', $rowN['present']);
                                                $creates = iconv('TIS-620','UTF-8', $rowN['creates']);

                                                $ff = explode('.', $file);

                                                if($ff[1] == 'pdf') {
                                                    $fileI = 'img/pdf.png';
                                                }
                                                if($ff[1] == 'xlsx') {
                                                    $fileI = 'img/excel.png';
                                                }
                                                if($ff[1] == 'docx') {
                                                    $fileI = 'img/word.png';
                                                }
                                                if($ff[1] == 'jpg') {
                                                    $fileI = 'img/jpg.png';
                                                }
                                                if($ff[1] == 'png') {
                                                    $fileI = 'img/png.png';
                                                }
                                        ?>
                                        <tr ondblclick="LoadFile('<?php echo $file; ?>')">
                                            <td style="text-align: center;"><?php echo $i_n; ?></td>
                                            <td><?php echo $name ?></td>
                                            <td style="text-align: center;"><?php echo $creates; ?></td>
                                            <td style="text-align: center;"><?php echo $present; ?></td>
                                            <td style="text-align: center;">
                                                <a target ="_blank" href="File/News/<?php echo $file; ?>">
                                                    <img src="<?php echo $fileI; ?>" alt="" width="25" height="25" />
                                                </a>
                                            </td>
                                            <?php
                                                if($_SESSION['Rule'] == '2') {
                                            ?>
                                            <td style="text-align: center;">
                                                <a class="edits" data-toggle="modal" data-target="#myModal3" data-code="<? echo $n_ids; ?>">
                                                <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </td>
                                            <td style="text-align: center;">
                                                <a class="deletes" data-toggle="modal" data-target="#myModal5" data-code="<? echo $n_ids; ?>">
                                                <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="m-t-xs">
                                <small class="pull-right">
                                    <i class="fa fa-clock-o"> </i>
                                    <?php
                                        $upN = "SELECT CAST(n_update as Text) as updates FROM [HRP].[dbo].[News] GROUP BY n_update";
                                        $queryUp = mssql_query($upN);
                                        $rowUp = mssql_fetch_assoc($queryUp);
                                    ?>
                                    อัพเดทล่าสุด <?php echo iconv('TIS-620','UTF-8', $rowUp['updates']); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php require("ListPersonal.php"); ?>
                </div>
            </div>
        </div>
        <div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <h2>เพิ่มข่าวประชาสัมพันธ์</h2>
                    </div>
                    <form name="frmMain" method="post" enctype="multipart/form-data" action="func/NewsSave.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label">หัวข้อ</label>
                                <input type="text" value="" id="name" name="name" required="required" class="form-control" style="height: 30px;">
                            </div>
                            <div class="form-group">
                                <fieldset class="form-group">
                                    <label for="exampleInputFile">File Upload</label>
                                    <input type="file" name="filUpload"><br>
                                    <small class="text-muted"></small>
                                </fieldset>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success SubmitData">เพิ่ม</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal inmodal" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <h2>แก้ไขข่าวประชาสัมพันธ์</h2>
                    </div>
                    <form name="frmMain" method="post" enctype="multipart/form-data" action="func/NewsSave.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label">หัวข้อ</label>
                                <input type="text" value="" id="names" name="name" required="required" class="form-control" style="height: 30px;">
                            </div>
                            <div class="form-group">
                                <label class="control-label">file</label>
                                <input type="text" value="" id="files" name="fileD" required="required" class="form-control" style="height: 30px;">
                            </div>
                            <div class="form-group">
                                <img id="myImg" src="" alt="" width="150" height="150">
                                <fieldset class="form-group">
                                    <label for="exampleInputFile">File Upload</label>
                                    <input type="file" name="filUpload"><br>
                                    <small class="text-muted"></small>
                                </fieldset>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="n_ids" name="n_id" />
                            <button class="btn btn-success SubmitData">แก้ไข</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"    aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <h2><p><center>โปรดยืนยันการลบข้อมูล</center></p></h2>
                        <input type="hidden" id="KAKA" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" name="trash" id="trash">ลบ</button>
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
        var oTable = $('#editable').dataTable();

        travflex.compulsory.Criteria = {};

        $('.edits').click(function(event) {
            travflex.compulsory.Criteria['mode'] = 'load_news_list';
            travflex.compulsory.Criteria['code'] = $(this).data('code');
            var ajax_config = {
                url: "func/AjaxSearch.php",
                dataType: "json",
                type: "POST",
                data: travflex.compulsory.Criteria,
            };

            var get_ajax = $.ajax(ajax_config);
            get_ajax.done(function(response) {
                NewsList = response;
                setNews();
            });
        });

        function setNews() {
            result = NewsList;

            ff = result['files'];
            file = ff.split('.');

            if(file[1] == 'pdf') {
                fileI = 'img/pdf.png';
            }
            if(file[1] == 'xlsx') {
                fileI = 'img/excel.png';
            }
            if(file[1] == 'docx') {
                fileI = 'img/word.png';
            }

            $('#n_ids').val(result['code']);
            $('#names').val(result['name']);
            $('#files').val(result['files']);
            document.getElementById("myImg").src = fileI;
        }

        $('.deletes').click(function(event) {
            // alert('test');
            $('#KAKA').val($(this).data('code'));
        });

        $('#trash').click(function(event) {
            travflex.compulsory.Criteria['mode'] = 'delete_news_list';
            travflex.compulsory.Criteria['code'] = $('#KAKA').val();
            var ajax_config = {
                url: "func/AjaxSearch.php",
                dataType: "json",
                type: "POST",
                data: travflex.compulsory.Criteria,
            };

            var get_ajax = $.ajax(ajax_config);
            get_ajax.done(function(response) {
                location.reload();
            });
        });
    } (jQuery));

    function LoadFile(data) {
        window.open("File/News/"+data);
    }
</script>
<html>
<div class="ibox-content">
    <table class="table table-striped table-bordered table-hover " id="editable">
        <thead>
            <tr>
                <th style="text-align: center;">ลำดับ</th>
                <th style="text-align: center;">รหัสโครงการ</th>
                <th style="text-align: center;">ชื่อโครงการ</th>
                <th style="text-align: center;">สถานะโครงการ</th>
                <th style="text-align: center;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i=1;$i<=$num_search;$i++) {
                    $row_search = mssql_fetch_array($query_search);

                    $ID = iconv('TIS-620','UTF-8',$row_search['Site_ID']);
                    $Code = iconv('TIS-620','UTF-8',$row_search['Site_Code']);
                    $name = iconv('TIS-620','UTF-8',$row_search['Site_Name']);
                    $status = iconv('TIS-620','UTF-8',$row_search['Site_Status']);
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i; ?></td>
                <td><?php echo $Code; ?></td>
                <td><?php echo $name; ?></td>
                <td style="text-align: center;">
                    <?php if($status == 1) { ?><i class="fa fa-circle text-navy"></i><?php } else { ?><i class="fa fa-circle text-danger"></i><?php } ?>
                </td>
                <td style="text-align: center;">
                    <div class="btn-group">
                        <a data-toggle="modal" data-target="#myModals" class="open-sendname btn-white btn btn-xs" role="button" data-id="<?=$name;?>" data-code="<?=$Code;?>" data-a="<?=$status;?>" data-b="<?=$ID;?>">แก้ไข</a>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal inmodal" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <h2>เพิ่มโครงการ</h2>
                </div>
                <!-- <form name="frmMain" method="post" action="func/StructureSave.php"> -->
                <form name="frmMain" method="post" action="func/StructureSave.php" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">รหัสโครงการ</label>
                            <input type="text" value="" id="Site_Code" name="Site_Code" required="required" class="form-control" style="height: 30px;">
                        </div>
                        <div class="form-group">
                            <label class="control-label">ชื่อโครงการ</label>
                            <input type="text" value="" id="Site_Name" name="Site_Name" required="required" class="form-control" style="height: 30px;">
                        </div>
                        <div class="form-group" id="data_2">
                            <label class="control-label">วันที่เปิดโครงการ</label>
                            <div class="input-group date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" style="padding-left: 20px;" id="data_2">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="DateOpen" id="DateOpen" class="form-control" value="<?php echo date('d-m-Y'); ?>" style="width: 100px;height: 30px;" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="Site_ID" id="Site_ID" value="" />
                        <button class="btn btn-success SubmitData">เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="myModals" tabindex="-1" role="dialog"    aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <h2>แก้ไขโครงการ</h2>
                </div>
                <!-- <form name="frmMain" method="post" action="func/StructureSave.php"> -->
                <form name="frmMain" method="post" action="func/StructureSave.php" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">รหัสโครงการ</label>
                            <input type="text" value="" id="Site_Codes" name="Site_Code" required="required" class="form-control" style="height: 30px;">
                        </div>
                        <div class="form-group">
                            <label class="control-label">ชื่อโครงการ</label>
                            <input type="text" value="" id="Site_Names" name="Site_Name" required="required" class="form-control" style="height: 30px;">
                        </div>
                        <div class="form-group">
                            <label class="control-label">สถานะโครงการ</label>
                        </div>
                        <div class="form-group">
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Site_Status" id="Status11" value="1" >
                                <label for="inlineRadio1"> เปิดโครงการ </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Site_Status" id="Status12" value="0" >
                                <label for="inlineRadio1"> ปิดโครงการ </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="Site_ID" id="Site_IDs" value="" />
                        <button class="btn btn-success SubmitData">แก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
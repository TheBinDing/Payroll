<div class="ibox-content">
    <table class="table table-striped table-bordered table-hover " id="editable">
        <thead>
            <tr>
                <th style="text-align: center;">ลำดับ</th>
                <th style="text-align: center;">ตำแหน่ง</th>
                <th style="text-align: center;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i=1;$i<=$num_search;$i++) {
                    $row_search = mssql_fetch_array($query_search);

                    $ID = iconv('TIS-620','UTF-8',$row_search['Pos_ID']);
                    $name = iconv('TIS-620','UTF-8',$row_search['Pos_Name']);
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i; ?></td>
                <td style="width: 500px;"><?php echo $name; ?></td>
                <td style="text-align: center;">
                    <div class="btn-group">
                        <a data-toggle="modal" data-target="#myModals" class="open-sendname btn-white btn btn-xs" role="button" data-id="<?=$name;?>" data-b="<?=$ID;?>">แก้ไข</a>
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
                    <h2>เพิ่มตำแหน่ง</h2>
                </div>
                <!-- <form name="frmMain" method="post" action="func/PositionSave.php"> -->
                <form name="frmMain" method="post" action="func/PositionSave.php" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">ตำแหน่ง</label>
                            <input type="text" value="<?php echo $Pos_Name; ?>" id="Pos_Name" name="Pos_Name" required="required" class="form-control" style="height: 30px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ID" value="0" />
                        <button class="btn btn-success SubmitData">เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="myModals" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <h2>แก้ไขตำแหน่ง</h2>
                </div>
                <!-- <form name="frmMain" method="post" action="func/PositionSave.php"> -->
                <form name="frmMain" method="post" action="func/PositionSave.php" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">ตำแหน่ง</label>
                            <input type="text" value="" id="Pos_Names" name="Pos_Name" required="required" class="form-control" style="height: 30px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ID" value="1" />
                        <input type="hidden" name="Pos_ID" id="Pos_IDs" value="<?php echo $Pos_ID; ?>" />
                        <button class="btn btn-success SubmitData">แก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
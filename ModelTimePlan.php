<div id="modal-form" class="modal inmodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php require('func/DataSearch.php'); ?>
                        <form name="frmMain" method="post" action="func/DataSave.php" target="iframe_target">
                        <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                            <div class="bs-callout">
                                <div class="form-group">
                                    <label class="radio-inline" style="height: 30px;width: 120px;"> ช่วงเลา </label>
                                    <input class="span2" name="date" id="date" type="text" value="<?php echo $date;?>" style="text-align: center;height: 30px;" readonly >
                                    <right>
                                        <input type="hidden" name="Em_ID" id="Em_ID" value="<?php echo $Em_ID; ?>" />
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs SubmitData" type="submit"><strong>บันทึก</strong></button>
                                    </right>
                                </div>
                                <div class="form-group">
                                    <div class="input-append date" id="CK_in" data-autoclose="true">
                                        <label class="radio-inline" style="height: 30px;width: 120px;"> เข้างานเช้า </label>
                                        <input class="span2" name="CK_in" id="CK_in" type="text" value="<?php echo $CK_in;?>" style="text-align: center;height: 30px;" readonly >
                                    </div>
                                    <div class="input-append date" id="Ck_Out1" data-autoclose="true">
                                        <label class="radio-inline" style="height: 30px;width: 120px;"> ออกงานเช้า </label>
                                        <input class="span2" name="Ck_Out1" id="Ck_Out1" type="text" value="<?php echo $Ck_Out1;?>" style="text-align: center;height: 30px;" readonly >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-append date" id="CK_in2" data-autoclose="true">
                                        <label class="radio-inline" style="height: 30px;width: 120px;"> เข้างานบ่าย </label>
                                        <input class="span2" name="CK_in2" id="CK_in2" type="text" value="<?php echo $CK_in2;?>" style="text-align: center;height: 30px;" readonly >
                                    </div>
                                    <div class="input-append date" id="Ck_Out2" data-autoclose="true">
                                        <label class="radio-inline" style="height: 30px;width: 120px;"> ออกงานบ่าย </label>
                                        <input class="span2" name="Ck_Out2" id="Ck_Out2" type="text" value="<?php echo $Ck_Out2;?>" style="text-align: center;height: 30px;" readonly >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox-content m-b-sm border-bottom">
    <div class="row">
        <div class="col-xs-12 col-sm-2"></div>
        <div class="col-xs-12 col-sm-8">
            <form name="form1" method="post" action="func/PlanSave.php">
                <div class="bs-callout">
                    <div class="form-group" id="data_5" style="width: 270px;">
                        <label class="radio-inline">ช่วงเวลาแผนเวลา</label>
                        <div class="input-daterange input-group" data-date="<?=date('d-m-Y');?>" data-date-format="dd-mm-yyyy" style="padding-left: 20px;">
                            <input type="text" class="input-sm form-control" name="start" value="<?php if($Start != ''){ echo $Start; }else{ echo date('d-m-Y'); } ?>"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="end" value="<?php if($End != ''){ echo $End; }else{ echo date('d-m-Y'); } ?>" />
                        </div>
                    </div>

                    <?php if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') { ?>
                        <div class="form-group">
                            <?php
                                $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
                                $query_site = mssql_query($sql_site);
                                $row_site = mssql_fetch_array($query_site);
                            ?>
                            <label class="radio-inline width-text1">โครงการ</label>
                            <select class="form-control-normal" name="Site_ID" id="Site_ID" style="width: 240px;height: 30px;" required="required">
                                <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                            </select>

                            <label class="radio-inline" style="width: 10%;"> สถานะ </label>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Status" value="1"
								<?php
									if($row_edit['Status'] == '1') echo 'checked';
									if($row_edit['Status'] == '') echo 'checked';
								?> >
                                <label for="inlineRadio1"> เปิด </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Status" value="0" <?php if(iconv('TIS-620', 'UTF-8', $row_edit['Status']) == '2') echo 'checked';?> >
                                <label for="inlineRadio1"> ปิด </label>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group">
                            <?php
                                $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '". $site ."' ";
                                $query_site = mssql_query($sql_site);
                                $num_site = mssql_num_rows($query_site);
                            ?>
                            <label class="radio-inline width-text1">โครงการ</label>
                            <select class="form-control-normal" name="Site_ID" id="Site_ID" style="width: 240px;height: 30px;" required="required">
                                <?php if($site != '') { ?>
                                    <option value="<?php echo $r_s['Site_ID']; ?>"><?php echo iconv('TIS-620','UTF-8',$r_s['Site_Name']); ?></option>
                                <?php } ?>
                                <?php
                                for($i=1;$i<=$num_site;$i++)
                                {
                                    $row_site = mssql_fetch_array($query_site);
                                ?>
                                    <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                                <?php } ?>
                            </select>

                            <label class="radio-inline" style="width: 10%;"> สถานะ </label>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Status" value="1"
								<?php
									if($row_edit['Status'] == '1') echo 'checked';
									if($row_edit['Status'] == '') echo 'checked';
								?> >
								<label for="inlineRadio1"> เปิด </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Status" value="0" <?php if(iconv('TIS-620', 'UTF-8', $row_edit['Status']) == '0') echo 'checked';?> >
                                <label for="inlineRadio1"> ปิด </label>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label class="radio-inline width-text1" style="width: 115px;">ชื่อช่วงทำงาน</label>
                        <input type="text" style="width: 30%;height: 30px;text-align: center;" id="Name" name="Name" value="<?php echo iconv('TIS-620', 'UTF-8', $row_edit['Name']);?>" class="form-control-small" style="height: 30px;">

                        <label class="radio-inline width-text2">เวลาทำงานปกติ</label>
                        <input type="number" style="width: 7%;height: 30px;text-align: center;" id="Hour" name="Hour" value="<?php if($row_edit['Hour'] != ''){echo $row_edit['Hour'];}else echo '9'; ?>" class="form-control-small" style="height: 30px;">

                        <label class="radio-inline width-text2">สามารถมาสายได้</label>
                        <input type="number" style="width: 7%;height: 30px;text-align: center;" id="Late" name="Late" value="<?php if($row_edit['Late']){echo $row_edit['Late'];}else echo '15'; ?>" class="form-control-small" style="height: 30px;">
                    </div>

                    <div class="form-group">
                        <div class="radio-inline width-text2">
                            <label class="radio-inline" style="height: 20px;width: 120px;"><span>เข้างานเช้า</span></label>
                            <input class="form-control-normal" name="CK_in" id="CK_in" type="text" value="<?php echo $CK_in;?>" data-mask="99:99" style="text-align: center;height: 30px;" onblur="calcu();">
                        </div>

                        <div class="radio-inline width-text2">
                            <label class="radio-inline" style="height: 20px;width: 120px;"><span>ออกงานเช้า</span></label>
                            <input class="form-control-normal" name="Ck_Out1" id="Ck_Out1" type="text" value="<?php echo $Ck_Out1;?>" data-mask="99:99" style="text-align: center;height: 30px;background-color: #ddd;" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radio-inline width-text2">
                            <label class="radio-inline" style="height: 20px;width: 120px;"><span>เข้างานบ่าย</span></label>
                            <input class="form-control-normal" name="CK_in2" id="CK_in2" type="text" value="<?php echo $CK_in2;?>" data-mask="99:99" style="text-align: center;height: 30px;background-color: #ddd;" readonly>
                        </div>

                        <div class="radio-inline width-text2">
                            <label class="radio-inline" style="height: 20px;width: 120px;"><span>ออกงานบ่าย</span></label>
                            <input class="form-control-normal" name="Ck_Out2" id="Ck_Out2" type="text" value="<?php echo $Ck_Out2;?>" data-mask="99:99" style="text-align: center;height: 30px;background-color: #ddd;" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radio-inline width-text2">
                            <label class="radio-inline" style="height: 20px;width: 120px;"><span>เข้าOT1.5</span></label>
                            <input class="form-control-normal" name="CKOT_in1" id="CKOT_in1" type="text" value="<?php echo $CKOT_in1;?>" data-mask="99:99" style="text-align: center;height: 30px;">
                        </div>

                        <div class="radio-inline width-text2">
                            <label class="radio-inline" style="height: 20px;width: 120px;"><span>ออกOT1.5</span></label>
                            <input class="form-control-normal" name="CKOT_Out1" id="CKOT_Out1" type="text" value="<?php echo $CKOT_Out1;?>" data-mask="99:99" style="text-align: center;height: 30px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radio-inline width-text2">
                            <label class="radio-inline" style="height: 20px;width: 120px;"><span>เข้าOT2</span></label>
                            <input class="form-control-normal" name="CKOT_in2" id="CKOT_in2" type="text" value="<?php echo $CKOT_in2;?>" data-mask="99:99" style="text-align: center;height: 30px;" >
                        </div>

                        <div class="radio-inline width-text2">
                            <label class="radio-inline" style="height: 20px;width: 120px;"><span>ออกOT2</span></label>
                            <input class="form-control-normal" name="CKOT_Out2" id="CKOT_Out2" type="text" value="<?php echo $CKOT_Out2;?>" data-mask="99:99" style="text-align: center;height: 30px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <center>
                            <input type="hidden" name="TimePlan_ID" value="<?php echo $row_edit['ID']; ?>" />
                            <button class="btn btn-success demo1"><?php if(isset($TimePlan_ID)){echo 'แก้ไขข้อมูล';}else{echo 'เพิ่มข้อมูล';}?></button>
                            <a href="Plan.php" class="btn btn-danger" role="button">กลับ</a>
                        </center>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-12 col-sm-2"></div>
    </div>
</div>
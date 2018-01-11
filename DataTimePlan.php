<div class="ibox-content m-b-sm border-bottom">
    <div class="row">
        <form action="TimePlan.php" method="post">
            <div class="col-sm-5">
                <?php if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') { ?>
                    <div class="form-group">
                        <?php
                            $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
                            $query_site = mssql_query($sql_site);
                            $row_site = mssql_fetch_array($query_site);
                        ?>
                        <label class="radio-inline width-text1" style="display: none;">โครงการ</label>
                        <select class="form-control-normal" name="Site_ID" id="Site_ID" style="display: none;width: 300px;height: 30px;" required="required">
                            <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                        </select>
                    </div>
                <?php } else { ?>
                    <div class="form-group">
                        <?php
                            $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '". $site ."' ";
                            $query_site = mssql_query($sql_site);
                            $num_site = mssql_num_rows($query_site);
                        ?>
                        <label class="radio-inline width-text1" style="display: none;">โครงการ</label>
                        <select class="form-control-normal" name="Site_ID" id="Site_ID" style="width: 300px;height: 30px;display: none;" required="required">
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
                    </div>
                <?php } ?>
                    <div class="form-group">
                        <div class="input-group">
                        <?php
                            $wheren = ($_SESSION['SuperSite'] != '1')?  " WHERE S.Site_ID = '".$_SESSION['SuperSite']."' " : " WHERE S.Site_ID != '' ";
                            $wheren .= !empty($names)?  " AND (Em_ID != '". $names ."') " : "";

                            $s = "SELECT E.Em_ID, CAST(E.Em_Fullname AS Text) AS Fullname, CAST(E.Em_Lastname AS Text) AS Lastname ";
                            $s .= " FROM [HRP].[dbo].[Employees] E LEFT JOIN [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID ";
                            $s .= " $wheren AND Em_Status = 'W' ORDER BY Em_Fullname";

                            $q = mssql_query($s);
                            $n = mssql_num_rows($q);
                        ?>
                        <label class="radio-inline width-text1">พนักงาน</label>
                        <select class="form-control-normal chosen-select" name="name" id="name" style="width: 300px;height: 30px;">
                            <?php if($names != '') { ?>
                                <option value="<?php echo $r_n['Em_ID']; ?>">
                                    <?php echo iconv('TIS-620','UTF-8',$r_n['Fullname']).' '.iconv('TIS-620','UTF-8',$r_n['Lastname']); ?>
                                </option>
                                <option value=""><?php echo 'ทั้งหมด'; ?></option>
                            <?php }else{ ?>
                                <option value=""><?php echo 'ทั้งหมด'; ?></option>
                            <?php } ?>
                            <?php
                            for($j=1;$j<=$n;$j++)
                            {
                                $r = mssql_fetch_array($q);
                            ?>
                                <option value="<?php echo $r['Em_ID'];?>">
                                    <?php echo iconv('TIS-620','UTF-8',$r['Fullname']).' '.iconv('TIS-620','UTF-8',$r['Lastname']);?>
                                </option>
                            <?php } ?>
                        </select>
						</div>
                    </div>
                    <div class="form-group">
                        <?php
                            $g = "SELECT G.Group_ID, CAST(G.Group_Name as Text) AS Name ";
                            $g .= " FROM [HRP].[dbo].[Employees] E LEFT JOIN [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID ";
                            $g .= " WHERE E.Site_ID = '".$_SESSION['SuperSite']."' ";
                            $g .= " GROUP BY G.Group_ID,G.Group_Name ";

                            $qg = mssql_query($g);
                            $ng = mssql_num_rows($qg);
                        ?>
                        <label class="radio-inline width-text1" style="width: 65px;">ชุด</label>
                        <select class="form-control-normal chosen-select" name="group" id="group" style="width: 300px;height: 30px;">
                            <?php if($group != '') { ?>
                                <option value="<?php echo $r_g['Group_ID']; ?>">
                                    <?php echo iconv('TIS-620','UTF-8',$r_g['Name']); ?>
                                </option>
                                <option value=""><?php echo 'ทั้งหมด'; ?></option>
                            <?php }else{ ?>
                                <option value=""><?php echo 'ทั้งหมด'; ?></option>
                            <?php } ?>
                            <?php
                            for($jv=1;$jv<=$n;$jv++)
                            {
                                $rg = mssql_fetch_array($qg);
                            ?>
                                <option value="<?php echo $rg['Group_ID'];?>">
                                    <?php echo iconv('TIS-620','UTF-8',$rg['Name']);?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group" id="data_6">
                    <label class="radio-inline width-text1" style="width: 85px;">งวดเวลา</label>
                    <select class="form-control-normal" style="width: 250px;height: 30px;margin-left: 20px;" name="Period" id="Period" readonly>
                        <?php if($period != '') {?>
                            <option value="<?php echo $row_Per_id['Per_ID'];?>"><?php echo 'งวดที่ '.$row_Per_id['Per_Week'].' ช่วง '.$row_Per_id['Per_StartDate'].' - '.$row_Per_id['Per_EndDate'];?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row_Per_id['Per_ID'];?>">
                                <?php echo 'งวดที่ '.$row_Per_id['Per_Week'].' ช่วง '.$row_Per_id['Per_StartDate'].' - '.$row_Per_id['Per_EndDate'];?>
                            </option>
                        <?php } ?>
                        <?php if($search != '1') { ?>
                            <?php
                                for($i=1;$i<=$num_period;$i++)
                            {
                                $row_period = mssql_fetch_array($query_period);
                            ?>
                                <option value="<?php echo $row_period['Per_ID'];?>"><?php echo 'งวดที่ '.$row_period['Per_Week'].' ช่วง '.$row_period['Per_StartDate'].' - '.$row_period['Per_EndDate'];?></option>
                            <?php } ?>
                        <?php } else { ?>
                            <?php
                                for($i=1;$i<=$num_periods;$i++)
                            {
                                $row_periods = mssql_fetch_array($query_periods);
                            ?>
                                <option value="<?php echo $row_periods['Per_ID'];?>"><?php echo 'งวดที่ '.$row_periods['Per_Week'].' ช่วง '.$row_periods['Per_StartDate'].' - '.$row_periods['Per_EndDate'];?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group" id="data_5" style="display: none;">
                    <label class="radio-inline width-text1">ช่วงเวลา</label>
                    <?php
                      $Start = new datetime($_SESSION['SubStart']);
                      $Start = $Start->format('d-m-Y');
                      $End = new datetime($_SESSION['SubEnd']);
                      $End = $End->format('d-m-Y');
                    ?>
                    <div class="input-daterange input-group" data-date="<?=date('d-m-Y');?>" data-date-format="dd-mm-yyyy" style="padding-left: 20px;">
                        <input type="text" class="input-sm form-control" name="start" value="<?php if($Start != ''){ echo $Start; }else{ echo date('d-m-Y'); } ?>"/>
                        <span class="input-group-addon"> ถึง </span>
                        <input type="text" class="input-sm form-control" name="end" value="<?php if($End != ''){ echo $End; }else{ echo date('d-m-Y'); } ?>" />
                    </div>
                </div>
                <div class="form-group" style="margin-left: 20px;">
                    <input type="hidden" id="CheckTime" value="<?php echo $_SESSION['Time']; ?>">
                    <div class="radio radio-info radio-inline">
                        <input type="radio" id="TimeFix" name="Time" value="1" <?php if($_SESSION['Time'] == '1' || $_SESSION['Time'] == '') echo 'checked';?> >
                        <label for="inlineRadio1"> งวดเวลา </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input type="radio" id="TimePhase" name="Time" value="2" <?php if($_SESSION['Time'] == '2') echo 'checked';?> >
                        <label for="inlineRadio1"> ช่วงเวลา </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="See" value="ทั้งหมด" <?php if($_SESSION['SubSee'] == 'ทั้งหมด' || $_SESSION['SubSee'] == '') echo 'checked';?> >
                        <label for="inlineRadio1"> ทั้งหมด </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="See" value="มีเวลา" <?php if($_SESSION['SubSee'] == 'มีเวลา') echo 'checked';?> >
                        <label for="inlineRadio1"> มีเวลา </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="See" value="ไม่มีเวลา" <?php if($_SESSION['SubSee'] == 'ไม่มีเวลา') echo 'checked';?> >
                        <label for="inlineRadio1"> ไม่มีเวลา </label>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="Check" id="Check" value="<?php echo '1'; ?>" />
                    <input name="btnSubmit" type="submit" id="submit" value="ค้นหา" class="btn btn-success SubmitData">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <input type="hidden" name="Nums" id="Nums" value="<?php echo $num; ?>" />
                <!-- <input style="width: 150px;margin-left: auto;" type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="ค้นหา">
                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="30" data-filter=#filter style="font-size: 12px;"> -->
                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="1500">
                    <thead>
                        <tr>
                            <th style="text-align: center;width: 200px;">ชื่อ-สกุล</th>
                            <th style="text-align: center;">วันที่</th>
                            <th style="text-align: center;width: 80px;">เข้าเช้า</th>
                            <th style="text-align: center;width: 80px;">ออกเช้า</th>
                            <th style="text-align: center;width: 80px;">เข้าบ่าย</th>
                            <th style="text-align: center;width: 80px;">ออกบ่าย</th>
                            <th style="text-align: center;width: 80px;">เข้าOT1</th>
                            <th style="text-align: center;width: 80px;">ออกOT1</th>
                            <th style="text-align: center;width: 80px;">เข้าOT2</th>
                            <th style="text-align: center;width: 80px;">ออกOT2</th>
                            <th style="text-align: center;width: 80px;">ทำปกติ</th>
                            <th style="text-align: center;width: 80px;">ผ่าเที่ยง</th>
                            <!-- <th style="text-align: center;width: 80px;">ผ่าเย็น</th> -->
                            <th style="text-align: center;">OT1.5</th>
                            <th style="text-align: center;">OT2</th>
                            <th style="text-align: center;">Ac</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $searchPeriod = "SELECT Per_Active as active FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
                        $queryPeriod = mssql_query($searchPeriod);
                        $rowPeriod = mssql_fetch_assoc($queryPeriod);

                        for($i=1;$i<=$num;$i++)
                        {
                            $row = mssql_fetch_assoc($query);

                            $Em_ID = $row['Em_ID'];
                            $date = new datetime($row['Date_']);
                            $date = $date->format('d-m-Y');

                            if($row['Em_Titel'] == 'Mr') {
                                $Titels = 'นาย ';
                            }
                            if($row['Em_Titel'] == 'Ms') {
                                $Titels = 'นางสาว ';
                            }
                            if($row['Em_Titel'] == 'Mrs') {
                                $Titels = 'นาง ';
                            }

                            $one = explode(':', $row['CK_in']);
                            $ones = (($one[0] * 60) + $one[1]);
                            if($ones > 495) {
                                $texts = 'red';
                            } else {
                                $texts = 'black';
                            }
                    ?>
                        <tr>
                            <td style="width: 200px;"><?php echo $Titels.' '.iconv('TIS-620','UTF-8',$row['Fullname']).' '.iconv('TIS-620', 'UTF-8', $row['Lastname']); ?></td>
                            <td style="width: 8%;"><?php echo $date; ?></td>
                            <?php if($row['CK_in'] != '' && $row['CK_in'] != ' ') { ?>
                                <td style="text-align: center;width: 80px;background-color: #00FFFF;color : <?=$texts?>;font-size: 15px;"><?php echo $row['CK_in']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;width: 80px;background-color: #FFFF33;"></td>
                            <?php } ?>

                            <?php if($row['Ck_Out1'] != '' && $row['Ck_Out1'] != ' ') { ?>
                                <td style="text-align: center;width: 80px;background-color: #00FFFF;color : black;font-size: 15px;"><?php echo $row['Ck_Out1']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;width: 80px;background-color: #FFFF33;"></td>
                            <?php } ?>

                            <?php if($row['CK_in2'] != '' && $row['CK_in2'] != ' ') { ?>
                                <td style="text-align: center;width: 80px;background-color: #00FFFF;color : black;font-size: 15px;"><?php echo $row['CK_in2']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;width: 80px;background-color: #FFFF33;"></td>
                            <?php } ?>

                            <?php if($row['Ck_Out2'] != '' && $row['Ck_Out2'] != ' ') { ?>
                                <td style="text-align: center;width: 80px;background-color: #00FFFF;color : black;font-size: 15px;"><?php echo $row['Ck_Out2']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;width: 80px;background-color: #FFFF33;"></td>
                            <?php } ?>

                            <?php if($row['CKOT_in1'] != '' && $row['CKOT_in1'] != ' ') { ?>
                                <td style="text-align: center;width: 80px;background-color: #00FFFF;color : black;font-size: 15px;"><?php echo $row['CKOT_in1']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;width: 80px;background-color: #FFFF33;"></td>
                            <?php } ?>

                            <?php if($row['CKOT_Out1'] != '' && $row['CKOT_Out1'] != ' ') { ?>
                                <td style="text-align: center;width: 80px;background-color: #00FFFF;color : black;font-size: 15px;"><?php echo $row['CKOT_Out1']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;width: 80px;background-color: #FFFF33;"></td>
                            <?php } ?>

                            <?php if($row['CKOT_in2'] != '' && $row['CKOT_in2'] != ' ') { ?>
                                <td style="text-align: center;width: 80px;background-color: #FF0000;color : black;font-size: 15px;"><?php echo $row['CKOT_in2']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;width: 80px;background-color: #FFFF33;"></td>
                            <?php } ?>

                            <?php if($row['CKOT_Out2'] != '' && $row['CKOT_Out2'] != ' ') { ?>
                                <td style="text-align: center;width: 80px;background-color: #FF0000;color : black;font-size: 15px;"><?php echo $row['CKOT_Out2']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;width: 80px;background-color: #FFFF33;"></td>
                            <?php } ?>
                            
                            <?php if($row['Total'] != '') { ?>
                                <td style="text-align: center;background-color: #00FF33;color : black;font-size: 15px;"><?php echo $row['Total']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;"><?php echo $row['Total']; ?></td>
                            <?php } ?>
                            <?php if($row['OTN'] > '0') { ?>
                                <td style="text-align: center;background-color: #00FF33;color : black;font-size: 15px;"><?php echo $row['OTN']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;"><?php echo $row['OTN']; ?></td>
                            <?php } ?>
                            <?php $total15 = ($row['TotalOT15'] + $row['OTE']); ?>
                            <?php if($total15 > '0') { ?>
                                <td style="text-align: center;background-color: #00FF33;color : black;font-size: 15px;"><?php echo $total15; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;"></td>
                            <?php } ?>
                            <?php if($row['TotalOT2'] > '0') { ?>
                                <td style="text-align: center;background-color: #FF0000;color : black;font-size: 15px;"><?php echo $row['TotalOT2']; ?></td>
                            <?php } else { ?>
                                <td style="text-align: center;"><?php echo $row['TotalOT2']; ?></td>
                            <?php } ?>
                            <td style="text-align: center;">
                                <?php if($row['TimePlan_Status'] != '2' && $rowPeriod['active'] != '0') { if($row['CK_in'] != '') { ?>
                                    <div class="btn-group">
                                        <a href="TimePlanDetail.php?Em_ID=<?php echo $Em_ID;?>&LogTime=<?php echo $date;?>&Check=0" class="btn-white btn btn-xs" role="button">แก้ไข</a>
                                    </div>
                                <?php } elseif($row['CK_in'] == '') { ?>
                                    <div class="btn-group">
                                        <a href="TimePlanDetail.php?Em_ID=<?php echo $Em_ID;?>&LogTime=<?php echo $date;?>&Check=1" class="btn-white btn btn-xs" role="button">เพิ่มเวลา</a>
                                    </div>
                                <?php } } else { if($row['CK_in'] != '') { ?>
                                    <div class="btn-group">
                                        <a class="btn-white btn btn-xs" onClick="Alert();" role="button">แก้ไข</a>
                                    </div>
                                <?php } elseif($row['CK_in'] == '') { ?>
                                    <div class="btn-group">
                                        <a class="btn-white btn btn-xs" onClick="Alert();" role="button">เพิ่มเวลา</a>
                                    </div>
                                <?php } } ?>
                            </td>
                        </tr>
                    <?php } ?>
						<tfoot>
							<tr>
								<td colspan="7">
									<p><?php echo 'ข้อมูลทั้งหมด '.$num.' รายการ'; ?></p>
								</td>
							</tr>
						</tfoot>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
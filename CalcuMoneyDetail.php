<div class="ibox-content m-b-sm border-bottom">
    <div class="row">
        <form action="CalcuMoney.php" method="POST">
        <!-- <form action="CalcuMoney.php" method="POST" target="iframe_target">
        <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe> -->
            <div class="col-sm-4">
                <?php if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') { ?>
                    <div class="form-group">
                        <?php
                            $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
                            $query_site = mssql_query($sql_site);
                            $row_site = mssql_fetch_array($query_site);
                        ?>
                        <label class="radio-inline width-text1" style="width: 100px;">โครงการ</label>
                        <select class="form-control-normal" name="Site_ID" id="Site_ID" style="width: 300px;height: 30px;" required="required">
                            <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                        </select>
                    </div>
                <?php } else { ?>
                    <div class="form-group">
                        <label class="radio-inline" style="width: 100px;"> โครงการ </label>
                        <?php
                            $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '". $site ."' AND Site_ID != '1' ";
                            $query_site = mssql_query($sql_site);
                            $num_site = mssql_num_rows($query_site);
                        ?>
                        <select class="form-control-normal chosen-select" name="Site_ID" id="Site_ID" style="width: 300px;height: 30px;" required="required">
                            <?php if($site != '') { ?>
                                <option value="<?php echo $r_s['Site_ID']; ?>"><?php echo iconv('TIS-620','UTF-8',$r_s['Site_Name']); ?></option>
                            <?php } else { ?>
                                <option value=''>-- เลือกโครงการ --</option>
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
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="radio-inline" style="width: 100px;"> ตำแหน่ง </label>
                    <?php
                        $sql_pos = "SELECT Pos_ID, CAST(Pos_Name AS Text) AS Pos_Name FROM [HRP].[dbo].[Position] WHERE Pos_ID != '". $pos ."' ";
                        $query_pos = mssql_query($sql_pos);
                        $num_pos = mssql_num_rows($query_pos);
                    ?>
                    <select class="input-sm form-control input-s-sm inline" name="Pos" id="Pos">
                        <?php if($pos != '') {?>
                            <option value="<?php echo $r_p['Pos_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$r_p['Pos_Name']);?></option>
                        <?php } else { ?>
                            <option value="">-- เลือกตำแหน่ง --</option>
                        <?php } ?>
                        <?php
                        for($i=1;$i<=$num_pos;$i++)
                        {
                            $row_pos = mssql_fetch_array($query_pos);
                        ?>
                            <option value="<?php echo $row_pos['Pos_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_pos['Pos_Name']);?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="radio-inline" style="width: 100px;"> ชุด </label>
                    <?php
                        $sql_group = "SELECT Group_ID, CAST(Group_Name AS Text) AS Group_Name FROM [HRP].[dbo].[Group] WHERE Group_ID != '". $group ."' ";
                        $query_group = mssql_query($sql_group);
                        $num_group = mssql_num_rows($query_group);
                    ?>
                    <select class="input-sm form-control input-s-sm inline" name="Group" id="Group">
                        <?php if($group != '') {?>
                            <option value="<?php echo $r_g['Group_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$r_g['Group_Name']);?></option>
                        <?php } else { ?>
                            <option value="">-- เลือกชุด --</option>
                        <?php } ?>
                        <?php
                        for($i=1;$i<=$num_group;$i++)
                        {
                            $row_group = mssql_fetch_array($query_group);
                        ?>
                            <option value="<?php echo $row_group['Group_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_group['Group_Name']);?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="radio-inline" style="width: 100px;"> งวด </label>
                    <?php
                        $date = new DateTime();
                        $date = $date->format('Y');
                    ?>
                    <select class="input-sm form-control input-s-sm inline" name="Period" id="Period" style="width: 300px;">
                        <?php if($_SESSION['Period_Cal'] != '') {?>
                            <?php
                                $sql_per_cal = "SELECT Per_ID, Per_Week, Per_StartDate, Per_EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $_SESSION['Period_Cal'] ."' ";
                                $query_per_cal = mssql_query($sql_per_cal);
                                $row_per_cal = mssql_fetch_assoc($query_per_cal);
                            ?>
                            <option value="<?php echo $row_per_cal['Per_ID'];?>">
								<?php echo 'งวดที่ '.$row_per_cal['Per_Week'].' ช่วง '.$row_per_cal['Per_StartDate'].' - '.$row_per_cal['Per_EndDate'];?>
							</option>
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
            </div>
            <div class="col-sm-5">
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label class="control-label" for="status">&nbsp;</label>
                    <?php if($_SESSION['Rule'] != 2) { ?>
                        <input type="hidden" name="Check" id="Check" value="<?php echo '1'; ?>" />
                        <input type="hidden" name="View" id="View" value="<?php echo '2'; ?>" />
                        <button class="btn btn-success" id="CalcuV">ดูข้อมูล</button>
                    <?php } else { ?>
                        <input type="hidden" name="Check" id="Check" value="<?php echo '1'; ?>" />
                        <input type="hidden" name="View" id="View" value="<?php echo '2'; ?>" />
                        <input type="hidden" name="Back" id="Back" value="<?php echo '3'; ?>" />
                        <button class="btn btn-success" id="CalcuV">ดูข้อมูล</button>
                        <?php if($lable == '2') { ?>
							<button class="btn btn-success SubmitData" id="CalcuN" onclick="return confirm('คุณแน่ใจที่จะทำการตัดวีค!!\nโปรดตรวจสอบข้อมูลให้ถูกต้องการทำการตัดวีค')">ตัดวีค</button>
                        <?php } ?>
                        <?php if($lable == '1') { ?>
							<button class="btn btn-success" id="CalcuC">คืนสถานะ</button>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-9"></div>
            <div class="col-sm-3">
                <div class="form-group">
                    <input type="hidden" id="lable" value="<?php echo $lable; ?>" />
                    <input type="hidden" id="lableDT" value="<?php echo $DT; ?>" />
                    <input type="hidden" id="cReport" value="<?php echo $report; ?>" />
                    <!-- <input type="text" id="tlable" class="radio-inline width-text1 pull-right"> -->
                    <label class="radio-inline" style="width: 175px;font-size: 15px;" id="tlable" value=""></label>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>ตำแหน่ง</th>
                            <th>ชุด</th>
                            <th>โครงการ</th>
                            <th style="text-align: center;">รายได้ต่อวัน</th>
                            <th style="text-align: center;">ทำงานรวม</th>
                            <th style="text-align: center;">OT1.5</th>
                            <th style="text-align: center;">OT2</th>
                            <th style="text-align: center;" data-hide="all">ผ่าเที่ยง</th>
                            <th style="text-align: center;">รวมรายได้ปกติ</th>
                            <th style="text-align: center;">รวม OT</th>
                            <th style="text-align: center;" data-hide="all">หักค่าใช้จ่าย</th>
                            <th style="text-align: center;" data-hide="all">ราคา</th>
                            <th style="text-align: center;" data-hide="all">รายรับเพิ่มเติม</th>
                            <th style="text-align: center;" data-hide="all">ราคา</th>
                            <th style="text-align: center;" data-hide="all"><?php echo 'ประกันสังคม '.$P_Social.' %';?></th>
                            <th style="text-align: center;" data-hide="all"><?php echo 'เบี้ยเลี้ยง ';?></th>
                            <th style="text-align: center;">รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i=1;$i<=$num;$i++) {
                                $row = mssql_fetch_array($query);
                                $id = $row['Code'];

								if($row['Titel'] == 'Mr') {
									$Titel = 'นาย ';
								}
								if($row['Titel'] == 'Ms') {
									$Titel = 'นางสาว ';
								}
								if($row['Titel'] == 'Mrs') {
									$Titel = 'นาง ';
								}

                                if($period % '2' == '0') {
                                    $Bperiod = $period - 1;

                                    $sql_social = "SELECT MT_Socail as Socials FROM [HRP].[dbo].[MoneyTotal] where Em_ID = '".$id."' and MT_Period = '".$Bperiod."' ";
                                    $query_social = mssql_query($sql_social);
                                    $row_social = mssql_fetch_array($query_social);

                                    $Socials = $row_social['Socials'];
                                }

                                if($lable == 0 || $lable == 3) {
                                    // ตัดวีค && ตัดวีคซ้ำ
                                    $sql_item = "SELECT L.List_Num, L.List_Price as Price, I.Item_Name as Item_Name, I.Item_Status as Status, L.List_Status AS List_Status ";
                                    $sql_item .= " FROM [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID ";
                                    $sql_item .= " WHERE L.Em_ID = '".$id."' AND L.Per_ID <= '".$period."' AND L.List_Status = '0' AND L.Site_ID = '". $_SESSION['SuperSite'] ."' ";
                                } elseif($lable == 1) {
                                    // ดูข้อมูลที่คำนวณแล้ว
                                    $sql_item = "SELECT L.List_Num, L.List_Price as Price, I.Item_Name as Item_Name, I.Item_Status as Status, L.List_Status AS List_Status ";
                                    $sql_item .= " FROM [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID ";
                                    $sql_item .= " WHERE L.Em_ID = '".$id."' AND L.List_Status = '1' AND L.List_Period = '".$period."' AND L.Site_ID = '". $_SESSION['SuperSite'] ."' ";
                                } elseif($lable == 2) {
                                    // ดูข้อมูลที่ยังไม่คำนวณ
                                    $sql_item = "SELECT L.List_Num, L.List_Price as Price, I.Item_Name as Item_Name, I.Item_Status as Status, L.List_Status AS List_Status ";
                                    $sql_item .= " FROM [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID ";
                                    $sql_item .= " WHERE L.Em_ID = '".$id."' AND L.Per_ID = '".$period."' AND L.Site_ID = '". $_SESSION['SuperSite'] ."' ";
                                }

                                $q = mssql_query($sql_item);
                                $n = mssql_num_rows($q);
                                $P1 = 0; $P0 = 0; $v = 0; $s = 0;$P_Item_Name1 = '';$P_Item_Name0 = '';
                                for($j=1;$j<=$n;$j++) {
                                    $r = mssql_fetch_array($q);
                                    // if($j == 1) {
                                    //     $P_Item_Name1 = '';$P_Item_Name0 = '';
                                    // }

                                    if($r['Status'] == 1) {
                                        $v = $v + 1;
                                        $Price1 = $r['Price'];
                                        $Item_Name1 = iconv('TIS-620', 'UTF-8', $r['Item_Name']);
                                        if($v == 1) {
                                            $P_Item_Name1 = $Item_Name1;
                                        } else {
                                            $P_Item_Name1 = $P_Item_Name1.', '.$Item_Name1;
                                        }
                                        $P1 = $P1 + $Price1;
                                    }
                                    elseif ($r['Status'] == 0 ) {
                                        $s = $s + 1;
                                        $Price0 = $r['Price'];
                                        $Item_Name0 = iconv('TIS-620', 'UTF-8', $r['Item_Name']);
                                        if($s == 1) {
                                            $P_Item_Name0 = $Item_Name0;
                                        } else {
                                            $P_Item_Name0 = $P_Item_Name0.', '.$Item_Name0;
                                        }
                                        $P0 = $P0 + $Price0;
                                    }
                                }

                                //calculation
                                $money = $row['Money'];

								// echo iconv('TIS-620', 'UTF-8', $row['Fullname']).'-'.$money.'<br>';

                                $a = $money / 9;$b = $money / 8;
								$Social = 0;
								$TotalSocials = '0';

                                $total = $row['Total'];
                                $total15 = $row['total15'];
                                $total2 = $row['total2'];
                                $OTN = $row['OTN'];
                                $OTE = $row['OTE'];

                                if($period % 2) {
                                    if($total > 135) {
                                        $colorT = 'red';
                                    }
                                } else {
                                    if($total > 144) {
                                        $colorT = 'red';
                                    }
                                }

                                $P_total = round($total * $a);
                                // echo iconv('TIS-620', 'UTF-8', $row['Fullname']).'-'.$total.'-'.$a.'-'.$P_total.'<br>';
                                $P_OTE = $total15 + $OTE;
                                $P_total15 = round($b * 1.5 * $P_OTE);
                                $P_total2 = round($b * 2 * $total2);
                                $P_OTN = round($b * $OTN);

                                $totalOT = $P_total15 + $P_total2 + $P_OTN;

                                $SUM = $P_total + $P_total15 + $P_total2 + $P_OTN;

                                $checkAge = new DateTime($row['DateBirthDay']);
                                $checkAge = $checkAge->format('Y');

                                $NowDate = new DateTime();
                                $NowDate = $NowDate->format('Y');

                                $Ages = $NowDate - $checkAge;

                                if($row['people'] == 'TH') {
                                    if($row['Socie'] == 1) {
                                        if($Ages >= 18) {
                                            if($Ages <= 60) {
                                                // echo iconv('TIS-620', 'UTF-8', $row['Fullname']).'-'.$Ages.'<br>';
                                                $Social = round($P_total * $PS_Social);
                                            }
                                        }
                                    } else {
                                        $Social = 0;
                                    }
                                } else {
                                    if($row['Socie'] == 1) {
                                        if($Ages >= 18) {
                                            if($Ages <= 60) {
                                                // echo iconv('TIS-620', 'UTF-8', $row['Fullname']).'-'.$Ages.'<br>';
                                                $Social = round($P_total * $PS_Social);
                                            }
                                        }
                                    } else {
                                        $Social = 0;
                                    }
                                }

                                $TotalSocial = $Social + $Socials;

                                if($Social <= '750') {
                                    if( $TotalSocial > '750') {
                                        $TotalSocials = 750 - $Socials;
                                    } else {
                                        $TotalSocials = $Social;
                                    }
                                }

                                if($_SESSION['SuperSite'] != '1') {
                                    $IdSite = $_SESSION['SuperSite'];
                                } else {
                                    $IdSite = $row['Site_ID'];
                                }

								$LongName = $row['Fullname'].' '.$row['Lastname'];
								$PosName = iconv('TIS-620', 'UTF-8', $row['Pos_Name']);
								$GroupName = iconv('TIS-620', 'UTF-8', $row['Group_Name']);

                                $Totals = $SUM - $TotalSocial;

                                if($lable == 0) {
                                    $sql_check = " SELECT Em_ID FROM [HRP].[dbo].[MoneyTotal] WHERE Em_ID = '".$row['Code']."' AND MT_Period = '".$period."' AND Site_ID = '". $_SESSION['SuperSite'] ."' ";

                                    $query_check = mssql_query($sql_check);
                                    $num_check = mssql_num_rows($query_check);
                                    $row_check = mssql_fetch_array($query_check);

                                    $dates = new datetime();
                                    $dates = $dates->format('d-m-Y');
									$array_year = explode('-', $dates);
									$year = $array_year[2];

                                    if($num_check == 0 || $num_check == '') {
                                        $sql_insert = " INSERT INTO [HRP].[dbo].[MoneyTotal]
                                                        (Em_ID, MT_Totals, MT_TotalOT1, MT_TotalOT15, MT_TotalOT2, MT_Socail, MT_SumTotals, MT_Period, MT_Mny_1, MT_Mny_2, MT_Mny_3, MT_Mny_4, MT_Mny_5, Admin_Update, MT_Status, Site_ID, MT_Year, MT_GroupID, MT_GroupName, MT_Name, MT_Titel, MT_PositionName, MT_Money, MT_PositionID, MT_Card, MT_AccountNumber, MT_CashCard)
                                                        VALUES
                                                        ('". $id ."', '". $P_total ."', '". $P_OTN ."', '". $P_total15 ."', '". $P_total2 ."', '". $TotalSocials ."', '". $Totals ."', '". $period ."', '". $row['Mny_1'] ."', '". $row['Mny_2'] ."', '". $row['Mny_3'] ."', '". $row['Mny_4'] ."', '". $row['Mny_5'] ."', '". $_SESSION['SuperName'] ."', '0', '". $IdSite ."', '". $year ."', '". $row['GroupID'] ."', '". $row['Group_Name'] ."', '". $LongName ."', '". $row['Titel'] ."', '". $row['Pos_Name'] ."', '". $row['Money'] ."', '". $row['PosID'] ."', '". $row['Card'] ."', '". $row['Account'] ."', '". $row['CashCard'] ."')";

                                        // echo $sql_insert.'<br>';
                                        mssql_query($sql_insert);
                                    }
                                }
                        ?>
                        <tr>
                            <td><?php echo $Titel.' '.iconv('TIS-620', 'UTF-8', $row['Fullname']).' '.iconv('TIS-620', 'UTF-8', $row['Lastname']); ?></td>
                            <td><?php echo iconv('TIS-620', 'UTF-8', $row['Pos_Name']); ?></td>
                            <td><?php echo iconv('TIS-620', 'UTF-8', $row['Group_Name']); ?></td>
                            <td><?php echo iconv('TIS-620', 'UTF-8', $row['Site_Name']); ?></td>
                            <td style="text-align: center;"><?php echo $money; ?></td>
                            <td style="text-align: center;color: <?=$colorT?>"><?php echo $total; ?></td>
                            <td style="text-align: center;"><?php echo ($total15+$OTE); ?></td>
                            <td style="text-align: center;"><?php echo $total2; ?></td>
                            <td style="text-align: center;"><?php echo $OTN; ?></td>
                            <td style="text-align: center;"><?php echo $P_total; ?></td>
                            <td style="text-align: center;"><?php echo $totalOT; ?></td>
                            <td style="text-align: center;"><?php if(empty($P_Item_Name0)){ echo 'ไม่มี'; }else{ echo $P_Item_Name0; }?></td>
                            <td style="text-align: center;"><?php if(empty($P0)){ echo '0'; }else{ echo $P0; }?></td>
                            <td style="text-align: center;"><?php if(empty($P_Item_Name1)){ echo 'ไม่มี'; }else{ echo $P_Item_Name1; }?></td>
                            <td style="text-align: center;"><?php if(empty($P1)){ echo '0'; }else{ echo $P1; }?></td>
                            <td style="text-align: center;"><?php echo $TotalSocials; ?></td>
                            <td style="text-align: center;"><?php echo $row['Mny_1'];?></td>
                            <td style="text-align: center;"><?php echo $SUM; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul class="pagination pull-right"></ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
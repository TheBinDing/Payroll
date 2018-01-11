<div class="ibox-content m-b-sm border-bottom">
    <div class="row">
        <form action="CalcuMoneyIT.php" method="POST">
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
                        <select class="input-sm form-control input-s-sm inline" name="Site_ID" id="Site_ID" style="width: 300px;height: 30px;" required="required">
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
                        $sql_period = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID != '".$period."' ";
                        $query_period = mssql_query($sql_period);
                        $num_period = mssql_num_rows($query_period);
                    ?>
                    <select class="input-sm form-control input-s-sm inline" name="Period" id="Period" style="width: 300px;" required="required">
                        <?php if($period != '') {?>
                            <option value="<?php echo $r_pe['Per_ID'];?>"><?php echo 'งวดที่ '.$r_pe['Per_Week'].' ช่วง '.$r_pe['Per_StartDate'].' - '.$r_pe['Per_EndDate'];?></option>
                        <?php } else { ?>
                            <option value="">-- เลือกงวด --</option>
                        <?php } ?>
                        <?php
                            for($i=1;$i<=$num_period;$i++)
                        {
                            $row_period = mssql_fetch_array($query_period);
                        ?>
                            <option value="<?php echo $row_period['Per_ID'];?>"><?php echo 'งวดที่ '.$row_period['Per_Week'].' ช่วง '.$row_period['Per_StartDate'].' - '.$row_period['Per_EndDate'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label class="control-label" for="status">&nbsp;</label>
                    <input type="hidden" name="Check" id="Check" value="<?php echo '1'; ?>" />
                    <input type="hidden" name="View" id="View" value="<?php echo '2'; ?>" />
                    <button class="btn btn-success" id="CalcuV">ดูข้อมูล</button>
                    <button class="btn btn-success SubmitData" id="CalcuN" onclick="return confirm('คุณแน่ใจที่จะทำการตัดวีค!!\nโปรดตรวจสอบข้อมูลให้ถูกต้องการทำการตัดวีค')">ตัดวีคซ้ำ</button>
                </div>
            </div>
            <div class="col-sm-9"></div>
            <div class="col-sm-3">
                <div class="form-group">
                    <input type="hidden" id="lable" value="<?php echo $lable; ?>" />
                    <input type="hidden" id="lableDT" value="<?php echo $DT; ?>" />
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

                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="20">
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
                            <th style="text-align: center;" data-hide="all">ผ่าเย็น</th>
                            <th style="text-align: center;">รวมรายได้ปกติ</th>
                            <th style="text-align: center;">รวม OT</th>
                            <th style="text-align: center;" data-hide="all">หักค่าใช้จ่าย</th>
                            <th style="text-align: center;" data-hide="all">ราคา</th>
                            <th style="text-align: center;" data-hide="all">รายรับเพิ่มเติม</th>
                            <th style="text-align: center;" data-hide="all">ราคา</th>
                            <th style="text-align: center;" data-hide="all"><?php echo 'ประกันสังคม '.$P_Social.' %';?></th>
                            <th style="text-align: center;">รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i=1;$i<=$num;$i++) {
                                $row = mssql_fetch_array($query);
                                $id = $row['Code'];

                                if($period % '2' == '0') {
                                    $Bperiod = $period - 1;

                                    $sql_social = "SELECT MT_Social as Socials FROM [HRP].[dbo].[MoneyTotals] where Em_ID = '".$id."' and MT_Period = '".$Bperiod."' ";
                                    $query_social = mssql_query($sql_social);
                                    $row_social = mssql_fetch_array($query_social);

                                    $Socials = $row_social['Socials'];
                                }

                                if($lable == 0 || $lable == 3) {
                                    // ตัดวีค && ตัดวีคซ้ำ
                                    $sql_item = "SELECT L.List_Num, L.List_Price as Price, I.Item_Name as Item_Name, I.Item_Status as Status, L.List_Status AS List_Status ";
                                    $sql_item .= " FROM [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID ";
                                    $sql_item .= " WHERE L.Em_ID = '".$id."' AND L.Per_ID <= '".$period."' AND L.List_Status = '0' ";
                                } elseif($lable == 1) {
                                    // ดูข้อมูลที่คำนวณแล้ว
                                    $sql_item = "SELECT L.List_Num, L.List_Price as Price, I.Item_Name as Item_Name, I.Item_Status as Status, L.List_Status AS List_Status ";
                                    $sql_item .= " FROM [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID ";
                                    $sql_item .= " WHERE L.Em_ID = '".$id."' AND L.List_Status = '1' AND L.List_Period = '".$period."'  ";
                                } elseif($lable == 2) {
                                    // ดูข้อมูลที่ยังไม่คำนวณ
                                    $sql_item = "SELECT L.List_Num, L.List_Price as Price, I.Item_Name as Item_Name, I.Item_Status as Status, L.List_Status AS List_Status ";
                                    $sql_item .= " FROM [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID ";
                                    $sql_item .= " WHERE L.Em_ID = '".$id."' AND L.Per_ID = '".$period."' ";
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

                                $a = number_format($money / 9, 2, '.', '');$b = number_format($money / 8, 2, '.', '');

                                $total = $row['Total'];
                                $total15 = $row['total15'];
                                $total2 = $row['total2'];
                                $OTN = $row['OTN'];
                                $OTE = $row['OTE'];

                                $P_total = round($total * $a);
                                $P_OTE = round($b * 1.5 * $OTE);
                                $P_total15 = round($b * 1.5 * $total15) + $P_OTE;
                                $P_total2 = round($b * 2 * $total2);
                                $P_OTN = round($b * $OTN);

                                $totalOT = $P_total15 + $P_total2 + $P_OTN + $P_OTE;

                                $SUM = $P_total + $P_total15 + $P_total2 + $P_OTN + $P_OTE + $P1 - $P0;

                                $Social = round($SUM * $PS_Social);

                                $TotalSocial = $Social + $Socials;
                                if( $TotalSocial > '750') {
                                    $TotalSocials = 750 - $Social;
                                } else {
                                    $TotalSocials = $Social;
                                }

                                $Totals = $SUM - $TotalSocial;

                                if($lable == 3) {
                                    $sql_check = " SELECT Em_ID, MT_Totals, MT_TotalOT1, MT_TotalOT15, MT_TotalOT2, MT_Socail, MT_SumTotals, MT_Period, Admin_Update FROM [HRP].[dbo].[MoneyTotal] WHERE Em_ID = '".$row['Code']."' AND MT_Period = '".$period."' ";

                                    $query_check = mssql_query($sql_check);
                                    $num_check = mssql_num_rows($query_check);
                                    $row_check = mssql_fetch_array($query_check);

                                    $dates = new datetime();
                                    $dates = $dates->format('Y-m-d H:i:s');

                                    $sql_update = "UPDATE [HRP].[dbo].[MoneyTotal] SET
                                                    MT_Totals = '". $P_total ."',
                                                    MT_TotalOT1 = '". $P_OTN ."',
                                                    MT_TotalOT15 = '". $P_total15 ."',
                                                    MT_TotalOT2 = '". $P_total2 ."',
                                                    MT_Socail = '". $TotalSocials ."',
                                                    MT_SumTotals = '". $Totals ."',
                                                    MT_Period = '". $period ."',
                                                    MT_Status = '2'
                                                WHERE
                                                    Em_ID = '". $id ."'
                                                    AND MT_Period = '". $period ."' ";
                                    mssql_query($sql_update);
                                    // echo $sql_update.'<br>';

                                    $sql_insert_log = " INSERT INTO [HRP].[dbo].[MoneyTotalLog]
                                                    (Em_ID, MT_Totals, MT_TotalOT1, MT_TotalOT15, MT_TotalOT2, MT_Socail, MT_SumTotals, MT_Period, MT_Update, MT_Admin)
                                                    VALUES
                                                    ('". $row_check['Em_ID'] ."', '". $row_check['MT_Totals'] ."', '". $row_check['MT_TotalOT1'] ."', '". $row_check['MT_TotalOT15'] ."', '". $row_check['MT_TotalOT2'] ."', '". $row_check['MT_Socail'] ."', '". $row_check['MT_SumTotals'] ."', '". $row_check['MT_Period'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."') ";

                                    mssql_query($sql_insert_log);
                                    // echo $sql_insert_log.'<br>';
                                }
                        ?>
                        <tr>
                            <td><?php echo iconv('TIS-620', 'UTF-8', $row['Fullname']); ?></td>
                            <td><?php echo iconv('TIS-620', 'UTF-8', $row['Pos_Name']); ?></td>
                            <td><?php echo iconv('TIS-620', 'UTF-8', $row['Group_Name']); ?></td>
                            <td><?php echo iconv('TIS-620', 'UTF-8', $row['Site_Name']); ?></td>
                            <td style="text-align: center;"><?php echo $money; ?></td>
                            <td style="text-align: center;"><?php echo $total; ?></td>
                            <td style="text-align: center;"><?php echo $total15; ?></td>
                            <td style="text-align: center;"><?php echo $total2; ?></td>
                            <td style="text-align: center;"><?php echo $OTN; ?></td>
                            <td style="text-align: center;"><?php echo $OTE; ?></td>
                            <td style="text-align: center;"><?php echo $P_total; ?></td>
                            <td style="text-align: center;"><?php echo $totalOT; ?></td>
                            <td style="text-align: center;"><?php if(empty($P_Item_Name0)){ echo 'ไม่มี'; }else{ echo $P_Item_Name0; }?></td>
                            <td style="text-align: center;"><?php if(empty($P0)){ echo '0'; }else{ echo $P0; }?></td>
                            <td style="text-align: center;"><?php if(empty($P_Item_Name1)){ echo 'ไม่มี'; }else{ echo $P_Item_Name1; }?></td>
                            <td style="text-align: center;"><?php if(empty($P1)){ echo '0'; }else{ echo $P1; }?></td>
                            <td style="text-align: center;"><?php echo $TotalSocials; ?></td>
                            <td style="text-align: center;"><?php echo $Totals; ?></td>
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
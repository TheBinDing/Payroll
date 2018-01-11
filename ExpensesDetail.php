<div class="ibox-content m-b-sm border-bottom">
    <div class="row">
        <!-- <form action="func/ExpensesSave.php" method="post"> -->
        <form action="func/ExpensesSave.php" method="post" target="iframe_target">
        <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
            <div class="col-sm-4 b-r">
                <?php if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') { ?>
                <div class="form-group">
                    <?php
                        $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
                        $query_site = mssql_query($sql_site);
                        $row_site = mssql_fetch_array($query_site);
                    ?>
                    <label class="radio-inline width-text1" style="width: 100px;">โครงการ</label>
                    <select class="form-control-normal" name="Site" id="Site" style="width: 300px;height: 30px;" required="required">
                        <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                    </select>
                </div>
                <?php } else { ?>
                <div class="form-group">
                    <div>
                        <label data-placeholder="โปรดใช้ชื่อที่ต้องการ" class="radio-inline width-text1" style="width: 100px;"> โครงการ </label>
                        <?php
                            $sql_s = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites]";
                            $query_s = mssql_query($sql_s);
                            $num_s = mssql_num_rows($query_s);
                        ?>
                        <select class="chosen-select" name="Site" id="Site" required="required" style="width: 300px;height: 30px;" tabindex="4">
                            <option value=""> - โปรดระบุ - </option>
                            <?php
                                for($s=1;$s<=$num_s;$s++)
                            {
                                $row_s = mssql_fetch_array($query_s);
                            ?>
                                <option value="<?php echo $row_s['Site_ID'];?>"><?php echo iconv('TIS-620', 'UTF-8', $row_s['Site_Name']);?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } ?>

                <div class="form-group">
					<div class="input-group">
                        <?php
                            // $wheres = !empty($_SESSION['SuperSite'])?  " WHERE S.Site_ID = '".$_SESSION['SuperSite']."' " : " WHERE S.Site_ID != '' ";
                            if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
                                $wheres = " WHERE S.Site_ID = '".$_SESSION['SuperSite']."' ";
                            } else {
                                $wheres = " WHERE S.Site_ID != '' ";
                            }

                            $s = "SELECT E.Em_ID, CAST(E.Em_Fullname AS Text) AS Fullname, CAST(E.Em_Lastname AS Text) AS Lastname ";
                            $s .= " FROM [HRP].[dbo].[Employees] E LEFT JOIN [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID ";
                            $s .= " $wheres ORDER BY Em_Fullname";

                            $q = mssql_query($s);
                            $n = mssql_num_rows($q);
                        ?>
                        <label class="radio-inline width-text1" style="width: 100px;"> ชื่อ </label>
                        <select class="form-control-normal chosen-select" name="Name" id="Name" style="width: 300px;height: 30px;">
                            <option value=""> - โปรดระบุ - </option>
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
                    <div>
                        <label class="radio-inline width-text1" style="width: 100px;"> งวด </label>
                        <select class="form-control-normal" name="Period" id="Period" required="required" style="width: 300px;height: 30px;">
                            <option value="<?php echo $row_Per_id['Per_ID'];?>">
                                <?php echo 'งวดที่ '.$row_Per_id['Per_Week'].' ช่วง '.$row_Per_id['Per_StartDate'].' - '.$row_Per_id['Per_EndDate'];?>
                            </option>
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
            </div>
            <div class="col-sm-3 b-r">
                <h4>รายจ่าย</h4>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox1" type="checkbox">
                        <label for="checkbox1" class="radio-inline width-text2" style="width: 100px;color: red;"> ค่าร้านค้า </label>

                        <input for="checkbox1" type="float" style="width: 50px;height: 30px;text-align: center;" class="form-control-card" id="Price1" name="Price1" required="required" value="0" disabled>
                        <!-- <label class="radio-inline"> บาท </label> -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox2" type="checkbox">
                        <label for="checkbox2" class="radio-inline width-text2" style="width: 100px;color: red;"> ค่าอุปกรณ์รวม </label>

                        <input for="checkbox2" type="float" style="width: 50px;height: 30px;text-align: center;" class="form-control-card" id="Price2" name="Price2" required="required" value="0" disabled>
                        <!-- <label class="radio-inline"> บาท </label> -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox3" type="checkbox">
                        <label for="checkbox3" class="radio-inline width-text2" style="width: 100px;color: red;"> ค่า Adv </label>

                        <input for="checkbox3" type="float" style="width: 50px;height: 30px;text-align: center;" class="form-control-card" id="Price3" name="Price3" required="required" value="0" disabled>
                        <!-- <label class="radio-inline"> บาท </label> -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox4" type="checkbox">
                        <label for="checkbox4" class="radio-inline width-text2" style="width: 100px;color: red;"> ค่าใช้จ่าย อื่นๆ </label>

                        <input for="checkbox4" type="float" style="width: 50px;height: 30px;text-align: center;" class="form-control-card" id="Price4" name="Price4" required="required" value="0" disabled>
                        <!-- <label class="radio-inline"> บาท </label> -->
                    </div>
                </div>
            </div>
            <div class="col-sm-3 b-r">
                <h4>รายรับ</h4>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox5" type="checkbox">
                        <label for="checkbox5" class="radio-inline width-text2" style="width: 100px;color: green;"> ค่าครองชีพ </label>

                        <input for="checkbox5" type="float" style="width: 50px;height: 30px;text-align: center;" class="form-control-card" id="Price5" name="Price5" required="required" value="0" disabled>
                        <!-- <label class="radio-inline"> บาท </label> -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox6" type="checkbox">
                        <label for="checkbox6" class="radio-inline width-text2" style="width: 100px;color: green;"> ค่าแรงตกงวดก่อน </label>

                        <input for="checkbox6" type="float" style="width: 50px;height: 30px;text-align: center;" class="form-control-card" id="Price6" name="Price6" required="required" value="0" disabled>
                        <!-- <label class="radio-inline"> บาท </label> -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox7" type="checkbox">
                        <label for="checkbox7" class="radio-inline width-text2" style="width: 100px;color: green;"> ค่าล่วงเวลาพิเศษ </label>

                        <input for="checkbox7" type="float" style="width: 50px;height: 30px;text-align: center;" class="form-control-card" id="Price7" name="Price7" required="required" value="0" disabled>
                        <!-- <label class="radio-inline"> บาท </label> -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox8" type="checkbox">
                        <label for="checkbox8" class="radio-inline width-text2" id="name2" style="width: 100px;color: green;"> รายรับอื่นๆ </label>
                        
                        <input for="checkbox8" type="float" style="width: 50px;height: 30px;text-align: center;" class="form-control-card" id="Price8" name="Price8" required="required" value="0" disabled>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <br>
                <div class="form-group" id="button">
                    <label class="control-label" for="status">&nbsp;</label>
                    <input type="hidden" name="Pos_ID" id="Pos_ID" value="<?php echo $Pos_ID; ?>" />
                    <button type="submit" class="btn btn-success demo1">เพิ่มข้อมูล</button>
                </div>

                <br>
                <div class="form-group">
                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="choise" id="zero" value="0" <?php if($_GET['Status'] == '' || $_GET['Status'] == '0') echo 'checked';?> >
                        <label for="inlineRadio1"> รอคำนวณ </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="choise" id="one" value="1" <?php if($_GET['Status'] == '1') echo 'checked';?> >
                        <label for="inlineRadio1"> คำนวณแล้ว </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" style="color: green;">รับ</label>
                    <input type="text" id="revenues" style="width: 50px;color: green;" disabled>
                    <label class="control-label" style="color: red;">จ่าย</label>
                    <input type="text" id="expenditures" style="width: 50px;color: red;" disabled>
                </div>
            </div>
            <!-- <div class="col-sm-1"></div> -->
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
				<input type="text" class="form-control input-sm m-b-xs" id="filter" style="background-color: #D3D3D3;" placeholder="ค้นหาข้อมูล">
                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="20" data-filter=#filter>
                    <thead>
                        <tr>
                            <th style="text-align: center;">ชื่อ</th>
                            <th style="text-align: center;">ชุด</th>
                            <th style="text-align: center;">ตำแหน่ง</th>
                            <th style="text-align: center;">รายการ</th>
                            <th style="text-align: center;">จำนวน</th>
                            <th style="text-align: center;">ราคา</th>
                            <th style="text-align: center;">งวด</th>
                            <th style="text-align: center;">สถานะ</th>
                            <th style="text-align: center;">วันที่เพิ่ม</th>
                            <th style="text-align: center;">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i=1;$i<=$num_search;$i++) {
                                $row_search = mssql_fetch_array($query_search);

								if($row_search['Titel'] == 'Mr') {
									$Titels = 'นาย ';
								}
								if($row_search['Titel'] == 'Ms') {
									$Titels = 'นางสาว ';
								}
								if($row_search['Titel'] == 'Mrs') {
									$Titels = 'นาง ';
								}

                                $name = iconv('TIS-620', 'UTF-8', $row_search['Em_Fullname']);
                                $last = iconv('TIS-620', 'UTF-8', $row_search['Em_Lastname']);
                                $site = iconv('TIS-620', 'UTF-8', $row_search['Site_Name']);
                                $group = iconv('TIS-620', 'UTF-8', $row_search['Group_Name']);
                                $position = iconv('TIS-620', 'UTF-8', $row_search['Pos_Name']);
                                $num = $row_search['List_Num'];
                                $price = $row_search['List_Price'];
                                $week = $row_search['Week'];
                                $itemName = iconv('TIS-620', 'UTF-8', $row_search['Item_Name']);
                                $status = $row_search['Item_Status'];
                                $List_Status = iconv('TIS-620', 'UTF-8', $row_search['List_Status']);
                                if($row_search['List_Status'] == '0') {
                                    $List_Status = 'รอการคำนวณ';
									$delete = '0';
                                } else {
                                    $List_Status = 'คำนวณแล้ว';
									$delete = '1';
                                }
                                $Remark = iconv('TIS-620', 'UTF-8', $row_search['Remark']);

                                /*$Cre = new datetime($row_search['LCreate']);
                                $Cre = $Cre->format('d-m-Y H:i:s');*/
                        ?>
                        <tr>
                            <td><?php echo $Titels.''.$name.''.$last; ?></td>
                            <td style=""><?php echo $group; ?></td>
                            <td style=""><?php echo $position; ?></td>
                            <td style=""><?php echo $itemName; ?></td>
                            <td style="text-align: center;"><?php echo $num; ?></td>
                            <td style="text-align: center;"><?php echo $price; ?></td>
                            <td style="text-align: center;"><?php echo $week; ?></td>
                            <td style="text-align: center;"><?php echo $List_Status;?></td>
                            <td style="text-align: center;"><?php echo $row_search['LCreate'];?></td>
							<?php if($delete == '0') { ?>
								<td style="text-align: center;"><a href="func/ExpensesDelete.php?List_ID=<?php echo $row_search['List_ID']; ?>" >ลบ</a></td>
							<?php } else { ?>
								<td style="text-align: center;"></td>
							<?php } ?>
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
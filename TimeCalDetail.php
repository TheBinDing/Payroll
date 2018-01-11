<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <!-- <form name="form1" method="post" action="func/CalculateTime.php"> -->
                <form name="frmMain" method="post" action="func/CalculateTime.php" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <input name="btnSubmit" type="submit" value="คำนวณเวลา" class="btn btn-w-m btn-success demo1" style="margin-bottom: 5px;">
                    <table class="table table-striped table-bordered table-hover " id="editable">
                        <thead>
                            <tr>
                                <th style="text-align: center;">วันที่</th>
								<th style="text-align: center;">ชื่อ</th>
                                <th style="text-align: center;">เข้างานเช้า</th>
                                <th style="text-align: center;">ออกงานเช้า</th>
                                <th style="text-align: center;">เข้างานบ่าย</th>
                                <th style="text-align: center;">ออกงานบ่าย</th>
                                <th style="text-align: center;">เข้าOT1.5</th>
                                <th style="text-align: center;">ออกOT1.5</th>
                                <th style="text-align: center;">เข้าOT2</th>
                                <th style="text-align: center;">ออกOT2</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            for($i=1;$i<=$num;$i++)
                              {
                                    $row = mssql_fetch_array($query);
									
									if($row['Titel'] == 'Mr') {
										$Titel = 'นาย ';
									}
									if($row['Titel'] == 'Ms') {
										$Titel = 'นางสาว ';
									}
									if($row['Titel'] == 'Mrs') {
										$Titel = 'นาง ';
									}

                                    $name = $Titel.' '.iconv('TIS-620','UTF-8',$row['Fullname']).' '.iconv('TIS-620','UTF-8',$row['Lastname']);
                                    $date = $row['LogTime'];
                                    $CK_in = $row['CK_in'];
                                    $Ck_Out1 = $row['Ck_Out1'];
                                    $CK_in2 = $row['CK_in2'];
                                    $Ck_Out2 = $row['Ck_Out2'];
                                    $CKOT_in1 = $row['CKOT_in1'];
                                    $CKOT_Out1 = $row['CKOT_Out1'];
                                    $CKOT_in2 = $row['CKOT_in2'];
                                    $CKOT_Out2 = $row['CKOT_Out2'];
                                    $FingerName = iconv('TIS-620','UTF-8',$row['FingerName']);
                                    $Site = iconv('TIS-620','UTF-8',$row['Site_Name']);
                                    $TimePlan = iconv('TIS-620','UTF-8',$row['TimePlan_Name']);
                        ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $date; ?></td>
								<td style="text-align: center;"><?php echo $name; ?></td>
                                <td style="text-align: center;"><?php echo $CK_in; ?></td>
                                <td style="text-align: center;"><?php echo $Ck_Out1; ?></td>
                                <td style="text-align: center;"><?php echo $CK_in2; ?></td>
                                <td style="text-align: center;"><?php echo $Ck_Out2; ?></td>
                                <td style="text-align: center;"><?php echo $CKOT_in1; ?></td>
                                <td style="text-align: center;"><?php echo $CKOT_Out1; ?></td>
                                <td style="text-align: center;"><?php echo $CKOT_in2; ?></td>
                                <td style="text-align: center;"><?php echo $CKOT_Out2; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </form>

            </div>
        </div>
    </div>
</div>
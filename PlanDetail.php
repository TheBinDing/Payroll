<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="20">
                    <thead>
                        <tr>
                            <th style="text-align: center;">โครงการ</th>
                            <th style="text-align: center;" data-hide="all">ชื่อช่วงทำงาน</th>
                            <th style="text-align: center;" data-hide="all">ทำงานปกติ</th>
                            <th style="text-align: center;" data-hide="all">สายได้</th>
                            <th style="text-align: center;width: 80px;">เข้างานเช้า</th>
                            <th style="text-align: center;width: 85px;">ออกงานเช้า</th>
                            <th style="text-align: center;width: 85px;">เข้างานบ่าย</th>
                            <th style="text-align: center;width: 85px;">ออกงานบ่าย</th>
                            <th style="text-align: center;width: 80px;">เข้าOT1.5</th>
                            <th style="text-align: center;width: 80px;">ออกOT1.5</th>
                            <th style="text-align: center;width: 80px;">เข้าOT2</th>
                            <th style="text-align: center;width: 80px;">ออกOT2</th>
                            <th style="text-align: center;">ช่วงแผนเวลา</th>
                            <th style="text-align: center;" data-hide="all">สถานะ</th>
                            <th style="text-align: center;">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        for($i=1;$i<=$num;$i++)
                          {
                                $row = mssql_fetch_array($query);

                                $Start = new datetime($row['StartDate']);
                                $Start = $Start->format('d-m-Y');
                                $End = new datetime($row['EndDate']);
                                $End = $End->format('d-m-Y');

                                $Status = iconv('TIS-620', 'UTF-8', $row['Status']);
                    ?>
                        <tr>
                            <td style="width: 345px;"><?php echo iconv('TIS-620', 'UTF-8', $row['Site_Name']); ?></td>
                            <td style="text-align: center;"><?php echo iconv('TIS-620', 'UTF-8', $row['Name']); ?></td>
                            <td style="text-align: center;"><?php echo $row['Hour']; ?></td>
                            <td style="text-align: center;"><?php echo $row['Late']; ?></td>
                            <td style="text-align: center;width: 70px;"><?php echo $row['CK_in']; ?></td>
                            <td style="text-align: center;width: 70px;"><?php echo $row['Ck_Out1']; ?></td>
                            <td style="text-align: center;width: 70px;"><?php echo $row['CK_in2']; ?></td>
                            <td style="text-align: center;width: 70px;"><?php echo $row['Ck_Out2']; ?></td>
                            <td style="text-align: center;width: 70px;"><?php echo $row['CKOT_in1']; ?></td>
                            <td style="text-align: center;width: 70px;"><?php echo $row['CKOT_Out1']; ?></td>
                            <td style="text-align: center;width: 70px;"><?php echo $row['CKOT_in2']; ?></td>
                            <td style="text-align: center;width: 70px;"><?php echo $row['CKOT_Out2']; ?></td>
                            <td style="text-align: center;width: 260px;">
                                <?php if(empty($row['StartDate']) && empty($row['EndDate'])){ echo '∞'; } else { echo $Start.' ถึง '.$End;} ?>
                            </td>
                            <td style="text-align: center;">
                            <?php if($Status == '1') { ?><i class="fa fa-circle text-navy"></i><?php } else { ?><i class="fa fa-circle text-danger"></i><?php } ?>
                            </td>
                            <td style="text-align: center;">
                                <div class="btn-group">
                                    <?php if(iconv('TIS-620', 'UTF-8', $row['Name']) != 'Default') { ?>
                                    <a href="Plan.php?TimePlan_ID=<?php echo $row['ID'];?>" class="btn-white btn btn-xs" role="button">แก้ไข</a>
                                    <?php } ?>
                                </div>
                            </td>
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
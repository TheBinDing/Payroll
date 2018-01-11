<div class="ibox-content m-b-sm border-bottom">
    <div class="row">
        <form action="PlanPeople.php" method="POST">
            <!-- <div class="col-sm-1 m-b-xs"></div> -->
            <?php if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') { ?>
            <div class="col-sm-4 m-b-xs">
                <?php
                    $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
                    $query_site = mssql_query($sql_site);
                    $row_site = mssql_fetch_array($query_site);
                ?>
                <select class="input-sm form-control input-s-sm inline" name="Site_ID" id="Site_ID" style="height: 30px;width: 300px;" required="required">
                    <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                </select>
            </div>
            <?php } else { ?>
            <div class="col-sm-4 m-b-xs">
                <?php
                    $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '". $site ."' ";
                    $query_site = mssql_query($sql_site);
                    $num_site = mssql_num_rows($query_site);
                ?>
                <select class="input-sm form-control input-s-sm inline" name="Site_ID" id="Site_ID" style="height: 30px;width: 300px;" required="required">
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
            <div class="col-sm-2 m-b-xs">
                <?php
                    $sql_pos = "SELECT Pos_ID, CAST(Pos_Name AS Text) AS Pos_Name FROM [HRP].[dbo].[Position] WHERE Pos_ID != '". $position ."' ";
                    $query_pos = mssql_query($sql_pos);
                    $num_pos = mssql_num_rows($query_pos);
                ?>
                <select class="input-sm form-control input-s-sm inline" name="Position" id="Position">
                    <?php if($position != '') {?>
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
            <div class="col-sm-2 m-b-xs">
                <?php
                    $sql_group = "SELECT Group_ID, CAST(Group_Name AS Text) AS Group_Name FROM [HRP].[dbo].[Group] WHERE Group_ID != '". $group ."' AND Site_ID = '". $_SESSION['SuperSite'] ."' ";
                    $query_group = mssql_query($sql_group);
                    $num_group = mssql_num_rows($query_group);
                ?>
                <select class="input-sm form-control input-s-sm inline" name="Group" id="Group">
                    <?php if($_SESSION['planPeopleGroup'] != '') {?>
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
            <div class="col-sm-3 m-b-xs">
                <?php
                    $whereT = ($_SESSION['SuperSite'] != '1') ? " AND Site_ID = '".$_SESSION['SuperSite']."' " : "";
                    $sql_time = "SELECT TimePlan_ID, CAST(TimePlan_Name AS Text) AS TimePlan_Name FROM [HRP].[dbo].[PlanTime] WHERE TimePlan_ID != '". $plan ."' AND TimePlan_ID != '1' AND TimePlan_Status = '1' $whereT ";
                    $query_time = mssql_query($sql_time);
                    $num_time = mssql_num_rows($query_time);
                ?>
                <select class="input-sm form-control input-s-sm inline" name="Plan" id="Plan" style="height: 30px;">
                    <?php if($plan == '') { ?>
                        <option value=""><?php echo '-- เลือกแผน --'; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $r_t['TimePlan_ID']; ?>"><?php echo iconv('TIS-620','UTF-8',$r_t['TimePlan_Name']); ?></option>
                    <?php } ?>
                    <?php
                    for($i=1;$i<=$num_time;$i++)
                    {
                        $row_time = mssql_fetch_array($query_time);
                    ?>
                        <option value="<?php echo $row_time['TimePlan_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_time['TimePlan_Name']);?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-1 m-b-xs">
                <input type="hidden" name="Check" id="Check" value="<?php echo '1'; ?>" />
                <button class="btn btn-success" id="Search" type="submit"><strong>ค้นหา</strong></button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">

            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-3 m-b-xs">
                        <div id="ADD" style="display: none;">
                            <label class="radio-inline" style="width: 120px;font-size: 20px;">เพิ่มรายชื่อ</label>
                            <a data-toggle="modal" data-target="#modal-form" class="open-sendnames glyphicon glyphicon-plus-sign" data-plan="<?php echo $plan; ?>"></a>
                        </div>
                    </div>
                    <div id="modal-form" class="modal inmodal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="width: 810px;">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php require('func/PeoplePlan.php'); ?>
                                            <!-- <form action="func/PeoplePlanSave.php" method="POST"> -->
                                            <form name="frmMain" method="post" action="func/PeoplePlanSave.php" target="iframe_target">
                                            <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                                <!-- <div class="modal-header">
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">
                                                    </div>
                                                </div> -->
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover " id="editable">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center;">#</th>
                                                                <th style="text-align: center;">ชื่อ-สกุล</th>
                                                                <th style="text-align: center;">โครงการ</th>
                                                                <th style="text-align: center;">ตำแหน่ง</th>
                                                                <th style="text-align: center;">ชุด</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                for($p=1;$p<=$num_pe;$p++) {
                                                                    $row_pe = mssql_fetch_array($query_pe);

                                                                    $Name_p = iconv('TIS-620', 'UTF-8', $row_pe['Fullname']);
                                                                    $Last_p = iconv('TIS-620', 'UTF-8', $row_pe['Lastname']);
                                                                    $Site_p = iconv('TIS-620', 'UTF-8', $row_pe['Site_Name']);
                                                                    $Pos_p = iconv('TIS-620', 'UTF-8', $row_pe['Pos_Name']);
                                                                    $Group_p = iconv('TIS-620', 'UTF-8', $row_pe['Group_Name']);
                                                                    $TimePlan = $row_pe['TimePlan'];

                                                                    if($row_pe['Titel'] == 'Mr') {
                                                                        $Titel_p = 'นาย';
                                                                    }
                                                                    if($row_pe['Titel'] == 'Mrs') {
                                                                        $Titel_p = 'นาง';
                                                                    }
                                                                    if($row_pe['Titel'] == 'Ms') {
                                                                        $Titel_p = 'นางสาว';
                                                                    }

                                                                    if($TimePlan != '' && $TimePlan != '1'){
                                                                        $Titel_p = "<span style=\"color : #20B2AA;\">$Titel_p</span>";
                                                                        $Name_p = "<span style=\"color : #20B2AA;\">$Name_p</span>";
                                                                        $Last_p = "<span style=\"color : #20B2AA;\">$Last_p</span>";
                                                                        $Site_p = "<span style=\"color : #20B2AA;\">$Site_p</span>";
                                                                        $Pos_p = "<span style=\"color : #20B2AA;\">$Pos_p</span>";
                                                                        $Group_p = "<span style=\"color : #20B2AA;\">$Group_p</span>";
                                                                    }
                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center;"><input type="checkbox" class="i-checks" name="input[]" value="<?php echo $row_pe['Em_ID'];?>"></td>
                                                                <td style="text-align: center;"><?php echo $Titel_p.' '.$Name_p.' '.$Last_p;?></td>
                                                                <td style="text-align: center;"><?php echo $Site_p;?></td>
                                                                <td style="text-align: center;"><?php echo $Pos_p;?></td>
                                                                <td style="text-align: center;"><?php echo $Group_p;?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="TimePlan" id="TimePlan" value="<?php echo $plan; ?>" />
                                                    <input type="hidden" name="Num" id="Num" value="<?php echo $num; ?>" />
                                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" id="SumbitPlan" type="submit"><strong>บันทึก</strong></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #### -->
                </div>
                <div class="table-responsive">
                    <!-- <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10"> -->
                    <table class="table table-striped table-bordered table-hover " id="editable">
                        <thead>
                            <tr>
                                <th style="text-align: center;">ชื่อ-สกุล</th>
                                <th style="text-align: center;">โครงการ</th>
                                <th style="text-align: center;">ช่วงทำงาน</th>
                                <th style="text-align: center;">ระยะเวลา</th>
                                <th style="text-align: center;">ลบแผนเวลา</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            for($i=1;$i<=$num;$i++)
                              {
                                    $row = mssql_fetch_array($query);

                                    $Name = iconv('TIS-620', 'UTF-8', $row['Fullname']);
                                    $Last = iconv('TIS-620', 'UTF-8', $row['Lastname']);
                                    $Site = iconv('TIS-620', 'UTF-8', $row['Site_Name']);
                                    $Plan = iconv('TIS-620', 'UTF-8', $row['TimePlan_Name']);

                                    $Start = new datetime($row['TimePlan_StartDate']);
                                    $Start = $Start->format('d-m-Y');
                                    $End = new datetime($row['TimePlan_EndDate']);
                                    $End = $End->format('d-m-Y');

                                    if($row['Titel'] == 'Mr') {
                                        $Titel = 'นาย';
                                    }
                                    if($row['Titel'] == 'Mrs') {
                                        $Titel = 'นาง';
                                    }
                                    if($row['Titel'] == 'Ms') {
                                        $Titel = 'นางสาว';
                                    }
                        ?>
                            <tr>
                                <td><?php echo $Titel.' '.$Name.' '.$Last; ?></td>
                                <td><?php echo $Site; ?></td>
                                <td><?php echo $Plan; ?></td>
                                <td style="text-align: center;"><?php echo $Start.'-'.$End; ?></td>
                                <td style="text-align: center;"><a href="func/DeleteTimePlan.php?Em_ID=<?php echo $row['Em_ID']; ?>&Plan=<?php echo $plan; ?>" >ลบ</a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
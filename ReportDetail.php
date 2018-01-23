<div class="ibox-content m-b-sm border-bottom">
    <div class="row">
        <!-- <form action="func/test2.php" method="post"> -->
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <div class="form-group">
                    <?php if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') { ?>
                        <?php
                            $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
                            $query_site = mssql_query($sql_site);
                            $row_site = mssql_fetch_array($query_site);
                        ?>
                        <label class="radio-inline width-text1" style="width: 100px;">โครงการ</label>
                        <select class="form-control-normal" name="Site" id="Site" style="width: 300px;height: 30px;" required="required">
                            <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                        </select>
                    <?php } else { ?>
                        <?php
                            $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '".$row['Site_ID']."' ";
                            $query_site = mssql_query($sql_site);
                            $num_site = mssql_num_rows($query_site);
                        ?>
                        <label class="radio-inline width-text1"> โครงการ </label>
                        <select class="form-control chosen-select" name="Site" id="Site" required="required" style="width: 300px;height: 30px;">
                            <!-- <option value=""></option> -->
                            <?php
                            for($i=1;$i<=$num_site;$i++)
                            {
                                $row_site = mssql_fetch_array($query_site);
                            ?>
                                <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>

                    <?php
                        $sql_pos = "SELECT Pos_ID, CAST(Pos_Name AS Text) AS Pos_Name FROM [HRP].[dbo].[Position] WHERE Pos_ID != '".$row['Pos_ID']."' ";
                        $query_pos = mssql_query($sql_pos);
                        $num_pos = mssql_num_rows($query_pos);
                    ?>
                    <label class="radio-inline width-text1"> ตำแหน่ง </label>
                    <select class="form-control" name="Position" id="Position" style="width: 300px;height: 30px;">
                        <option value="0"></option>
                        <?php
                        for($j=1;$j<=$num_pos;$j++)
                        {
                            $row_pos = mssql_fetch_array($query_pos);
                        ?>
                            <option value="<?php echo $row_pos['Pos_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_pos['Pos_Name']);?></option>
                        <?php } ?>
                    </select>

                    <?php
                        $sql_group = "SELECT Group_ID, CAST(Group_Name AS Text) AS Group_Name FROM [HRP].[dbo].[Group] WHERE Group_ID != '".$row['Group_ID']."' ";
                        $query_group = mssql_query($sql_group);
                        $num_group = mssql_num_rows($query_group);
                    ?>
                    <label class="radio-inline width-text1"> ชุด/สังกัด </label>
                    <select class="form-control" name="Group" id="Group" style="width: 300px;height: 30px;">
                        <option value="0"></option>
                        <?php
                        for($k=1;$k<=$num_group;$k++)
                        {
                            $row_group = mssql_fetch_array($query_group);
                        ?>
                            <option value="<?php echo $row_group['Group_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_group['Group_Name']);?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <?php
                        $sql_y = " SELECT MT_Year AS Year FROM [HRP].[dbo].[MoneyTotal] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' GROUP BY MT_Year ORDER BY MT_Year ";
                        $query_y = mssql_query($sql_y);
                        $num_y = mssql_num_rows($query_y);
                    ?>
                    <label class="radio-inline width-text1">ปี</label>
                    <select class="form-control" name="Year" id="Year" style="width: 300px;height: 30px;" onchange="SelectYear()" required>
					<option value=""><span>โปรดเลือกปี</span></option>
                    <?php
                        for($l=1;$l<=$num_y;$l++) {
                            $row_y = mssql_fetch_array($query_y);
                    ?>
                        <option value="<?php echo $row_y['Year'];?>"><?php echo $row_y['Year'];?></option>
                    <?php } ?>
                    </select>
				</div>
                <div class="form-group">
                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="choise" id="zero" value="0" checked >
                        <label for="inlineRadio1"> งวด </label>
                    </div>

                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="choise" id="one" value="1" >
                        <label for="inlineRadio1"> เดือน </label>
                    </div>
                </div>
				<div class="form-group" id="ChiosePeriod">
                    <label class="radio-inline width-text1">งวดที่</label>
                    <select class="form-control" name="Period" id="Period" style="width: 300px;height: 30px;">
                        <option value=""></option>
                    </select>
                </div>
				<div class="form-group" id="ChioseMonth" style="display: none;">
                    <label class="radio-inline width-text1">เดือน</label>
                    <select class="form-control" name="Month" id="Month" style="width: 300px;height: 30px;">
                        <option value="1">มกราคม</option>
                        <option value="2">กุมภาพันธ์</option>
                        <option value="3">มีนาคม</option>
                        <option value="4">เมษายน</option>
                        <option value="5">พฤษภาคม</option>
                        <option value="6">มิถุนายม</option>
                        <option value="7">กรกฎาคม</option>
                        <option value="8">สิงหาคม</option>
                        <option value="9">กันยายน</option>
                        <option value="10">ตุลาคม</option>
                        <option value="11">พฤศจิกายน</option>
                        <option value="12">ธันวาคม</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
            </div>
        <!-- </form> -->
    </div>
</div>
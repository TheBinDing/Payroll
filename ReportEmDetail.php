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
                        <select class="form-control-normal" name="Site" id="Site" style="width: 300px;height: 30px;" required="required" onclick="SelectGroup()">
                            <option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
                        </select>
                    <?php } else { ?>
                        <?php
                            $sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '".$row['Site_ID']."' ";
                            $query_site = mssql_query($sql_site);
                            $num_site = mssql_num_rows($query_site);
                        ?>
                        <label class="radio-inline width-text1"> โครงการ </label>
                        <select class="form-control chosen-select" name="Site" id="Site" required="required" style="width: 300px;height: 30px;" onclick="SelectGroup()">
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
                        <option value=""></option>
                        <?php
                        for($j=1;$j<=$num_pos;$j++)
                        {
                            $row_pos = mssql_fetch_array($query_pos);
                        ?>
                            <option value="<?php echo $row_pos['Pos_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_pos['Pos_Name']);?></option>
                        <?php } ?>
                    </select>

                    <?php
                    ?>
                    <label class="radio-inline width-text1"> ชุด/สังกัด </label>
                    <select class="form-control" name="Group" id="Group" style="width: 300px;height: 30px;">
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4" id="data_5">
                <label class="radio-inline width-text1">ช่วงเวลา</label>
                <?php
                  $Start = new datetime($_SESSION['SubStart']);
                  $Start = $Start->format('d-m-Y');
                  $End = new datetime($_SESSION['SubEnd']);
                  $End = $End->format('d-m-Y');
                ?>
                <div class="input-daterange input-group" data-date="<?=date('d-m-Y');?>" data-date-format="dd-mm-yyyy" style="padding-left: 20px;">
                    <input type="text" class="input-sm form-control" id="start" name="start" value="<?php if($Start != ''){ echo $Start; }else{ echo date('d-m-Y'); } ?>"/>
                    <span class="input-group-addon"> ถึง </span>
                    <input type="text" class="input-sm form-control" id="end" name="end" value="<?php if($End != ''){ echo $End; }else{ echo date('d-m-Y'); } ?>" />
                </div>
                <br>
                <div class="form-group">
                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="choise" id="zero" value="W" >
                        <label for="inlineRadio1"> ทำงาน </label>
                    </div>

                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="choise" id="one" value="O" >
                        <label for="inlineRadio1"> ออก </label>
                    </div>

                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="choise" id="two" value="B" >
                        <label for="inlineRadio1"> Blacklist </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
            </div>
        <!-- </form> -->
    </div>
</div>
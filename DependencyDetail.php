<div class="ibox-content">
    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="100">
        <thead>
            <tr>
                <th style="text-align: center;">ลำดับ</th>
                <th style="text-align: center;">ชุด</th>
                <th style="text-align: center;">แก้ไขข้อมูล</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i=1;$i<=$num_search;$i++) {
                    $row_search = mssql_fetch_array($query_search);

                    $ID = iconv('TIS-620','UTF-8',$row_search['Group_ID']);
                    $Site_ID = iconv('TIS-620','UTF-8',$row_search['Site_ID']);
                    $name = iconv('TIS-620','UTF-8',$row_search['Group_Name']);
                    $site = iconv('TIS-620','UTF-8',$row_search['Site_Name']);
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i; ?></td>
                <td><?php echo $name; ?></td>
                <td style="text-align: center;">
                    <div class="btn-group">
                        <a data-toggle="modal" data-target="#myModals" class="open-sendname btn-white btn btn-xs" role="button" data-id="<?=$name;?>" data-a="<?=$Site_ID;?>" data-b="<?=$ID;?>" data-c="<?=$site;?>">แก้ไข</a>
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
    <div class="modal inmodal" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <h2>เพิ่มชุด/สังกัด</h2>
                </div>                    
                <!-- <form name="frmMain" method="post" action="func/DependencySave.php"> -->
                <form name="frmMain" method="post" action="func/DependencySave.php" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">ชื่อชุด/สังกัด</label>
                            <input type="text" value="<?php echo $Group_Name; ?>" id="Group_Name" name="Group_Name" required="required" class="form-control" style="height: 30px;">
                        </div>
                        <?php if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') { ?>
                            <div class="form-group">
                                <label class="control-label">โครงการ</label>
                                <?php
                                    $sql_site = " SELECT Site_ID, CAST(Site_Name AS text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '".$_SESSION['SuperSite']."' ";

                                    $query_site = mssql_query($sql_site);
                                    $num_site = mssql_num_rows($query_site);
                                    $row_site = mssql_fetch_array($query_site);
                                ?>
                                <select class="form-control" name="Site_ID" id="Site_ID" style="height: 30px;">
                                    <option value="<?php echo $row_site['Site_ID']; ?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']); ?></option>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class="form-group">
                                <label class="control-label">โครงการ</label>
                                <?php
                                    $sql_site = " SELECT Site_ID, CAST(Site_Name AS text) AS Site_Name FROM [HRP].[dbo].[Sites] ";

                                    $query_site = mssql_query($sql_site);
                                    $num_site = mssql_num_rows($query_site);
                                ?>
                                <select class="form-control" name="Site_ID" id="Site_ID" style="height: 30px;">
                                    <?php
                                        for($i=1;$i<=$num_site;$i++) {
                                            $row_site = mssql_fetch_array($query_site);

                                            $ID = $row_site['Site_ID'];
                                            $Name = iconv('TIS-620','UTF-8',$row_site['Site_Name']);
                                    ?>
                                        <option value="<?php echo $ID ?>"><?php echo $Name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success SubmitData">เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="myModals" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <h2>แก้ไขชุด/สังกัด</h2>
                </div>                    
                <!-- <form name="frmMain" method="post" action="func/DependencySave.php"> -->
                <form name="frmMain" method="post" action="func/DependencySave.php" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">ชื่อชุด/สังกัด</label>
                            <input type="text" value="" id="Group_Names" name="Group_Name" required="required" class="form-control" style="height: 30px;">
                        </div>
                        <div class="form-group">
                            <label class="control-label">โครงการ</label>
                            <?php
                                $sql_site = " SELECT Site_ID, CAST(Site_Name AS text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '".$_SESSION['SuperSite']."' ";

                                $query_site = mssql_query($sql_site);
                                $num_site = mssql_num_rows($query_site);
                                $row_site = mssql_fetch_array($query_site);
                            ?>
                            <select class="form-control" name="Site_ID" id="Site_IDs" style="height: 30px;">
                                <option value="<?php echo $row_site['Site_ID']; ?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="Group_ID" id="Group_IDs" value="<?php echo $Group_ID; ?>" />
                        <button class="btn btn-success SubmitData">แก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
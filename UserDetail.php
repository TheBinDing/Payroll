<div class="ibox-content">
    <table class="table table-striped table-bordered table-hover " id="editable">
        <thead>
            <tr>
                <th style="text-align: center;">ลำดับ</th>
                <th style="text-align: center;">สถานะ</th>
                <th style="text-align: center;">ชื่อผู้ใช้ระบบ</th>
                <th style="text-align: center;">สิทธิ์การใช้งาน</th>
                <th style="text-align: center;">โครงการที่ดูแล</th>
                <th style="text-align: center;">อีเมล์</th>
                <th style="text-align: center;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i=1;$i<=$num_search;$i++) {
                    $row_search = mssql_fetch_array($query_search);

                    $id = $row_search['id'];
                    $name = iconv('TIS-620','UTF-8',$row_search['users']);
                    $rule = iconv('TIS-620','UTF-8',$row_search['rules']);
                    $email = iconv('TIS-620','UTF-8',$row_search['email']);
                    $status = $row_search['status'];
                    $site = '';

                    $s = explode(',', $row_search['m_site']);

                    foreach ($s as $key => $value) {
                        $site_search = "SELECT
                                            Site_ID,
                                            CAST(Site_Name as Text) as Site_Name,
                                            Site_Status
                                        FROM
                                            [HRP].[dbo].[Sites] 
                                        WHERE
                                            Site_Status = '1'
                                            AND Site_ID = '". $value ."' ";
                        $querys = mssql_query($site_search);
                        $rows = mssql_fetch_array($querys);

                        if($key == 0) {
                            $site = iconv('TIS-620', 'UTF-8', $rows['Site_Name']);
                        } else {
                            $site = $site.'<br>'.iconv('TIS-620', 'UTF-8', $rows['Site_Name']);
                        }
                    }

                    if($rule == 1) {
                        $r_name = 'Admin';
                    }
                    if($rule == 2) {
                        $r_name = 'HR';
                    }
                    if($rule == 3) {
                        $r_name = 'Personal';
                    }
                    if($rule == 4) {
                        $r_name = 'Report';
                    }
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i; ?></td>
                <td style="text-align: center;"><?php if($status == '1') { ?><i class="fa fa-circle text-navy"></i><?php } else { ?><i class="fa fa-circle text-danger"></i><?php } ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $r_name; ?></td>
                <td><?php echo $site; ?></td>
                <td><?php echo $email; ?></td>
                <td style="text-align: center;">
                    <a href="registerEdit.php?Em_ID=<?php echo $id; ?>" class="btn-white btn btn-xs" role="button">แก้ไข</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
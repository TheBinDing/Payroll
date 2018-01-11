<?php
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>รายชื่อผู้ใช้งานระบบทั้งหมด</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <?php
                $personal = "SELECT
                            CAST(m_name as Text) as Name,
                            CAST(m_site as Text) as Site,
                            m_status
                        FROM
                            [HRP].[dbo].[Users]
                        WHERE
                            m_status = '1'
                            AND m_id != '1' AND m_id != '2' AND m_id != '3' AND m_id != '29'
                            AND m_site != '1'
                            AND m_status = '1' ";
            $query_p = mssql_query($personal);
            $num_p = mssql_num_rows($query_p);

            for($i=1;$i<=$num_p;$i++) {
                $row_p = mssql_fetch_array($query_p);

                $Personal = $row_p['Name'];

                $s = explode(',', $row_p['Site']);

                foreach ($s as $key => $value) {
                    $site = "SELECT
                            CAST(s.Sites_Name as Text) as NameSite
                        FROM
                            [HRP].[dbo].[Site] s inner join
                            [HRP].[dbo].[Sites] ss on s.Sites_ID = ss.Sites_ID
                        WHERE
                            ss.Site_ID = '". $value ."'
                        ORDER BY
                            s.Sites_Name ASC ";

                    $querySite = mssql_query($site);
                    $rowSite = mssql_fetch_assoc($querySite);
                }
                // $ex = explode('(', $rowSite['NameSite']);

                if($i == 1) {
            ?>
            <div class="col-xs-6">
                <h3 class="stats-label">โครงการที่ดูแล</h3>
                <h5><?php echo iconv('TIS-620', 'UTF-8', $rowSite['NameSite']); ?></h5>
            </div>

            <div class="col-xs-6">
                <h3 class="stats-label">ชื่อ-นามสกุล</h3>
                <h5><?php echo iconv('TIS-620', 'UTF-8', $Personal); ?></h5>
            </div>
            <?php } else { ?>
            <div class="col-xs-6">
                <h5><?php echo iconv('TIS-620', 'UTF-8', $rowSite['NameSite']); ?></h5>
            </div>

            <div class="col-xs-6">
                <h5><?php echo iconv('TIS-620', 'UTF-8', $Personal); ?></h5>
            </div>
            <?php } } ?>
            <!-- <div class="col-xs-6">
                <h5>Atara Mall</h5>
            </div>

            <div class="col-xs-6">
                <h5>WIPAWAN</h5>
            </div> -->
        </div>
    </div>
</div>
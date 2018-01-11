<table class="table">
    <thead>
           <tr>
            <th>ชื่อ-สกุล</th>
            <th>วันที่</th>
        </tr>
    </thead>
    <tbody>
        <?php
            for($i=1;$i<=$num;$i++)
            {
                $row = mssql_fetch_array($query);
        ?>
        <tr>
            <th scope="row">
                <?php echo iconv('TIS-620','UTF-8',$row['Fullname']); ?>
            </th>
            <th scope="row"><?=date('d-m-Y');?></th>
        </tr>
        <?php } ?>
    </tbody>
    <ul class="pagination"></ul>
</table>
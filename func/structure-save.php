<?php
	@session_start();
    include("../inc/connect.php");
    $Name = iconv('UTF-8','TIS-620', $_POST['Site_Name']);
    $Status = $_POST['Status'];
    $Site_ID = $_POST['Site_ID'];

    $date = date('Y-m-d H:i:s');

    $sql_click = "SELECT Site_ID FROM [HRP].[dbo].[Site] WHERE Site_ID = '". $Site_ID ."' ";
    $query = mssql_query($sql_click);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    if($num != 0) {
        $sql_edit = "UPDATE [HRP].[dbo].[Site] SET
                    Site_Name = '". $Name ."',
                    Status_ID = '". $Status ."'
                    WHERE Site_ID = '". $Site_ID ."' ";

        mssql_query($sql_edit);
        exit("<script>window.location='structure.php';</script>");
    } else {
        $sql_insert = "INSERT INTO [HRP].[dbo].[Site] (Site_Name, Status_ID) VALUES ('$Name', '$Status')";

        mssql_query($sql_insert);
        exit("<script>window.location='structure.php';</script>");
    }
?>
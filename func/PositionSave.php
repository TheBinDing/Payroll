<?php
	@session_start();
    require("../inc/connect.php");
    $Name = iconv('UTF-8','TIS-620', $_POST['Pos_Name']);
    $Pos_ID = $_POST['Pos_ID'];
    $checkID = $_POST['ID'];

    $check = "SELECT Pos_ID FROM [HRP].[dbo].[Position] WHERE Pos_ID = '".$Pos_ID."' ";
    $query = mssql_query($check);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    // echo $checkID.'-'.$num;

    
    if($num != 0) {
        $sql_edit = "UPDATE [HRP].[dbo].[Position] SET
                    Pos_Name = '". $Name ."'
                    WHERE Pos_ID = '". $Pos_ID ."' ";

        mssql_query($sql_edit);
        // exit("<script>window.location='../position.php';</script>");
    } else {
        $sql_insert = "insert into [HRP].[dbo].[Position] (Pos_Name) VALUES('$Name')";

        mssql_query($sql_insert);
        // exit("<script>window.location='../position.php';</script>"); FROM [HRP]
    }
?>
<?php
	@session_start();
    include("../inc/connect.php");
    $Name = $_POST['Pos_Name'];
    $Pos_ID = $_POST['Pos_ID'];

    $Name = iconv('UTF-8','TIS-620', $Name);

    $sql_click = "SELECT Pos_ID FROM [HRP].[dbo].[Position] WHERE Pos_ID = '". $Pos_ID ."' ";
    $query = mssql_query($sql_click);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    if($num != 0) {
        $sql_edit = "UPDATE [HRP].[dbo].[Position] SET
                    Pos_Name = '". $Name ."'
                    WHERE Pos_ID = '". $Pos_ID ."' ";

        mssql_query($sql_edit);
        exit("<script>window.location='position.php';</script>");
    } else {
        $sql_insert = "insert into [HRP].[dbo].[Position] (Pos_Name) VALUES('$Name')";

        mssql_query($sql_insert);
        exit("<script>window.location='position.php';</script>");
    }
?>
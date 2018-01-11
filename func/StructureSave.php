<?php
	@session_start();
    require("../inc/connect.php");
    $Code = iconv('UTF-8','TIS-620', $_POST['Site_Code']);
    $Name = iconv('UTF-8','TIS-620', $_POST['Site_Name']);
    $Status = iconv('UTF-8','TIS-620', $_POST['Site_Status']);
    $DateOpen = new DateTime($DateOpen);
    $DateOpen = $DateOpen->format('Y-m-d');
    $Site_ID = $_POST['Site_ID'];

    // echo $Code.'-'.$Name.'-'.$Status.'-'.$Site_ID.'-'.$DateOpen;

    $checks = "SELECT Site_ID FROM [HRP].[dbo].[Sites] WHERE Site_Name = '". $Name ."' ";
    $querys = mssql_query($checks);
    $nums = mssql_num_rows($querys);

    if($nums != 0) {
        exit("<script>alert('Please Check SiteName');history.back()</script>");
    }

    $check = "SELECT Site_ID FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $Site_ID ."' AND Site_Name = '". $Name ."' ";
    $query = mssql_query($check);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    if($num != 0) {
        $sql_edit = "UPDATE [HRP].[dbo].[Sites] SET
                    Site_Name = '". $Name ."',
                    Site_Code = '". $Code ."',
                    Site_Status = '". $Status ."'
                    WHERE Site_ID = '". $Site_ID ."' ";

        mssql_query($sql_edit);
        // echo $sql_edit;
    } else {
        $sql_insert = "INSERT INTO [HRP].[dbo].[Sites] (Site_Name, Site_Code, Site_Status, Site_Open) VALUES ('". $Name ."', '". $Code ."', '1', '". $DateOpen ."')";

        mssql_query($sql_insert);
        // echo $sql_insert;
    }
?>
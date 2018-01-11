<?php
	@session_start();
    include("../inc/connect.php");
    $Name = $_POST['Group_Name'];
    $Site_ID = $_POST['Site_ID'];
    $Group_ID = $_POST['Group_ID'];

    $Name = iconv('UTF-8','TIS-620', $Name);

    $sql_click = "SELECT Group_ID FROM [HRP].[dbo].[Group] WHERE Group_ID = '". $Group_ID ."' ";
    $query = mssql_query($sql_click);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    if($num != 0) {
        $sql_edit = "UPDATE [HRP].[dbo].[Group] SET
        			Group_Name = '". $Name ."',
        			Site_ID = '". $Site_ID ."'
        			WHERE Group_ID = '". $Group_ID ."' ";

                    echo $sql_edit;

	    mssql_query($sql_edit);
	    exit("<script>window.location='dependency.php';</script>");
    } else {
	    $sql_insert = "insert into [HRP].[dbo].[Group] (Group_Name, Site_ID) VALUES('$Name', '$Site_ID')";

	    mssql_query($sql_insert);
	    exit("<script>window.location='dependency.php';</script>");
    }
?>
<?php
	require("../inc/connect.php");
    $id = $_GET['List_ID'];
    $sql_delete = "DELETE FROM [HRP].[dbo].[Item_List] WHERE List_ID = '". $id ."' ";
    mssql_query($sql_delete);

    exit("<script>window.location='../Expenses.php';</script>");
?>
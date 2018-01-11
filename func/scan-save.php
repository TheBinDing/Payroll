<?php
	@session_start();
    include("../inc/connect.php");
    $FingerID = $_POST['FingerID'];
    $FingerCode = iconv('UTF-8','TIS-620', $_POST['FingerCode']);
    $FingerName = iconv('UTF-8','TIS-620', $_POST['FingerName']);
    $Band = iconv('UTF-8','TIS-620', $_POST['Band']);
    $Model = iconv('UTF-8','TIS-620', $_POST['Model']);
    $Discription = iconv('UTF-8','TIS-620', $_POST['Discription']);
    $Site_ID = $_POST['Site_ID'];

    $sql_click = "SELECT FingerID FROM [HRP].[dbo].[FingerScanner] WHERE FingerID = '". $FingerID ."' ";
    $query = mssql_query($sql_click);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    if($num != 0) {
    //     $sql_edit = "UPDATE [HRP].[dbo].[Site] SET
    //                 Site_Name = '". $Name ."',
    //                 Status_ID = '". $Status ."'
    //                 WHERE Site_ID = '". $Site_ID ."' ";

    //     mssql_query($sql_edit);
    //     exit("<script>window.location='structure.php';</script>");
    } else {
        $sql_insert = "INSERT INTO [HRP].[dbo].[FingerScanner] (FingerCode, FingerName, Band, Model, Discription) 
        VALUES ('$FingerCode', '$FingerName', '$Band', '$Model', '$Discription')";

        mssql_query($sql_insert);
        exit("<script>window.location='../scan.php';</script>");
    }
?>
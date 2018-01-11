<?php
	@session_start();
    require("../inc/connect.php");

	$date = new datetime($date);
	$date = $date->format('Y-m-d');

	$sql_insert = " INSERT INTO [HRP].[dbo].[Time_Plan]
           (Em_ID,LogTime,CK_in,Ck_Out1,CK_in2,Ck_Out2,Total,OTN,OTE,TotalOT1,TotalOT15,TotalOT2,CKOT_in1, CKOT_Out1, CKOT_in2, CKOT_Out2)
     VALUES
           ('". $Em_ID ."', '". $date ."', '". $CK_in ."', '". $Ck_Out1 ."', '". $CK_in2 ."', '". $Ck_Out2 ."', '9', '0', '0', '0', '0', '0','','','','')";

    mssql_query($sql_insert);
?>
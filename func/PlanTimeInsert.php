<?php
    require("../inc/connect.php");

    $Em_ID = $_GET['Em_ID'];
    $date = new datetime($_GET['LogTime']);
    $date = $date->format('Y-m-d');

    $sql = "SELECT
                TimePlan_LateTime,
                CK_in,
                Ck_Out1,
                CK_in2,
                Ck_Out2,
                CKOT_in1,
                CKOT_Out1,
                CKOT_in2,
                CKOT_Out2
            FROM
                [HRP].[dbo].[Employees] E RIGHT JOIN [HRP].[dbo].[PlanTime] P on E.TimePlan_ID = P.TimePlan_ID
            WHERE
                E.Em_ID = '". $Em_ID ."' ";

    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);

    $insert = " INSERT INTO [dbo].[Time_Plan]
                    (Em_ID,LogTime,CK_in,Ck_Out1,CK_in2,Ck_Out2,CKOT_in1,CKOT_Out1,CKOT_in2,CKOT_Out2,Total,OTN,OTE,TotalOT1,TotalOT15,TotalOT2,FingerID)
                VALUES
                ('". $Em_ID ."', '". $date ."', '". $row['CK_in'] ."', '". $row['Ck_Out1'] ."', '". $row['CK_in2'] ."', '". $row['Ck_Out2'] ."', '". $row['CKOT_in1'] ."', '". $row['CKOT_Out1'] ."', '". $row['CKOT_in2'] ."', '". $row['CKOT_Out2'] ."','9','0','0','0','5.5','5','') ";
    mssql_query($insert);

    echo "<script language=\"JavaScript\">";
    echo "location.replace('TimePlan.php');";
    echo "</script>";
?>
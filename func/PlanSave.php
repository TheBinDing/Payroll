<?php
    require("../inc/connect.php");

    $TimePlan_ID = $_POST['TimePlan_ID'];
    $Site_ID = $_POST['Site_ID'];
    $start = new datetime($_POST['start']);
    $start = $start->format('Y-m-d');
    $end = new datetime($_POST['end']);
    $end = $end->format('Y-m-d');
    $Status = $_POST['Status'];
    $Name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
    $Hour = $_POST['Hour'];
    $Late = $_POST['Late'];
    $CK_in = $_POST['CK_in'];
    $Ck_Out1 = $_POST['Ck_Out1'];
    $CK_in2 = $_POST['CK_in2'];
    $Ck_Out2 = $_POST['Ck_Out2'];
    $CKOT_in1 = $_POST['CKOT_in1'];
    $CKOT_Out1 = $_POST['CKOT_Out1'];
    $CKOT_in2 = $_POST['CKOT_in2'];
    $CKOT_Out2 = $_POST['CKOT_Out2'];

    $check = "SELECT TimePlan_ID FROM [HRP].[dbo].[PlanTime] WHERE TimePlan_ID = '".$TimePlan_ID."' ";
    $query = mssql_query($check);
    $num = mssql_num_rows($query);

    if($num != 0) {
        $sql_edit = "UPDATE
                        [HRP].[dbo].[PlanTime]
                    SET
                        TimePlan_Name = '". $Name ."',
                        TimePlan_Hour = '". $Hour ."',
                        TimePlan_LateTime = '". $Late ."',
                        CK_in = '". $CK_in ."',
                        Ck_Out1 = '". $Ck_Out1 ."',
                        CK_in2 = '". $CK_in2 ."',
                        Ck_Out2 = '". $Ck_Out2 ."',
                        CKOT_in1 = '". $CKOT_in1 ."',
                        CKOT_Out1 = '". $CKOT_Out1 ."',
                        CKOT_in2 = '". $CKOT_in2 ."',
                        CKOT_Out2 = '". $CKOT_Out2 ."',
                        TimePlan_StartDate = '". $start ."',
                        TimePlan_EndDate = '". $end ."',
                        TimePlan_Status = '". $Status ."',
                        Site_ID = '". $Site_ID ."'
                    WHERE
                        TimePlan_ID = '". $TimePlan_ID ."' ";

        mssql_query($sql_edit);
        exit("<script>window.location='../Plan.php';</script>");
    } else {
        $sql_insert = "INSERT INTO [HRP].[dbo].[PlanTime]";
        $sql_insert .= " (TimePlan_Name, TimePlan_Hour, TimePlan_LateTime, CK_in, Ck_Out1, CK_in2, Ck_Out2, CKOT_in1, CKOT_Out1, CKOT_in2, CKOT_Out2, TimePlan_StartDate, TimePlan_EndDate, TimePlan_Status, Site_ID)";
        $sql_insert .= " VALUES ('".$Name."', '".$Hour."', '".$Late."', '".$CK_in."', '".$Ck_Out1."', '".$CK_in2."', '".$Ck_Out2."', '".$CKOT_in1."', '".$CKOT_Out1."', '".$CKOT_in2."', '".$CKOT_Out2."', '".$start."', '".$end."', '".$Status."', '".$Site_ID."')";

		// echo $sql_insert;
        mssql_query($sql_insert);
        exit("<script>window.location='../Plan.php';</script>");
    }
?>
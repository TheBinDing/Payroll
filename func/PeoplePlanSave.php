<?php
	@session_start();
    require("../inc/connect.php");

    $plan = $_POST['TimePlan'];
    for($i=0;$i<count($_POST["input"]);$i++)
    {
        if($_POST["input"][$i] != "")
        {
            $update_time = " UPDATE [HRP].[dbo].[Employees] SET TimePlan_ID = '". $plan ."' WHERE Em_ID = '". $_POST['input'][$i] ."' ";
            mssql_query($update_time);

            $update_log = "INSERT INTO [HRP].[dbo].[PlanTimeLog] (Em_ID, TimePlan_ID) VALUES ('".$_POST['input'][$i]."', '".$plan."')";
            mssql_query($update_log);
        }
    }
    // echo "<script language=\"JavaScript\">";
    // echo "alert('$plan');";
    // echo "</script>";
    // exit("<script>window.location='window.location='../PlanPeople.php?Check=2';</script>");
?>
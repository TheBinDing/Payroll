<?php
    require("../inc/connect.php");
    $id = $_POST['name'];
    $plan = $_POST['Plan'];

    $PlanSearch = "SELECT TimePlan_StartDate, TimePlan_EndDate FROM [HRP].[dbo].[PlanTime] WHERE TimePlan_ID = '". $plan ."' ";
    $PlanQuery = mssql_query($PlanSearch);
    $PlanRow = mssql_fetch_array($PlanQuery);

    $start = new datetime($PlanRow['TimePlan_StartDate']);
    $start = $start->format('Y-m-d');
    $end = new datetime($PlanRow['TimePlan_EndDate']);
    $end = $end->format('Y-m-d');

    $UpdateTimePlan = "UPDATE [HRP].[dbo].[Time_Plan] SET
                            TimePlan_ID = '". $plan ."'
                        WHERE
                            Em_ID = '". $id ."'
                            AND LogTime BETWEEN CONVERT(DATETIME, '". $start ."', 102) AND CONVERT(DATETIME, '". $end ."', 102) ";

    mssql_query($UpdateTimePlan);
    exit("<script>window.location='../PlanPeople.php';</script>");
?>
<?php
    $Em_ID = $_GET['Em_ID'];
    
    $sql_pe = "SELECT
            P.CK_in as CK_in,
            P.Ck_Out1 as Ck_Out1,
            P.CK_in2 as CK_in2,
            P.Ck_Out2 as Ck_Out2
        FROM
            [HRP].[dbo].[PlanTime] P LEFT JOIN
            [HRP].[dbo].[Employees] E on P.TimePlan_ID = E.TimePlan_ID
        WHERE
            Em_ID = '".$Em_ID."' ";

    $query_pe = mssql_query($sql_pe);
    $row_pe = mssql_fetch_array($query_pe);

    $CK_in = $row_pe['CK_in'];
    $Ck_Out1 = $row_pe['Ck_Out1'];
    $CK_in2 = $row_pe['CK_in2'];
    $Ck_Out2 = $row_pe['Ck_Out2'];
?>
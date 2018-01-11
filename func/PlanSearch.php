<?php
    $TimePlan_ID = $_GET['TimePlan_ID'];
	$Page = $_GET['Page'];

    if(!empty($TimePlan_ID)) {
        // input in form to edit
        $sql_edit = "SELECT
                P.TimePlan_ID AS ID,
                CAST(P.TimePlan_Name AS Text) AS Name,
                P.TimePlan_Hour AS Hour,
                P.TimePlan_LateTime AS Late,
                P.CK_in AS CK_in,
                P.Ck_Out1 AS Ck_Out1,
                P.CK_in2 AS CK_in2,
                P.Ck_Out2 AS Ck_Out2,
                P.CKOT_in1 AS CKOT_in1,
                P.CKOT_Out1 AS CKOT_Out1,
                P.CKOT_in2 AS CKOT_in2,
                P.CKOT_Out2 AS CKOT_Out2,
                P.TimePlan_StartDate AS StartDate,
                P.TimePlan_EndDate AS EndDate,
                CAST(P.TimePlan_Status AS Text) AS Status,
                S.Site_ID AS Site_ID,
                CAST(S.Site_Name AS Text) AS Site_Name
            FROM
                [HRP].[dbo].[PlanTime] P LEFT JOIN [HRP].[dbo].[Sites] S ON P.Site_ID = S.Site_ID
            WHERE 
            	TimePlan_ID = '". $TimePlan_ID ."' ";

        $query_edit = mssql_query($sql_edit);
        $row_edit = mssql_fetch_array($query_edit);

        $Start = new datetime($row_edit['StartDate']);
        $Start = $Start->format('d-m-Y');
        $End = new datetime($row_edit['EndDate']);
        $End = $End->format('d-m-Y');

        $CK_in = $row_edit['CK_in'];
        $Ck_Out1 = $row_edit['Ck_Out1'];
        $CK_in2 = $row_edit['CK_in2'];
        $Ck_Out2 = $row_edit['Ck_Out2'];
        $CKOT_in1 = $row_edit['CKOT_in1'];
        $CKOT_Out1 = $row_edit['CKOT_Out1'];
        $CKOT_in2 = $row_edit['CKOT_in2'];
        $CKOT_Out2 = $row_edit['CKOT_Out2'];
    }

    $sql = "SELECT
                P.TimePlan_ID AS ID,
                CAST(P.TimePlan_Name AS Text) AS Name,
                P.TimePlan_Hour AS Hour,
                P.TimePlan_LateTime AS Late,
                P.CK_in AS CK_in,
                P.Ck_Out1 AS Ck_Out1,
                P.CK_in2 AS CK_in2,
                P.Ck_Out2 AS Ck_Out2,
                P.CKOT_in1 AS CKOT_in1,
                P.CKOT_Out1 AS CKOT_Out1,
                P.CKOT_in2 AS CKOT_in2,
                P.CKOT_Out2 AS CKOT_Out2,
                P.TimePlan_StartDate AS StartDate,
                P.TimePlan_EndDate AS EndDate,
                CAST(P.TimePlan_Status AS Text) AS Status,
                S.Site_ID AS Site_ID,
                CAST(S.Site_Name AS Text) AS Site_Name
            FROM
                [HRP].[dbo].[PlanTime] P LEFT JOIN [HRP].[dbo].[Sites] S ON P.Site_ID = S.Site_ID 
            WHERE
                P.TimePlan_Status = '1' ";
    if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
        $sql .= "AND (S.Site_ID = '".$_SESSION['SuperSite']."' OR S.Site_ID = '1') ";
    }


    $query = mssql_query($sql);
    $num = mssql_num_rows($query);
?>
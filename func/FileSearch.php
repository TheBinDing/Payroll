<?php
    $sql_search = " SELECT
                        E.Em_ID as Em_ID,
                        E.Em_Fullname as Fullname,
                        E.Em_Lastname as Lastname,
                        E.Em_Titel as Titel,
                        T.LogTime as LogTime,
                        T.CK_in as CK_in,
                        T.Ck_Out1 as Ck_Out1,
                        T.CK_in2 as CK_in2,
                        T.Ck_Out2 as Ck_Out2,
                        T.CKOT_in1 as CKOT_in1,
                        T.CKOT_Out1 as CKOT_Out1,
                        T.CKOT_in2 as CKOT_in2,
                        T.CKOT_Out2 as CKOT_Out2,
                        F.FingerName as FingerName,
                        PT.TimePlan_Name as TimePlan_Name,
                        CAST(S.Site_Name as Text) as Site_Name
                    FROM
                        [HRP].[dbo].[Time_Plan] T
                        LEFT JOIN [HRP].[dbo].[PlanTime] PT ON T.TimePlan_ID = PT.TimePlan_ID
                        LEFT JOIN [HRP].[dbo].[Employees] E ON T.Em_ID = E.Em_ID
                        LEFT JOIN [HRP].[dbo].[FingerScanner] F ON T.FingerID = F.FingerID
                        LEFT JOIN [HRP].[dbo].[Sites] S ON PT.Site_ID = S.Site_ID
                    Where
                        T.TimePlan_Cal_Status = '0' ";
    if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
        $sql_search .= "AND E.Site_ID = '".$_SESSION['SuperSite']."' ";
    }
    $sql_search .= " ORDER BY
                        T.LogTime DESC";

    $query = mssql_query($sql_search);
    $num = mssql_num_rows($query);
?>
<?php
    $Em_ID = $_GET['Em_ID'];
    $date = new datetime($_GET['LogTime']);
    $date = $date->format('Y-m-d');
    $check = $_GET['Check'];

    if($check == '0') {
        $sql = "SELECT
                    E.Em_ID AS Em_ID,
                    E.Em_Fullname AS Fullname,
                    E.Em_Lastname AS Lastname, 
                    E.Em_Titel AS Titel, 
                    TP.LogTime AS LogTime, 
                    TP.CK_in AS CK_in, 
                    TP.CK_in2 AS CK_in2, 
                    TP.Ck_Out1 AS Ck_Out1, 
                    TP.Ck_Out2 AS Ck_Out2, 
                    TP.CKOT_in1 AS CKOT_in1, 
                    TP.CKOT_Out1 AS CKOT_Out1, 
                    TP.CKOT_in2 AS CKOT_in2, 
                    TP.CKOT_Out2 AS CKOT_Out2, 
                    TP.Total AS Total,
                    TP.OTN AS OTN,
                    TP.OTE AS OTE,
                    TP.TotalOT1 AS OT1,
                    TP.TotalOT15 AS OT15,
                    TP.TotalOT2 AS OT2,
                    F.FingerName AS FingerName
                FROM
                    [HRP].[dbo].[Time_Plan] TP
					LEFT JOIN [HRP].[dbo].[Employees] E ON (TP.Em_ID = E.Em_ID)
					LEFT JOIN [HRP].[dbo].[FingerScanner] F ON (TP.FingerID = F.FingerID)
                WHERE
                    E.Em_ID = '". $Em_ID ."'
                    AND TP.LogTime = '". $date ."'";

        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);

        $Em_ID = $row['Em_ID'];

        $LogTime = new DateTime($row['LogTime']);
        $LogTime = $LogTime->format('d-m-Y');

		if($row['Titel'] == 'Mr') {
			$Titel = 'นาย ';
		}
		if($row['Titel'] == 'Ms') {
			$Titel = 'นางสาว ';
		}
		if($row['Titel'] == 'Mrs') {
			$Titel = 'นาง ';
		}

        $names = iconv('TIS-620','UTF-8',$Titel).' '.iconv('TIS-620','UTF-8',$row['Fullname']).' '.iconv('TIS-620','UTF-8',$row['Lastname']);

        $CK_in = $row['CK_in'];

        $Ck_Out1 = $row['Ck_Out1'];

        $CK_in2 = $row['CK_in2'];

        $Ck_Out2 = $row['Ck_Out2'];

        $CKOT_in1 = $row['CKOT_in1'];

        $CKOT_Out1 = $row['CKOT_Out1'];

        $CKOT_in2 = $row['CKOT_in2'];

        $CKOT_Out2 = $row['CKOT_Out2'];

		$sql_pe = "SELECT
                P.CK_in as PCK_in,
                P.Ck_Out1 as PCk_Out1,
                P.CK_in2 as PCK_in2,
                P.Ck_Out2 as PCk_Out2,
				P.CKOT_in1 as PCKOT_in1,
				P.CKOT_Out1 as PCKOT_Out1,
				P.CKOT_in2 as PCKOT_in2,
				P.CKOT_Out2 as PCKOT_Out2
            FROM
                [HRP].[dbo].[PlanTime] P LEFT JOIN
                [HRP].[dbo].[Employees] E on P.TimePlan_ID = E.TimePlan_ID
            WHERE
                Em_ID = '".$Em_ID."' ";

		$query_pe = mssql_query($sql_pe);
        $row_pe = mssql_fetch_array($query_pe);

		$PCK_in = $row_pe['PCK_in'];

        $PCk_Out1 = $row_pe['PCk_Out1'];

        $PCK_in2 = $row_pe['PCK_in2'];

        $PCk_Out2 = $row_pe['PCk_Out2'];

        $PCKOT_in1 = $row_pe['PCKOT_in1'];

        $PCKOT_Out1 = $row_pe['PCKOT_Out1'];

        $PCKOT_in2 = $row_pe['PCKOT_in2'];

        $PCKOT_Out2 = $row_pe['PCKOT_Out2'];
    }
    if($Check == '1') {
        $sql_pe = "SELECT
                P.CK_in as CK_in,
                P.Ck_Out1 as Ck_Out1,
                P.CK_in2 as CK_in2,
                P.Ck_Out2 as Ck_Out2,
                E.Em_Fullname AS Fullname
            FROM
                [HRP].[dbo].[PlanTime] P LEFT JOIN
                [HRP].[dbo].[Employees] E on P.TimePlan_ID = E.TimePlan_ID
            WHERE
                Em_ID = '".$Em_ID."' ";

        $query_pe = mssql_query($sql_pe);
        $row_pe = mssql_fetch_array($query_pe);

        $LogTime = new DateTime($date);
        $LogTime = $LogTime->format('d-m-Y');

        $names = iconv('TIS-620','UTF-8',$row_pe['Fullname']);

        $CK_in = $row_pe['CK_in'];
        $Ck_Out1 = $row_pe['Ck_Out1'];
        $CK_in2 = $row_pe['CK_in2'];
        $Ck_Out2 = $row_pe['Ck_Out2'];

		$sql_pe = "SELECT
                P.CK_in as PCK_in,
                P.Ck_Out1 as PCk_Out1,
                P.CK_in2 as PCK_in2,
                P.Ck_Out2 as PCk_Out2,
				P.CKOT_in1 as PCKOT_in1,
				P.CKOT_Out1 as PCKOT_Out1,
				P.CKOT_in2 as PCKOT_in2,
				P.CKOT_Out2 as PCKOT_Out2
            FROM
                [HRP].[dbo].[PlanTime] P LEFT JOIN
                [HRP].[dbo].[Employees] E on P.TimePlan_ID = E.TimePlan_ID
            WHERE
                Em_ID = '".$Em_ID."' ";

		$query_pe = mssql_query($sql_pe);
        $row_pe = mssql_fetch_array($query_pe);

		$PCK_in = $row_pe['PCK_in'];

        $PCk_Out1 = $row_pe['PCk_Out1'];

        $PCK_in2 = $row_pe['PCK_in2'];

        $PCk_Out2 = $row_pe['PCk_Out2'];

        $PCKOT_in1 = $row_pe['PCKOT_in1'];

        $PCKOT_Out1 = $row_pe['PCKOT_Out1'];

        $PCKOT_in2 = $row_pe['PCKOT_in2'];

        $PCKOT_Out2 = $row_pe['PCKOT_Out2'];
    }
?>
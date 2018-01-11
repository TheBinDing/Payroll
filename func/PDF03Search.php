<?php
	$date = new datetime();
	$date_year = $date->format('Y');

    $Em_ID = $_GET['Em_ID'];
    $Site = $_GET['Site'];
    $Period = $_GET['Period'];
    $Start = $_GET['Start'];
    $End = $_GET['End'];

    if($Period != '') {
        $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$Period."' ";
        $query_period = mssql_query($sql_period);
        $Periods = mssql_fetch_array($query_period);
        
        $Period_Start = new datetime($Periods['StartDate']);
        $Period_Start = $Period_Start->format('Y-m-d');

        $Period_End = new datetime($Periods['EndDate']);
        $Period_End = $Period_End->format('Y-m-d');
    } else {
        $Period_Start = new datetime($Start);
        $Period_Start = $Period_Start->format('Y-m-d');

        $Period_End = new datetime($End);
        $Period_End = $Period_End->format('Y-m-d');
    }

    $where = !empty($Em_ID)?  " AND (E.Em_ID = '". $Em_ID ."') " : "";

    $sql_e = "SELECT
                E.Em_ID AS ID,
                E.Em_Card AS ID_TH,
                CAST(E.Em_Fullname AS Text) AS Fullname,
                CAST(E.Em_Lastname AS Text) AS Lastname,
                CAST(E.Em_Titel AS Text) AS Titel,
                CAST(E.Em_People AS Text) AS Title,
                CAST(G.Group_Name AS Text) AS GroupName,
                CAST(P.Pos_Name AS Text) AS Position,
                CAST(S.Site_Name AS Text) AS Site
            FROM
                [HRP].[dbo].[Employees] E LEFT JOIN [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                LEFT JOIN [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                LEFT JOIN [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
            WHERE
                S.Site_ID = '". $Site ."'
				AND Em_Status = 'W'
            $where
            ORDER BY
                G.Group_ID ASC ";

    $query_e = mssql_query($sql_e);
    $num_e = mssql_num_rows($query_e);
?>
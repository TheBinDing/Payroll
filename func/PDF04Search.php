<?php
	$date = new datetime();
	$date_year = $date->format('Y');

    $Group = $_GET['Group'];
    $Sites = $_GET['Site'];
    $Position = $_GET['Position'];
    $Period = $_GET['Period'];

    $where .= !empty($Group)?  " AND (G.Group_ID = '". $Group ."') " : "";
    $where .= !empty($Position)?  " AND (P.Pos_ID = '". $Position ."') " : "";

    $sql_social = "SELECT Social_ID, Social_Number FROM [HRP].[dbo].[SocialSecurity]";
    $query_social = mssql_query($sql_social);
    $Rsocial = mssql_fetch_array($query_social);
    $P_Social = $Rsocial['Social_Number'];
    $PS_Social = $Rsocial['Social_Number'] / 100;

    $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$Period."' ";
    $query_period = mssql_query($sql_period);
    $Periods = mssql_fetch_array($query_period);
    $Period_Start = new datetime($Periods['StartDate']);
    $Period_Start = $Period_Start->format('Y-m-d');
    $Period_End = new datetime($Periods['EndDate']);
    $Period_End = $Period_End->format('Y-m-d');

    $sql_e = "SELECT
                M.Em_ID AS ID,
                M.MT_Titel AS Titel,
                M.MT_Money as Money,
                CAST(M.MT_Name AS Text) AS Fullname,
                CAST(M.MT_GroupName AS Text) AS GroupName,
                CAST(M.MT_PositionName AS Text) AS Position,
                CAST(S.Site_Name AS Text) AS Site
            FROM
                [HRP].[dbo].[Time_Plan] TP
                left join [HRP].[dbo].[MoneyTotal] M on TP.Em_ID = M.Em_ID
                left join [HRP].[dbo].[Sites] S on M.Site_ID = S.Site_ID
            WHERE
                S.Site_ID = '". $Sites ."'
                AND m.MT_Period = '". $Period ."'
            GROUP BY
                M.Em_ID, M.MT_Money, M.MT_Name, M.MT_GroupName, M.MT_PositionName, S.Site_Name, M.MT_Titel
            ORDER BY
                M.MT_GroupName ASC ";

    $query_e = mssql_query($sql_e);
    $num_e = mssql_num_rows($query_e);
?>
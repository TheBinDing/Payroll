<?php
	$date = new datetime();
	$date_year = $date->format('Y');

    $Group = $_GET['Group'];
    $Site = $_GET['Site'];
    $Position = $_GET['Position'];
    $Period = $_GET['Period'];

    if($Site != '1') {
        $where = " AND (S.Site_ID = '". $Site ."') ";
    }
    $where .= !empty($Group)?  " AND (G.Group_ID = '". $Group ."') " : "";
    $where .= !empty($Position)?  " AND (P.Pos_ID = '". $Position ."') " : "";

    $sql_social = "SELECT Social_ID, Social_Number FROM [HRP].[dbo].[SocialSecurity]";
    $query_social = mssql_query($sql_social);
    $Rsocial = mssql_fetch_array($query_social);
    $P_Social = $Rsocial['Social_Number'];
    $PS_Social = $Rsocial['Social_Number'] / 100;

    $sql_period = "SELECT Per_Week AS Weeks, Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$Period."' ";
    $query_period = mssql_query($sql_period);
    $Periods = mssql_fetch_array($query_period);
    $Period_Week = $Periods['Weeks'];
    $Period_Start = new datetime($Periods['StartDate']);
    $Period_Start = $Period_Start->format('Y-m-d');
    $Period_End = new datetime($Periods['EndDate']);
    $Period_End = $Period_End->format('Y-m-d');

    $sql_e = "SELECT
                M.Em_ID AS ID,
                M.MT_Card AS ID_TH,
                M.MT_Money as Money,
                SUM(CAST(TP.Total as float)) as Total,
                SUM(CAST(TP.OTN as float)) as OTN,
                SUM(CAST(TP.OTE as float)) as OTE,
                SUM(CAST(TP.TotalOT15 as float)) as total15,
                SUM(CAST(TP.TotalOT2 as float)) as total2,
                CAST(M.MT_Name AS Text) AS Fullname,
                CAST(M.MT_Titel AS Text) AS Titel,
                CAST(M.MT_GroupName AS Text) AS GroupName,
                CAST(M.MT_PositionName AS Text) AS Position,
                CAST(S.Site_Name AS Text) AS Site
            FROM
                [HRP].[dbo].[Time_Plan] TP left join
                [HRP].[dbo].[MoneyTotal] M on TP.Em_ID = M.Em_ID left join
                [HRP].[dbo].[Sites] S on M.Site_ID = S.Site_ID
            WHERE
                M.MT_Period = '". $Period ."'
                AND M.Em_ID != ''
                $where
            GROUP BY
                M.Em_ID, M.MT_Money, M.MT_Name, M.MT_GroupName, M.MT_PositionName, S.Site_Name, M.MT_Card, M.MT_Titel ";

    $query_e = mssql_query($sql_e);
    $num_e = mssql_num_rows($query_e);
?>
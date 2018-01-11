<?php
	$date = new datetime();
	$date_year = $date->format('Y');

    $Group = $_GET['Group'];
    $Site = $_GET['Site'];
    $Position = $_GET['Position'];
    $Period = $_GET['Period'];

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
                    m.MT_GroupID AS GroupID,
                    CAST(m.MT_GroupName AS Text) AS GroupName,
                    CAST(s.Site_Name AS Text) AS Site_Name
                FROM
                    [HRP].[dbo].[MoneyTotal] m inner join
                    [HRP].[dbo].[Sites] s on m.Site_ID = s.Site_ID
                WHERE
                    m.MT_Period = '". $Period ."'
                    AND s.Site_ID = '". $Site ."'
                GROUP BY
                    m.MT_GroupName,
                    m.MT_GroupID,
                    s.Site_Name ";
    $query_e = mssql_query($sql_e);
    $num_e = mssql_num_rows($query_e);
?>
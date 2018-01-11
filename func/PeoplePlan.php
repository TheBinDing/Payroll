<?php
    @session_start();

    $where = !empty($group)?  " AND (E.Group_ID = '". $group ."') " : "";
    $where .= !empty($position)?  " AND (E.Pos_ID = '". $position ."') " : "";

    $sql_pe = "SELECT
            E.Em_ID AS Em_ID,
            CAST(E.Em_Fullname AS Text) AS Fullname,
            CAST(E.Em_Lastname AS Text) AS Lastname,
            E.Em_Titel AS Titel,
            S.Site_ID AS Site_ID,
            P.Pos_ID AS Pos_ID,
            G.Group_ID AS Group_ID,
            CAST(S.Site_Name AS Text) AS Site_Name,
            CAST(P.Pos_Name AS Text) AS Pos_Name,
            CAST(G.Group_Name AS Text) AS Group_Name,
            E.TimePlan_ID AS TimePlan
        FROM
            [HRP].[dbo].[Employees] E,
            [HRP].[dbo].[Sites] S,
            [HRP].[dbo].[Position] P,
            [HRP].[dbo].[Group] G
        WHERE
            E.Site_ID = S.Site_ID
            AND E.Pos_ID = P.Pos_ID
            AND E.Group_ID = G.Group_ID
            AND E.Site_ID = '". $_SESSION['SuperSite'] ."'
            $where ";

    $query_pe = mssql_query($sql_pe);
    $num_pe = mssql_num_rows($query_pe);
?>
<?php
      $status = $_GET['Status'];

      $sql = "SELECT
                  Em_ID AS Em_ID,
                  Em_Pic AS Pic,
                  Em_Titel AS Titel,
                  Em_Status AS Status,
                  Socie AS Socie,
                  CAST(Em_Fullname AS Text) AS Fullname,
                  CAST(Em_Lastname AS Text) AS Lastname,
                  CAST(Em_Card AS Text) AS Card,
                  CAST(Site_Name AS Text) AS Site_Name,
                  CAST(Group_Name AS Text) AS Group_Name,
                  CAST(Pos_Name AS Text) AS Pos_Name
            FROM
                  [HRP].[dbo].[Employees] AS E,
                  [HRP].[dbo].[Sites] AS S,
                  [HRP].[dbo].[Group] AS G,
                  [HRP].[dbo].[Position] AS P
            WHERE
                  E.Site_ID = S.Site_ID
                  AND E.Group_ID = G.Group_ID
                  AND E.Pos_ID = P.Pos_ID
                  AND E.Em_Status = 'W' ";
            if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
                  $sql .= " AND S.Site_ID = '".$_SESSION['SuperSite']."' ";
            }
            $sql .= " ORDER BY Em_ID DESC ";

      $query = mssql_query($sql);
      $num = mssql_num_rows($query);
?>
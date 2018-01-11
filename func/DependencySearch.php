<?php
    $sql_Search = " SELECT
                        G.Group_ID AS Group_ID,
                        S.Site_ID AS Site_ID,
                        CAST(G.Group_Name AS text) AS Group_Name,
                        CAST(S.Site_Name AS text) AS Site_Name
                    FROM
                        [HRP].[dbo].[Group] AS G left join [HRP].[dbo].[Sites] AS S on G.Site_ID = S.Site_ID ";
    if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
        $sql_Search .= "WHERE S.Site_ID = '".$_SESSION['SuperSite']."' ";
    }
    $sql_Search .= " ORDER BY Group_ID DESC";

    $query_search = mssql_query($sql_Search);
    $num_search = mssql_num_rows($query_search);
?>
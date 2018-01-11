<?php
    //data_edit
    $Site_ID = $_GET['Site_ID'];

    if(!empty($Site_ID)) {
        // input in form to edit
        $sql_edit = "SELECT Site_ID, CAST(Site_Name AS text) AS Site_Name, CAST(Site_Status AS text) AS Site_Status FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $Site_ID ."' ";

        $query_edit = mssql_query($sql_edit);
        $row_edit = mssql_fetch_array($query_edit);

        $site_name = iconv('TIS-620','UTF-8',$row_edit['Site_Name']);
        $site_status = iconv('TIS-620','UTF-8',$row_edit['Site_Status']);
        $Site_ID = $row_edit['Site_ID'];
    }

    $sql_Search = "SELECT
                        Site_ID,
                        CAST(Site_Name AS text) AS Site_Name,
                        CAST(Site_Status AS text) AS Site_Status
                    FROM
                        [HRP].[dbo].[Sites] ";
                    if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
                        $sql_Search .= " WHERE Site_ID = '".$_SESSION['SuperSite']."' ";
                    }
                    $sql_Search .= " ORDER BY Site_ID DESC";
    $query_search = mssql_query($sql_Search);
    $num_search = mssql_num_rows($query_search);
?>
<?php
    //data_edit
    $Pos_ID = $_GET['Pos_ID'];

    if(!empty($Pos_ID)) {
        // input in form to edit
        $sql_edit = "SELECT Pos_ID, CAST(Pos_Name AS text) AS Pos_Name FROM [HRP].[dbo].[Position] WHERE Pos_ID = '". $Pos_ID ."' ";

        $query_edit = mssql_query($sql_edit);
        $row_edit = mssql_fetch_array($query_edit);

        $Pos_Name = iconv('TIS-620','UTF-8',$row_edit['Pos_Name']);
        $Pos_ID = $row_edit['Pos_ID'];
    }

    // $sqls = "SELECT Pos_ID, CAST(Pos_Name AS text) AS Pos_Name FROM [HRP].[dbo].[Position]";
    // $querys = mssql_query($sqls);
    // $nums = mssql_num_rows($querys);

    // $perpage = 5;
    // if (isset($_GET['page'])) {
    //     $page = $_GET['page'];
    // } else {
    //     $page = 1;
    // }

    // $start = ($page - 1) * $perpage;
    // $end = ($start+$perpage) + 10;
    // $total_page = ceil($nums / $perpage);

    // $Prev_Page = $page-1;
    // $Next_Page = $page+1;

    $sql_Search = "SELECT Pos_ID, CAST(Pos_Name AS text) AS Pos_Name FROM [HRP].[dbo].[Position] ORDER BY Pos_ID DESC";
    $query_search = mssql_query($sql_Search);
    $num_search = mssql_num_rows($query_search);
?>
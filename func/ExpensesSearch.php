<?php
    $aa = $_GET['Status'];
    if(empty($_GET['Status'])) {
        $aa = '0';
    }
    $date = new datetime();
    $date = $date->format('d-m-Y');
	$date_year = new datetime();
    $date_year = $date_year->format('Y');

    $daies = explode('-', $date);
    if('1'<=$daies[0] && $daies[0]<='15') {
        $s = '01-'.$daies[1].'-'.$daies[2];
        $e = '15-'.$daies[1].'-'.$daies[2];
    } elseif ('16'<=$daies[0] && $daies[0]<= '31') {
        $s = '16-'.$daies[1].'-'.$daies[2];
        if(($daies[1] == '04') || ($daies[1] == '06') || ($daies[1] == '09') || ($daies[1] == '11')){
            $e = '30-'.$daies[1].'-'.$daies[2];
        } elseif($daies[1] == '02') {
            $e = '28-'.$daies[1].'-'.$daies[2];
        } else {
            $e = '31-'.$daies[1].'-'.$daies[2];
        }
    }

    $sql_per = "SELECT Per_ID FROM [HRP].[dbo].[Periods] WHERE Per_StartDate = '". $s ."' AND Per_EndDate = '". $e ."' ";
    $query_per = mssql_query($sql_per);
    $row_per = mssql_fetch_assoc($query_per);
    $per_id = $row_per['Per_ID'];
    $per_idm = $row_per['Per_ID'] - 2;

    $sql_period = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $per_idm ."' AND Per_ID != '". $per_id ."' ";
    $query_period = mssql_query($sql_period);
    $num_period = mssql_num_rows($query_period);

    $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $per_id ."' ";
    $query_per_id = mssql_query($sql_per_id);
    $row_Per_id = mssql_fetch_assoc($query_per_id);

    $sql_search = "  SELECT
                        E.Em_Fullname AS Em_Fullname,
                        E.Em_Lastname AS Em_Lastname,
						E.Em_Titel AS Titel,
                        CAST(S.Site_Name AS Text) AS Site_Name,
                        CAST(G.Group_Name AS Text) AS Group_Name,
                        CAST(P.Pos_Name AS Text) AS Pos_Name,
                        IL.List_Num AS List_Num,
                        IL.List_Price AS List_Price,
                        I.Item_Name AS Item_Name,
                        I.Item_Status AS Item_Status,
                        IL.List_Status AS List_Status,
                        IL.Remark AS Remark,
                        PD.Per_Week AS Week,
                        IL.List_ID AS List_ID,
                        /*IL.List_Create AS LCreate*/
						FORMAT(IL.List_Create, 'dd/MM/yyyy HH:mm:ss', 'en-us') as LCreate
                    FROM
                        [HRP].[dbo].[Item_List] IL,
                        [HRP].[dbo].[Employees] E ,
                        [HRP].[dbo].[Sites] S,
                        [HRP].[dbo].[Group] G,
                        [HRP].[dbo].[Position] P,
                        [HRP].[dbo].[Items] I,
                        [HRP].[dbo].[Periods] PD
                    WHERE
                        IL.Em_ID = E.Em_ID
                        AND E.Site_ID = S.Site_ID
                        AND E.Group_ID = G.Group_ID
                        AND E.Pos_ID = P.Pos_ID
                        AND IL.Item_ID = I.Item_ID
                        AND IL.Per_ID = PD.Per_ID
                        AND IL.List_Status = '".$aa."' ";

    if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
          $sql_search .= " AND S.Site_ID = '".$_SESSION['SuperSite']."' ";
    }

    $sql_search .= " ORDER BY IL.List_Create DESC ";

    $query_search = mssql_query($sql_search);
    $num_search = mssql_num_rows($query_search);
?>
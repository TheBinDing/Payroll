<?php
    if(isset($_POST['Check'])){
        $check = $_POST['Check'];
        $site = $_POST['Site_ID'];
        $position = $_POST['Position'];
        $group = $_POST['Group'];
        $plan = $_POST['Plan'];

        if($site == 1) {
            $where = " ";
        } else {
            $where = " AND E.Site_ID = '". $site ."' ";
        }
        $where .= !empty($group)?  " AND (E.Group_ID = '". $group ."') " : "";
        $where .= !empty($position)?  " AND (E.Pos_ID = '". $position ."') " : "";
        $where .= !empty($plan)?  " AND (E.TimePlan_ID = '". $plan ."') " : "";

        $_SESSION['SubPlePlan'] = $where;
    } else {
        $check = '0';
    }

    if($check != '0') {
        $sql_s = " SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $site ."' ";
        $q_s = mssql_query($sql_s);
        $r_s = mssql_fetch_array($q_s);

        $s_p = " SELECT Pos_ID, CAST(Pos_Name AS Text) AS Pos_Name FROM [HRP].[dbo].[Position] WHERE Pos_ID = '". $position ."' ";
        $q_p = mssql_query($s_p);
        $r_p = mssql_fetch_array($q_p);

        $s_g = " SELECT Group_ID, CAST(Group_Name AS Text) AS Group_Name FROM [HRP].[dbo].[Group] WHERE Group_ID = '". $group ."' ";
        $q_g = mssql_query($s_g);
        $r_g = mssql_fetch_array($q_g);

        $s_t = " SELECT TimePlan_ID, CAST(TimePlan_Name AS Text) AS TimePlan_Name FROM [HRP].[dbo].[PlanTime] WHERE TimePlan_ID = '". $plan ."' ";
        $q_t = mssql_query($s_t);
        $r_t = mssql_fetch_array($q_t);

		$_SESSION['planPeopleGroup'] = $group;

        $sql = "SELECT
				E.Em_ID AS Em_ID,
                CAST(PT.TimePlan_Name AS Text) AS TimePlan_Name,
                CAST(E.Em_Fullname AS Text) AS Fullname,
                CAST(E.Em_Lastname AS Text) AS Lastname,
                E.Em_Titel AS Titel,
                PT.TimePlan_StartDate AS TimePlan_StartDate,
                PT.TimePlan_EndDate AS TimePlan_EndDate,
                S.Site_ID AS Site_ID,
                P.Pos_ID AS Pos_ID,
                G.Group_ID AS Group_ID,
                CAST(S.Site_Name AS Text) AS Site_Name,
                CAST(P.Pos_Name AS Text) AS Pos_Name,
                CAST(G.Group_Name AS Text) AS Group_Name
            FROM
                [HRP].[dbo].[PlanTime] PT,
                [HRP].[dbo].[Employees] E,
                [HRP].[dbo].[Sites] S,
                [HRP].[dbo].[Position] P,
                [HRP].[dbo].[Group] G
            WHERE
                E.TimePlan_ID = PT.TimePlan_ID
                AND E.Site_ID = S.Site_ID
                AND E.Pos_ID = P.Pos_ID
                AND E.Group_ID = G.Group_ID
                $where ";

        $query = mssql_query($sql);
        $num = mssql_num_rows($query);
    }

    if($Check == '2') {
        $plan = $_GET['Plan'];
        $s_t = " SELECT TimePlan_ID, CAST(TimePlan_Name AS Text) AS TimePlan_Name FROM [HRP].[dbo].[PlanTime] WHERE TimePlan_ID = '". $plan ."' ";
        $q_t = mssql_query($s_t);
        $r_t = mssql_fetch_array($q_t);

        $whereS = $_SESSION['SubPlePlan'];
        $sql = "SELECT
				E.Em_ID AS Em_ID,
                CAST(PT.TimePlan_Name AS Text) AS TimePlan_Name,
                CAST(E.Em_Fullname AS Text) AS Fullname,
                CAST(E.Em_Lastname AS Text) AS Lastname,
                E.Em_Titel AS Titel,
                PT.TimePlan_StartDate AS TimePlan_StartDate,
                PT.TimePlan_EndDate AS TimePlan_EndDate,
                S.Site_ID AS Site_ID,
                P.Pos_ID AS Pos_ID,
                G.Group_ID AS Group_ID,
                CAST(S.Site_Name AS Text) AS Site_Name,
                CAST(P.Pos_Name AS Text) AS Pos_Name,
                CAST(G.Group_Name AS Text) AS Group_Name
            FROM
                [HRP].[dbo].[PlanTime] PT,
                [HRP].[dbo].[Employees] E,
                [HRP].[dbo].[Sites] S,
                [HRP].[dbo].[Position] P,
                [HRP].[dbo].[Group] G
            WHERE
                E.TimePlan_ID = PT.TimePlan_ID
                AND E.Site_ID = S.Site_ID
                AND E.Pos_ID = P.Pos_ID
                AND E.Group_ID = G.Group_ID
                $whereS ";

        $query = mssql_query($sql);
        $num = mssql_num_rows($query);
    }
?>
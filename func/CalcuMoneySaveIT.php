<?php
    // require("../inc/connect.php");

    if(isset($_POST['Check'])){
        $check = $_POST['Check'];
        $view = $_POST['View'];
        $dubble = $_POST['Dubble'];
        $site = $_POST['Site_ID'];
        $pos = $_POST['Pos'];
        $group = $_POST['Group'];
        $period = $_POST['Period'];
        $calcu = $_POST['calcu'];
    } else {
        $check = '0';
    }

    if($_SESSION['Rule'] == 1) {
        if($check == '1') {
            //ประกันสังคม
            $sql_social = "SELECT Social_ID, Social_Number FROM [HRP].[dbo].[SocialSecurity]";
            $query_social = mssql_query($sql_social);
            $Rsocial = mssql_fetch_array($query_social);
            $P_Social = $Rsocial['Social_Number'];
            $PS_Social = $Rsocial['Social_Number'] / 100;

            // ช่วงเวลา
            $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$period."' ";
            $query_period = mssql_query($sql_period);
            $Periods = mssql_fetch_array($query_period);
            $Period_Start = new datetime($Periods['StartDate']);
            $Period_Start = $Period_Start->format('Y-m-d');
            $Period_End = new datetime($Periods['EndDate']);
            $Period_End = $Period_End->format('Y-m-d');

            $sql_s = " SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $site ."' ";
            $q_s = mssql_query($sql_s);
            $r_s = mssql_fetch_array($q_s);

            $s_p = " SELECT Pos_ID, CAST(Pos_Name AS Text) AS Pos_Name FROM [HRP].[dbo].[Position] WHERE Pos_ID = '". $pos ."' ";
            $q_p = mssql_query($s_p);
            $r_p = mssql_fetch_array($q_p);

            $s_g = " SELECT Group_ID, CAST(Group_Name AS Text) AS Group_Name FROM [HRP].[dbo].[Group] WHERE Group_ID = '". $group ."' ";
            $q_g = mssql_query($s_g);
            $r_g = mssql_fetch_array($q_g);

            $s_pe = " SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
            $q_pe = mssql_query($s_pe);
            $r_pe = mssql_fetch_array($q_pe);

            if($_SESSION['SuperSite'] != '1') {
                $where = !empty($_SESSION['SuperSite'])?  " AND S.Site_ID = '". $_SESSION['SuperSite'] ."' " : "";
                $where .= !empty($pos)?  " AND P.Pos_ID = '". $pos ."' " : "";
                $where .= !empty($group)?  " AND G.Group_ID = '". $group ."' " : "";            
            } else {
                $where = !empty($site)?  " AND S.Site_ID = '". $site ."' " : "";
                $where .= !empty($pos)?  " AND P.Pos_ID = '". $pos ."' " : "";
                $where .= !empty($group)?  " AND G.Group_ID = '". $group ."' " : "";
            }

            $sql = "SELECT
                        E.Em_ID as Code,
                        E.Em_Fullname as Fullname,
                        E.Em_Money as Money,
                        SUM(CAST(TP.Total as float)) as Total,
                        SUM(CAST(TP.OTN as float)) as OTN,
                        SUM(CAST(TP.OTE as float)) as OTE,
                        SUM(CAST(TP.TotalOT15 as float)) as total15,
                        SUM(CAST(TP.TotalOT2 as float)) as total2,
                        CAST(E.Em_Fullname as Text) as Fullname,
                        CAST(S.Site_Name as Text) as Site_Name,
                        CAST(G.Group_Name as Text) as Group_Name,
                        CAST(P.Pos_Name as Text) as Pos_Name,
                        S.Site_ID AS Site_ID
                    FROM
                        [HRP].[dbo].[Time_Plan] TP
                        left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                        left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                        left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                        left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                    WHERE
                        (TP.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102))
                        $where
                    GROUP BY
                        S.Site_ID,TP.Em_ID,E.Em_ID,E.Em_Money,E.Em_Fullname,S.Site_Name,G.Group_Name,P.Pos_Name ";
            $query = mssql_query($sql);
            $num = mssql_num_rows($query);

            $sql_check = "SELECT
                            TP.TimePlan_Status 
                        FROM
                            [HRP].[dbo].[Time_Plan] TP
                            left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                            left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                            left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                            left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                        WHERE
                            (TP.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102)) $where
                        GROUP BY
                            TP.TimePlan_Status ";
            $query_check = mssql_query($sql_check);
            $row_check = mssql_fetch_array($query_check);
            $num_check = $row_check['TimePlan_Status'];

            $date_now = new datetime();
            $date_now = $date_now->format('d-m-Y H:i:s');
            
            $DT = new datetime($row_check['TDate']);
            $DT = $DT->format('d-m-Y');

            if($num_check == 0) {
                $lable = '0';
            }
            if($num_check == 1) {
                $lable = '3';
                $daies = $DT;
            }
        }

        if($view == '2') {
            //ประกันสังคม
            $sql_social = "SELECT Social_ID, Social_Number FROM [HRP].[dbo].[SocialSecurity]";
            $query_social = mssql_query($sql_social);
            $Rsocial = mssql_fetch_array($query_social);
            $P_Social = $Rsocial['Social_Number'];
            $PS_Social = $Rsocial['Social_Number'] / 100;

            // ช่วงเวลา
            $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$period."' ";
            $query_period = mssql_query($sql_period);
            $Periods = mssql_fetch_array($query_period);
            $Period_Start = new datetime($Periods['StartDate']);
            $Period_Start = $Period_Start->format('Y-m-d');
            $Period_End = new datetime($Periods['EndDate']);
            $Period_End = $Period_End->format('Y-m-d');

            $sql_s = " SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $site ."' ";
            $q_s = mssql_query($sql_s);
            $r_s = mssql_fetch_array($q_s);

            $s_p = " SELECT Pos_ID, CAST(Pos_Name AS Text) AS Pos_Name FROM [HRP].[dbo].[Position] WHERE Pos_ID = '". $pos ."' ";
            $q_p = mssql_query($s_p);
            $r_p = mssql_fetch_array($q_p);

            $s_g = " SELECT Group_ID, CAST(Group_Name AS Text) AS Group_Name FROM [HRP].[dbo].[Group] WHERE Group_ID = '". $group ."' ";
            $q_g = mssql_query($s_g);
            $r_g = mssql_fetch_array($q_g);

            $s_pe = " SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
            $q_pe = mssql_query($s_pe);
            $r_pe = mssql_fetch_array($q_pe);

            if($_SESSION['SuperSite'] != '1') {
                $where = !empty($_SESSION['SuperSite'])?  " AND S.Site_ID = '". $_SESSION['SuperSite'] ."' " : "";
                $where .= !empty($pos)?  " AND P.Pos_ID = '". $pos ."' " : "";
                $where .= !empty($group)?  " AND G.Group_ID = '". $group ."' " : "";            
            } else {
                $where = !empty($site)?  " AND S.Site_ID = '". $site ."' " : "";
                $where .= !empty($pos)?  " AND P.Pos_ID = '". $pos ."' " : "";
                $where .= !empty($group)?  " AND G.Group_ID = '". $group ."' " : "";
            }

            $sql = "SELECT
                        E.Em_ID as Code,
                        E.Em_Fullname as Fullname,
                        E.Em_Money as Money,
                        SUM(CAST(TP.Total as float)) as Total,
                        SUM(CAST(TP.OTN as float)) as OTN,
                        SUM(CAST(TP.OTE as float)) as OTE,
                        SUM(CAST(TP.TotalOT15 as float)) as total15,
                        SUM(CAST(TP.TotalOT2 as float)) as total2,
                        CAST(E.Em_Fullname as Text) as Fullname,
                        CAST(S.Site_Name as Text) as Site_Name,
                        CAST(G.Group_Name as Text) as Group_Name,
                        CAST(P.Pos_Name as Text) as Pos_Name,
                        S.Site_ID AS Site_ID
                    FROM
                        [HRP].[dbo].[Time_Plan] TP
                        left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                        left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                        left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                        left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                    WHERE
                        (TP.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102))
                        $where
                    GROUP BY
                        S.Site_ID,TP.Em_ID,E.Em_ID,E.Em_Money,E.Em_Fullname,S.Site_Name,G.Group_Name,P.Pos_Name ";
            $query = mssql_query($sql);
            $num = mssql_num_rows($query);

            $sql_check = "SELECT
                            TP.TimePlan_Status,
                            TP.TimePlan_Date AS TDate
                        FROM
                            [HRP].[dbo].[Time_Plan] TP
                            left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                            left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                            left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                            left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                        WHERE
                            (TP.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102)) $where
                        GROUP BY
                            TP.TimePlan_Status, TP.TimePlan_Date ";

            $query_check = mssql_query($sql_check);
            $row_check = mssql_fetch_array($query_check);
            $num_check = $row_check['TimePlan_Status'];
            $DT = new datetime($row_check['TDate']);
            $DT = $DT->format('d-m-Y');

            if($num_check == 0) {
                $lable = '2';
            }
            if($num_check == 1) {
                $lable = '1';
                $daies = $DT;
            }

            // $sql_check_period = "SELECT List_ID FROM [HRP].[dbo].[Item_List] WHERE Per_ID = '".$period."' AND List_Status = '0'";
            // echo $sql_check_period;
            // $q_c_p = mssql_query($sql_check_period);
            // $n_c_p = mssql_num_rows($q_c_p);
            // $r_c_p = mssql_fetch_array($q_c_p);

            // if($n_c_p != 0) {
            //     $update_c_p = "UPDATE [HRP].[dbo].[Item_List] set List_Status = '1' AND List_Update = '". $date_now ."' where Per_ID = '".$period."' ";
            // }
        }
    }
?>
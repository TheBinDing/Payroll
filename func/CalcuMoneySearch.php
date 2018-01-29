<?php
    // require("../inc/connect.php");
    $date_f = new datetime();
    $date_f = $date_f->format('d-m-Y');
    $date = new datetime();
    $date = $date->format('Y');

    $_SESSION['Root'] = 1;

    $daies_f = explode('-', $date_f);

	if($daies_f[0] < '6') {
		$s = '16-12-'.($daies_f[2]-1);
		$e = '31-12-'.($daies_f[2]-1);
	}
    if('6'<=$daies_f[0] && $daies_f[0]<='15') {
        $s = '01-'.$daies_f[1].'-'.$daies_f[2];
        $e = '15-'.$daies_f[1].'-'.$daies_f[2];
    } elseif ('16'<=$daies_f[0] && $daies_f[0]<= '31') {
        $s = '16-'.$daies_f[1].'-'.$daies_f[2];
        if(($daies_f[1] == '04') || ($daies_f[1] == '06') || ($daies_f[1] == '09') || ($daies_f[1] == '11')){
              $e = '30-'.$daies_f[1].'-'.$daies_f[2];
        } else if($daies_f[1] == '02') {
              $e = '28-'.$daies_f[1].'-'.$daies_f[2];
        } else {
              $e = '31-'.$daies_f[1].'-'.$daies_f[2];
        }
    }

    $sql_per = "SELECT Per_Week, Per_ID FROM [HRP].[dbo].[Periods] WHERE Per_StartDate = '". $s ."' AND Per_EndDate = '". $e ."' ";
    $query_per = mssql_query($sql_per);
    $row_per = mssql_fetch_assoc($query_per);
    if($row_per['Per_Week'] == 1) {
        $per_idm = $row_per['Per_ID'] - 1;
    } else {
        $per_id = $row_per['Per_ID'];
    }

    $sql_period = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $per_idm ."' AND Per_ID != '". $per_id ."' AND Per_Year = '".$daies_f[2]."' ";

    $query_period = mssql_query($sql_period);
    $num_period = mssql_num_rows($query_period);

    $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $per_id ."' ";
    $query_per_id = mssql_query($sql_per_id);
    $row_Per_id = mssql_fetch_assoc($query_per_id);

    if(isset($_POST['Check'])){
        $check = $_POST['Check'];
        $view = $_POST['View'];
        $dubble = $_POST['Dubble'];
        $site = $_POST['Site_ID'];
        $pos = $_POST['Pos'];
        $group = $_POST['Group'];
        $period = $_POST['Period'];
        $calcu = $_POST['calcu'];

        $_SESSION['Period_Cal'] = $period;
    } else {
        $check = '0';
    }

    if($_SESSION['Rule'] == 2) {
        if($check == '1') {
            $search = '1';
            if(($period % 12) == 1) {
                $period_check = $period - 1;
                $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' ";
            } else {
                $period_check = $period - 1;
                $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' AND (Per_Year = '".$daies_f[2]."' or Per_Year = '". ($daies_f[2]-1) ."') ";
            }
            $query_periods = mssql_query($sql_periods);
            $num_periods = mssql_num_rows($query_periods);

            $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
            $query_per_id = mssql_query($sql_per_id);
            $row_Per_id = mssql_fetch_assoc($query_per_id);

            $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$period."' ";
            $query_period = mssql_query($sql_period);
            $Periods = mssql_fetch_array($query_period);

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
            }
            if($_SESSION['SuperSite'] == '1') {
                $where = !empty($site)?  " AND S.Site_ID = '". $site ."' " : "";
                $where .= !empty($pos)?  " AND P.Pos_ID = '". $pos ."' " : "";
                $where .= !empty($group)?  " AND G.Group_ID = '". $group ."' " : "";
            }

            $sql = "SELECT
                        E.Em_Age AS age,
                        E.Socie AS Socie,
                        E.Em_People AS people,
                        E.Em_ID as Code,
                        E.Em_Money as Money,
                        E.Em_Titel as Titel,
                        E.Em_Card as Card,
                        E.Em_AccountNumber as Account,
                        E.Em_CashCard as CashCard,
                        SUM(CAST(TP.Total as float)) as Total,
                        SUM(CAST(TP.OTN as float)) as OTN,
                        SUM(CAST(TP.OTE as float)) as OTE,
                        SUM(CAST(TP.TotalOT15 as float)) as total15,
                        SUM(CAST(TP.TotalOT2 as float)) as total2,
                        SUM(CAST(TP.Mny_1 as float)) as Mny_1,
                        SUM(CAST(TP.Mny_2 as float)) as Mny_2,
                        SUM(CAST(TP.Mny_3 as float)) as Mny_3,
                        SUM(CAST(TP.Mny_4 as float)) as Mny_4,
                        SUM(CAST(TP.Mny_5 as float)) as Mny_5,
                        CAST(E.Em_Fullname as Text) as Fullname,
                        CAST(E.Em_Lastname as Text) as Lastname,
                        CAST(S.Site_Name as Text) as Site_Name,
                        G.Group_ID as GroupID,
                        CAST(G.Group_Name as Text) as Group_Name,
                        P.Pos_ID as PosID,
                        CAST(P.Pos_Name as Text) as Pos_Name,
                        S.Site_ID AS Site_ID,
                        E.Em_DateBirthDay AS DateBirthDay
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
                        E.Em_Fullname,E.Em_Lastname,E.Em_Age,E.Em_People,E.Em_ID,E.Em_Money,E.Em_Titel,E.Em_DateBirthDay,S.Site_Name,G.Group_Name,P.Pos_Name,S.Site_ID,E.Socie,G.Group_ID,P.Pos_ID,E.Em_Card,E.Em_AccountNumber,E.Em_CashCard
                    ORDER BY
                        G.Group_Name ";
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
            $date_now = $date_now->format('Y-m-d H:i:s');

            $DT = new datetime($row_check['TDate']);
            $DT = $DT->format('d-m-Y');

            if($num_check == 0) {
                $lable = '0';
                $sql_update_status = "UPDATE
                                        TP
                                    SET
                                        TP.TimePlan_Status = '2',
                                        TP.TimePlan_Date = '". $date_now ."'
                                    FROM
                                        [HRP].[dbo].[Time_Plan] TP
                                        left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                                        left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                                        left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                                        left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                                    WHERE
                                        (TP.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102)) $where";

                mssql_query($sql_update_status);

                $sql_check_period = "SELECT List_ID FROM [HRP].[dbo].[Item_List] WHERE Per_ID <= '".$period."' AND List_Status = '0' ";
                // echo $sql_check_period;
                $q_c_p = mssql_query($sql_check_period);
                $n_c_p = mssql_num_rows($q_c_p);
                $r_c_p = mssql_fetch_array($q_c_p);

                if($n_c_p != 0) {
                    $update_c_p = "UPDATE [HRP].[dbo].[Item_List] set List_Status = '1',List_Update = '". $date_now ."',List_Period = '". $period ."' where Per_ID = '".$period."' ";
                    if($_SESSION['SuperSite'] == '1') {
                        $update_c_p .= " AND Site_ID = '". $site ."' ";
                    }
                    if($_SESSION['SuperSite'] != '1') {
                        $update_c_p .= " AND Site_ID = '". $_SESSION['SuperSite'] ."' ";
                    }
                    mssql_query($update_c_p);
                    // echo $update_c_p.'<br>';
                }
            }
            if($num_check == 1) {
                $lable = '1';
                $daies = $DT;
            }
        }

        if($view == '2') {
            $search = '1';
            if(($period % 12) == 1) {
                $period_check = $period - 1;
                $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' ";
            } else {
                $period_check = $period - 1;
                $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' AND (Per_Year = '".$daies_f[2]."' or Per_Year = '". ($daies_f[2]-1) ."') ";
            }
            $query_periods = mssql_query($sql_periods);
            $num_periods = mssql_num_rows($query_periods);

            $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
            $query_per_id = mssql_query($sql_per_id);
            $row_Per_id = mssql_fetch_assoc($query_per_id);

            $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$period."' ";
            $query_period = mssql_query($sql_period);
            $Periods = mssql_fetch_array($query_period);

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
                        E.Em_Age AS age,
                        E.Socie AS Socie,
                        E.Em_People AS people,
                        E.Em_ID as Code,
                        E.Em_Money as Money,
                        E.Em_Titel as Titel,
                        E.Em_Card as Card,
                        SUM(CAST(TP.Total as float)) as Total,
                        SUM(CAST(TP.OTN as float)) as OTN,
                        SUM(CAST(TP.OTE as float)) as OTE,
                        SUM(CAST(TP.TotalOT15 as float)) as total15,
                        SUM(CAST(TP.TotalOT2 as float)) as total2,
                        SUM(CAST(TP.Mny_1 as float)) as Mny_1,
                        CAST(E.Em_Fullname as Text) as Fullname,
                        CAST(E.Em_Lastname as Text) as Lastname,
                        CAST(S.Site_Name as Text) as Site_Name,
                        G.Group_ID as GroupID,
                        CAST(G.Group_Name as Text) as Group_Name,
                        P.Pos_ID as PosID,
                        CAST(P.Pos_Name as Text) as Pos_Name,
                        S.Site_ID AS Site_ID,
                        E.Em_DateBirthDay AS DateBirthDay
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
                        E.Em_Fullname,E.Em_Lastname,E.Em_Age,E.Em_People,E.Em_ID,E.Em_Money,E.Em_Titel,E.Em_DateBirthDay,S.Site_Name,G.Group_Name,P.Pos_Name,S.Site_ID,E.Socie,G.Group_ID,P.Pos_ID,E.Em_Card
                    ORDER BY
                        G.Group_Name ";
            $query = mssql_query($sql);
            $num = mssql_num_rows($query);

            $sql_check = "SELECT
                            TP.TimePlan_Status,
                            TP.TimePlan_Date as TDate
                        FROM
                            [HRP].[dbo].[Time_Plan] TP
                            left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                            left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                            left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                            left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                        WHERE
                            (TP.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102))
                            AND TP.TimePlan_Status = '2'
                            $where
                        GROUP BY
                            TP.TimePlan_Status,
                            TP.TimePlan_Date ";

            $query_check = mssql_query($sql_check);
            $row_check = mssql_fetch_array($query_check);
            $num_check = $row_check['TimePlan_Status'];
            $DT = new datetime($row_check['TDate']);
            $DT = $DT->format('d-m-Y');

            $sql_check_report = "SELECT MT_Status FROM [HRP].[dbo].[MoneyTotal] ";
            $query_check_report = mssql_query($sql_check_report);
            $row_check_report = mssql_fetch_array($query_check_report);
            $check_report = $row_check_report['MT_Status'];

            $dis = explode('-', $Period_Start);
            $disMonth = ($dis[1] + 1);
            $disToday = $daies_f[0];
            if($disMonth == 1) {
                $disMonth = '01';
            }
            if($disMonth == 2) {
                $disMonth = '02';
            }
            if($disMonth == 3) {
                $disMonth = '03';
            }
            if($disMonth == 4) {
                $disMonth = '04';
            }
            if($disMonth == 5) {
                $disMonth = '05';
            }
            if($disMonth == 6) {
                $disMonth = '06';
            }
            if($disMonth == 7) {
                $disMonth = '07';
            }
            if($disMonth == 8) {
                $disMonth = '08';
            }
            if($disMonth == 9) {
                $disMonth = '09';
            }
            if($disMonth == 13) {
                $disMonth = '01';
            }

            if($check_report == 2) {
                $report = 2;
            } else {
                $report = 1;
            }

            if($num_check == 0) {
                $lable = '2';
            }
            if($num_check == 2) {
                // $lable = '1';
                // $daies = $DT;

                if($period % 2 == 1) {
                    if($daies_f[0] >= '21') {
                        $lable = '3';
                        $daies = $DT;
                    } else {
                        $lable = '1';
                        $daies = $DT;
                    }
                }
                if($period % 2 == 0) {
                    if($daies_f[1] == $disMonth) {
                        if($daies_f[0] >= '06') {
                            $lable = '3';
                            $daies = $DT;
                        }
                    } else {
                        $lable = '1';
                        $daies = $DT;
                    }
                }
            }
        }

        if($Back == '3') {
            $search = '1';
            if(($period % 12) == 1) {
                $period_check = $period - 1;
                $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' ";
            } else {
                $period_check = $period - 1;
                $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' AND (Per_Year = '".$daies_f[2]."' or Per_Year = '". ($daies_f[2]-1) ."') ";
            }
            $query_periods = mssql_query($sql_periods);
            $num_periods = mssql_num_rows($query_periods);

            $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
            $query_per_id = mssql_query($sql_per_id);
            $row_Per_id = mssql_fetch_assoc($query_per_id);

            $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$period."' ";
            $query_period = mssql_query($sql_period);
            $Periods = mssql_fetch_array($query_period);

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

            $sql_update_status = "UPDATE
                                        TP
                                    SET
                                        TP.TimePlan_Status = '1',
                                        TP.TimePlan_Date = '". $date_now ."'
                                    FROM
                                        [HRP].[dbo].[Time_Plan] TP
                                        left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                                        left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                                        left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                                        left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                                    WHERE
                                        (TP.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102)) $where";

            mssql_query($sql_update_status);

            $sql_one = "update
                            [HRP].[dbo].[Item_List]
                        set
                            List_Status = '0'
                        where
                            Per_ID = '". $period ."' and Site_ID = '". $site ."' ";
            mssql_query($sql_one);
            // echo $sql_one.'<br>';

            $sql_two = "update
                            [HRP].[dbo].[Time_Plan]
                        set
                            [HRP].[dbo].[Time_Plan].TimePlan_Status = '0'
                        from
                            [HRP].[dbo].[Time_Plan] t, [HRP].[dbo].[Employees] e
                        where
                            t.Em_ID = e.Em_ID
                            AND (t.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102))
                            AND e.Site_Id = '". $site ."' ";
            mssql_query($sql_two);
            // echo $sql_two.'<br>';

            $delete = "delete FROM [HRP].[dbo].[MoneyTotal] where MT_Period = '". $period ."' and Site_ID = '". $site ."' ";
            mssql_query($delete);
            // echo $delete.'<br>';

            $sql = "SELECT
                        E.Em_Age AS age,
                        E.Socie AS Socie,
                        E.Em_People AS people,
                        E.Em_ID as Code,
                        E.Em_Money as Money,
                        E.Em_Titel as Titel,
                        E.Em_Card as Card,
                        SUM(CAST(TP.Total as float)) as Total,
                        SUM(CAST(TP.OTN as float)) as OTN,
                        SUM(CAST(TP.OTE as float)) as OTE,
                        SUM(CAST(TP.TotalOT15 as float)) as total15,
                        SUM(CAST(TP.TotalOT2 as float)) as total2,
                        SUM(CAST(TP.Mny_1 as float)) as Mny_1,
                        CAST(E.Em_Fullname as Text) as Fullname,
                        CAST(E.Em_Lastname as Text) as Lastname,
                        CAST(S.Site_Name as Text) as Site_Name,
                        G.Group_ID as GroupID,
                        CAST(G.Group_Name as Text) as Group_Name,
                        P.Pos_ID as PosID,
                        CAST(P.Pos_Name as Text) as Pos_Name,
                        S.Site_ID AS Site_ID,
                        E.Em_DateBirthDay AS DateBirthDay
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
                        E.Em_Fullname,E.Em_Lastname,E.Em_Age,E.Em_People,E.Em_ID,E.Em_Money,E.Em_Titel,E.Em_DateBirthDay,S.Site_Name,G.Group_Name,P.Pos_Name,S.Site_ID,E.Socie,G.Group_ID,P.Pos_ID,E.Em_Card
                    ORDER BY
                        G.Group_Name ";
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

            $sql_check_report = "SELECT MT_Status FROM [HRP].[dbo].[MoneyTotal] ";
            $query_check_report = mssql_query($sql_check_report);
            $row_check_report = mssql_fetch_array($query_check_report);
            $check_report = $row_check_report['MT_Status'];

            if($check_report == 2) {
                $report = 2;
            } else {
                $report = 1;
            }

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

    if($_SESSION['Rule'] == 3) {
        if($view == '2') {
            $search = '1';
            if(($period % 12) == 1) {
                $period_check = $period - 1;
                $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' ";
            } else {
                $period_check = $period - 1;
                $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' AND (Per_Year = '".$daies_f[2]."' or Per_Year = '". ($daies_f[2]-1) ."') ";
            }
            $query_periods = mssql_query($sql_periods);
            $num_periods = mssql_num_rows($query_periods);

            $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
            $query_per_id = mssql_query($sql_per_id);
            $row_Per_id = mssql_fetch_assoc($query_per_id);

            $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$period."' ";
            $query_period = mssql_query($sql_period);
            $Periods = mssql_fetch_array($query_period);

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
                        E.Em_Age AS age,
                        E.Socie AS Socie,
                        E.Em_People AS people,
                        E.Em_ID as Code,
                        E.Em_Money as Money,
                        E.Em_Titel as Titel,
                        E.Em_Card as Card,
                        SUM(CAST(TP.Total as float)) as Total,
                        SUM(CAST(TP.OTN as float)) as OTN,
                        SUM(CAST(TP.OTE as float)) as OTE,
                        SUM(CAST(TP.TotalOT15 as float)) as total15,
                        SUM(CAST(TP.TotalOT2 as float)) as total2,
                        SUM(CAST(TP.Mny_1 as float)) as Mny_1,
                        CAST(E.Em_Fullname as Text) as Fullname,
                        CAST(E.Em_Lastname as Text) as Lastname,
                        CAST(S.Site_Name as Text) as Site_Name,
                        G.Group_ID as GroupID,
                        CAST(G.Group_Name as Text) as Group_Name,
                        P.Pos_ID as PosID,
                        CAST(P.Pos_Name as Text) as Pos_Name,
                        S.Site_ID AS Site_ID,
                        E.Em_DateBirthDay AS DateBirthDay
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
                        E.Em_Fullname,E.Em_Lastname,E.Em_Age,E.Em_People,E.Em_ID,E.Em_Money,E.Em_Titel,E.Em_DateBirthDay,S.Site_Name,G.Group_Name,P.Pos_Name,S.Site_ID,E.Socie,G.Group_ID,P.Pos_ID,E.Em_Card
                    ORDER BY
                        G.Group_Name ";
            $query = mssql_query($sql);
            $num = mssql_num_rows($query);

            $sql_check = "SELECT
                            TP.TimePlan_Status,
                            TP.TimePlan_Date as TDate
                        FROM
                            [HRP].[dbo].[Time_Plan] TP
                            left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                            left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                            left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                            left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                        WHERE
                            (TP.LogTime BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102))
                            AND TP.TimePlan_Status = '2'
                            $where
                        GROUP BY
                            TP.TimePlan_Status,
                            TP.TimePlan_Date ";

            $query_check = mssql_query($sql_check);
            $row_check = mssql_fetch_array($query_check);
            $num_check = $row_check['TimePlan_Status'];
            $DT = new datetime($row_check['TDate']);
            $DT = $DT->format('d-m-Y');

            $sql_check_report = "SELECT MT_Status FROM [HRP].[dbo].[MoneyTotal] ";
            $query_check_report = mssql_query($sql_check_report);
            $row_check_report = mssql_fetch_array($query_check_report);
            $check_report = $row_check_report['MT_Status'];

            if($check_report == 2) {
                $report = 2;
            } else {
                $report = 1;
            }

            if($num_check == 0) {
                $lable = '2';
            }
            if($num_check == 2) {
                $lable = '1';
                $daies = $DT;
            }
        }
    }
?>
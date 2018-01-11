<?php
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
      $per_idm = $row_per['Per_ID'] - 1;

      $sql_period = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods]";
      if(empty($_SESSION['SubPeriod'])) {
            $sql_period .= "WHERE Per_ID >= '". $per_idm ."' AND Per_ID != '". $per_id ."' ";
      } else {
            $sql_period .= "WHERE Per_ID >= '". $_SESSION['SubPeriod'] ."' AND Per_ID != '". $_SESSION['SubPeriod'] ."' ";
      }
      $query_period = mssql_query($sql_period);
      $num_period = mssql_num_rows($query_period);

      $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] ";
      if(empty($_SESSION['SubPeriod'])) {
            $sql_per_id .= "WHERE Per_ID = '". $per_id ."' ";
      } else {
            $sql_per_id .= "WHERE Per_ID = '". $_SESSION['SubPeriod'] ."' ";
      }
      $query_per_id = mssql_query($sql_per_id);
      $row_Per_id = mssql_fetch_assoc($query_per_id);

      if(isset($_POST['Check'])){
            $check = $_POST['Check'];
            $See = $_POST['See'];
            $site = $_POST['Site_ID'];
            $names = $_POST['name'];
            $group = $_POST['group'];
            if($_POST['Time'] == 1) {
                  $period = $_POST['Period'];
                  $start = '';
                  $end = '';
                  $_SESSION['Time'] = $_POST['Time'];
            }
            if($_POST['Time'] == 2) {
                  $period = '';
                  $start = $_POST['start'];
                  $end = $_POST['end'];
                  $_SESSION['Time'] = $_POST['Time'];
            }
            $_SESSION['SubPeriod'] = $period;
            $_SESSION['SubName'] = $names;
            $_SESSION['SubGroup'] = $group;

            if($_SESSION['SuperSite'] != '1') {
                  $where = " WHERE (TB1.Site_ID = '". $_SESSION['SuperSite'] ."') ";
            } else {
                  if($site != $_SESSION['SuperSite']) {
                        $where = " WHERE (TB1.Site_ID = '". $site ."') ";
                  } else {
                        $where = " WHERE (TB1.Site_ID != '". $_SESSION['SuperSite'] ."') ";
                  }
            }

            if($names != '') {
                  $where .= " AND (TB1.Em_ID = '". $names ."') ";
            } else {
                  $where .= " AND (TB1.Em_ID != '". $names ."') ";
            }

            if($group != '') {
                  $where .= " AND (TB1.Group_ID = '". $group ."') ";
            } else {
                  $where .= " AND (TB1.Group_ID != '". $group ."') ";
            }

            if($See == 'ทั้งหมด') {
                  $_SESSION['SubSee'] = 'ทั้งหมด';
            }
            if($See == 'มีเวลา') {
                  $where .= " AND (TB2_1.CK_in != '') ";
                  $_SESSION['SubSee'] = 'มีเวลา';
            }
            if($See == 'ไม่มีเวลา') {
                  $where .= " AND (TB2_1.CK_in IS NULL) ";
                  $_SESSION['SubSee'] = 'ไม่มีเวลา';
            }

            $_SESSION['SubWhere'] = $where;
      } else {
            if(!empty($_GET['Check'])){
                  $check = '2';
            }else{
                  $check = '0';
            }
      }

      if($check == '1') {
            $search = '1';
            if($_POST['Time'] == 1) {
                  $period_check = $period - 1;
                  $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check ."' AND Per_ID != '". $period ."' ";
                  $query_periods = mssql_query($sql_periods);
                  $num_periods = mssql_num_rows($query_periods);

                  $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
                  $query_per_id = mssql_query($sql_per_id);
                  $row_Per_id = mssql_fetch_assoc($query_per_id);

                  $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$period."' ";
                  $query_period = mssql_query($sql_period);
                  $Periods = mssql_fetch_array($query_period);
                  $Period_Start = new datetime($Periods['StartDate']);
                  $Period_Start = $Period_Start->format('Y-m-d');
                  $Period_End = new datetime($Periods['EndDate']);
                  $Period_End = $Period_End->format('Y-m-d');
                  $_SESSION['SubStart'] = $Period_Start;
                  $_SESSION['SubEnd'] = $Period_End;

                  $s_pe = " SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $period ."' ";
                  $q_pe = mssql_query($s_pe);
                  $r_pe = mssql_fetch_array($q_pe);
            }
            if($_POST['Time'] == 2) {
                  $Period_Start = new datetime($start);
                  $Period_Start = $Period_Start->format('Y-m-d');
                  $Period_End = new datetime($end);
                  $Period_End = $Period_End->format('Y-m-d');
                  $_SESSION['SubStart'] = $Period_Start;
                  $_SESSION['SubEnd'] = $Period_End;
            }

            $sql_s = " SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $site ."' ";
            $q_s = mssql_query($sql_s);
            $r_s = mssql_fetch_array($q_s);

            $sql_n = " SELECT Em_ID, CAST(Em_Fullname AS Text) AS Fullname, CAST(Em_Lastname AS Text) AS Lastname FROM [HRP].[dbo].[Employees] WHERE Em_ID = '". $names ."' ";
            $q_n = mssql_query($sql_n);
            $r_n = mssql_fetch_array($q_n);

            $sql_g = " SELECT Group_ID, CAST(Group_Name as Text) AS Name FROM [HRP].[dbo].[Group] WHERE Group_ID = '". $group ."' GROUP BY Group_ID, Group_Name ";
            $q_g = mssql_query($sql_g);
            $r_g = mssql_fetch_array($q_g);

            $sql = "SELECT
                        TB1.Date_,
                        TB1.Em_ID AS Em_ID,
                        TB1.Group_ID AS Group_ID,
                        TB1.Em_Fullname AS Fullname,
                        TB1.Em_Lastname AS Lastname,
                        TB1.Em_Titel,
                        TB2_1.LogTime,
                        TB2_1.CK_in,
                        TB2_1.Ck_Out1,
                        TB2_1.CK_in2,
                        TB2_1.Ck_Out2,
                        TB2_1.CKOT_in1,
                        TB2_1.CKOT_Out1,
                        TB2_1.CKOT_in2,
                        TB2_1.CKOT_Out2,
                        TB2_1.Total,
                        TB2_1.OTN,
                        TB2_1.OTE,
                        TB2_1.TotalOT15,
                        TB2_1.TotalOT2,
                        TB2_1.TimePlan_Status
                  FROM
                        (SELECT
                              dbo.Time_Plan.CK_in,
                              dbo.Time_Plan.Ck_Out1,
                              dbo.Time_Plan.CK_in2,
                              dbo.Time_Plan.Ck_Out2,
                              dbo.Time_Plan.CKOT_in1,
                              dbo.Time_Plan.CKOT_Out1,
                              dbo.Time_Plan.CKOT_in2,
                              dbo.Time_Plan.CKOT_Out2,
                              dbo.Time_Plan.Total,
                              dbo.Time_Plan.OTN,
                              dbo.Time_Plan.OTE,
                              dbo.Time_Plan.TotalOT15,
                              dbo.Time_Plan.TotalOT2,
                              dbo.Time_Plan.FingerID,
                              dbo.Time_Plan.LogTime,
                              dbo.Time_Plan.Em_ID,
                              dbo.Time_Plan.TimePlan_Status
                        FROM
                              dbo.PlanTime CROSS JOIN dbo.Time_Plan
                        GROUP BY
                              dbo.Time_Plan.CK_in,
                              dbo.Time_Plan.Ck_Out1,
                              dbo.Time_Plan.CK_in2,
                              dbo.Time_Plan.Ck_Out2,
                              dbo.Time_Plan.CKOT_in1,
                              dbo.Time_Plan.CKOT_Out1,
                              dbo.Time_Plan.CKOT_in2,
                              dbo.Time_Plan.CKOT_Out2,
                              dbo.Time_Plan.Total,
                              dbo.Time_Plan.OTN,
                              dbo.Time_Plan.OTE,
                              dbo.Time_Plan.TotalOT15,
                              dbo.Time_Plan.TotalOT2,
                              dbo.Time_Plan.FingerID,
                              dbo.Time_Plan.LogTime,
                              dbo.Time_Plan.Em_ID,
                              dbo.Time_Plan.TimePlan_Status ) AS TB2_1
                  RIGHT OUTER JOIN
                        (SELECT
                              E.Em_ID,
                              E.Group_ID,
                              E.Em_Fullname,
                              E.Em_Lastname,
                              E.Em_Titel,
                              E.Site_ID,
                              D.Date_
                        FROM
                              dbo.Datetable AS D CROSS JOIN dbo.Employees AS E
                        WHERE
                              (D.Date_ BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102))
                              AND Em_Status = 'W'
                        GROUP BY
                              E.Em_ID,
                              E.Group_ID,
                              E.Em_Fullname,
                              E.Em_Lastname,
                              E.Em_Titel,
                              E.Site_ID,
                              D.Date_) AS TB1 ON TB2_1.Em_ID = TB1.Em_ID AND TB2_1.LogTime = TB1.Date_
                  $where
                  GROUP BY
                        TB1.Date_,
                        TB1.Em_ID,
                        TB1.Group_ID,
                        TB1.Em_Fullname,
                        TB1.Em_Lastname,
                        TB1.Em_Titel,
                        TB2_1.LogTime,
                        TB2_1.CK_in,
                        TB2_1.Ck_Out1,
                        TB2_1.CK_in2,
                        TB2_1.Ck_Out2,
                        TB2_1.CKOT_in1,
                        TB2_1.CKOT_Out1,
                        TB2_1.CKOT_in2,
                        TB2_1.CKOT_Out2,
                        TB2_1.Total,
                        TB2_1.OTN,
                        TB2_1.OTE,
                        TB2_1.TotalOT15,
                        TB2_1.TotalOT2,
                        TB2_1.TimePlan_Status
                  ORDER By
                        TB1.Em_Fullname,
						TB1.Em_Lastname,
						TB1.Date_ ";

            $query = mssql_query($sql);
            $num = mssql_num_rows($query);
      }
      if($check == '2') {
            $search = '1';
            $period_check2 = $_SESSION['SubPeriod'] - 1;
            $sql_periods = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID >= '". $period_check2 ."' AND Per_ID != '". $_SESSION['SubPeriod'] ."' ";
            $query_periods = mssql_query($sql_periods);
            $num_periods = mssql_num_rows($query_periods);

            $sql_per_id = "SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $_SESSION['SubPeriod'] ."' ";
            $query_per_id = mssql_query($sql_per_id);
            $row_Per_id = mssql_fetch_assoc($query_per_id);

            $sql_period = "SELECT Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$_SESSION['SubPeriod']."' ";
            $query_period = mssql_query($sql_period);
            $Periods = mssql_fetch_array($query_period);

            $period = $_SESSION['SubPeriod'];
            $names = $_SESSION['SubName'];
            $group = $_SESSION['SubGroup'];
            $s_pe = " SELECT Per_ID, Per_StartDate, Per_EndDate, Per_Week FROM [HRP].[dbo].[Periods] WHERE Per_ID = '". $_SESSION['SubPeriod'] ."' ";
            $q_pe = mssql_query($s_pe);
            $r_pe = mssql_fetch_array($q_pe);

            $sql_n = " SELECT Em_ID, CAST(Em_Fullname AS Text) AS Fullname, CAST(Em_Lastname AS Text) AS Lastname FROM [HRP].[dbo].[Employees] WHERE Em_ID = '". $names ."' ";
            $q_n = mssql_query($sql_n);
            $r_n = mssql_fetch_array($q_n);

            $whereS = $_SESSION['SubWhere'];
            $cp_sql = "SELECT
                        TB1.Date_,
                        TB1.Em_ID AS Em_ID,
                        TB1.Group_ID AS Group_ID,
                        TB1.Em_Fullname AS Fullname,
                        TB1.Em_Lastname AS Lastname,
                        TB1.Em_Titel,
                        TB2_1.LogTime,
                        TB2_1.CK_in,
                        TB2_1.Ck_Out1,
                        TB2_1.CK_in2,
                        TB2_1.Ck_Out2,
                        TB2_1.CKOT_in1,
                        TB2_1.CKOT_Out1,
                        TB2_1.CKOT_in2,
                        TB2_1.CKOT_Out2,
                        TB2_1.Total,
                        TB2_1.OTN,
                        TB2_1.OTE,
                        TB2_1.TotalOT15,
                        TB2_1.TotalOT2,
                        TB2_1.TimePlan_Status
                  FROM
                        (SELECT
                              dbo.Time_Plan.CK_in,
                              dbo.Time_Plan.Ck_Out1,
                              dbo.Time_Plan.CK_in2,
                              dbo.Time_Plan.Ck_Out2,
                              dbo.Time_Plan.CKOT_in1,
                              dbo.Time_Plan.CKOT_Out1,
                              dbo.Time_Plan.CKOT_in2,
                              dbo.Time_Plan.CKOT_Out2,
                              dbo.Time_Plan.Total,
                              dbo.Time_Plan.OTN,
                              dbo.Time_Plan.OTE,
                              dbo.Time_Plan.TotalOT15,
                              dbo.Time_Plan.TotalOT2,
                              dbo.Time_Plan.FingerID,
                              dbo.Time_Plan.LogTime,
                              dbo.Time_Plan.Em_ID,
                              dbo.Time_Plan.TimePlan_Status
                        FROM
                              dbo.PlanTime CROSS JOIN dbo.Time_Plan
                        GROUP BY
                              dbo.Time_Plan.CK_in,
                              dbo.Time_Plan.Ck_Out1,
                              dbo.Time_Plan.CK_in2,
                              dbo.Time_Plan.Ck_Out2,
                              dbo.Time_Plan.CKOT_in1,
                              dbo.Time_Plan.CKOT_Out1,
                              dbo.Time_Plan.CKOT_in2,
                              dbo.Time_Plan.CKOT_Out2,
                              dbo.Time_Plan.Total,
                              dbo.Time_Plan.OTN,
                              dbo.Time_Plan.OTE,
                              dbo.Time_Plan.TotalOT15,
                              dbo.Time_Plan.TotalOT2,
                              dbo.Time_Plan.FingerID,
                              dbo.Time_Plan.LogTime,
                              dbo.Time_Plan.Em_ID,
                              dbo.Time_Plan.TimePlan_Status) AS TB2_1
                  RIGHT OUTER JOIN
                        (SELECT
                              E.Em_ID,
                              E.Group_ID,
                              E.Em_Fullname,
                              E.Em_Lastname,
                              E.Em_Titel,
                              E.Site_ID,
                              D.Date_
                        FROM
                              dbo.Datetable AS D CROSS JOIN dbo.Employees AS E
                        WHERE
                              (D.Date_ BETWEEN CONVERT(DATETIME, '". $_SESSION['SubStart'] ."', 102) AND CONVERT(DATETIME, '". $_SESSION['SubEnd'] ."', 102))
                              AND Em_Status = 'W'
                        GROUP BY
                              E.Em_ID,
                              E.Group_ID,
                              E.Em_Fullname,
                              E.Em_Lastname,
                              E.Em_Titel,
                              E.Site_ID,
                              D.Date_) AS TB1 ON TB2_1.Em_ID = TB1.Em_ID AND TB2_1.LogTime = TB1.Date_
                  $whereS
                  GROUP BY
                        TB1.Date_,
                        TB1.Em_ID,
                        TB1.Group_ID,
                        TB1.Em_Fullname,
                        TB1.Em_Lastname,
                        TB1.Em_Titel,
                        TB2_1.LogTime,
                        TB2_1.CK_in,
                        TB2_1.Ck_Out1,
                        TB2_1.CK_in2,
                        TB2_1.Ck_Out2,
                        TB2_1.CKOT_in1,
                        TB2_1.CKOT_Out1,
                        TB2_1.CKOT_in2,
                        TB2_1.CKOT_Out2,
                        TB2_1.Total,
                        TB2_1.OTN,
                        TB2_1.OTE,
                        TB2_1.TotalOT15,
                        TB2_1.TotalOT2,
                        TB2_1.TimePlan_Status
                  ORDER By
                        TB1.Em_Fullname,
						TB1.Em_Lastname,
						TB1.Date_ ";

            $query = mssql_query($cp_sql);
            $num = mssql_num_rows($query);
      }
?>
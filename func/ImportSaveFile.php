<?php
    @session_start();
    include("../inc/connect.php");
    ini_set('max_execution_time', 600);
    $filUpload = $_FILES['filUpload']['name'];
    $dates = date('Y-m-d'); // วันที่ปัจจุบัน
    $date = explode('-', $dates);
    $a = 0;

    // $th = mktime(0, 0, 0, $date[1], $date[2]-16, $date[0]); // ตั้งค่าให้ถอยหลัง7  วัน
	$th = mktime(0, 0, 0, $date[1], $date[2]-7, $date[0]); // ตั้งค่าให้ถอยหลัง7  วัน
    $format="Y-m-d";
    $str=date($format,$th);

    // $filestring = file('../Log_Time/'.$filUpload);
    $filestring = file($_FILES['filUpload']['tmp_name']);
    foreach ($filestring as $value) {
        $file = explode('	', $value);

        // echo $file[0].'-'.$file[1].'<br>';

        $aaa = new DateTime($file[1]);
        $day = $aaa->format('Y-m-d');
        $se = $aaa->format('H:i:s');

        $CK_in = '';
        $Ck_Out1 = '';
        $CK_in2 = '';
        $Ck_Out2 = '';
        $CKOT_in1 = '';
        $CKOT_Out1 = '';
        $CKOT_in2 = '';
        $CKOT_Out2 = '';

        $fileCode = explode(' ', $file[0]);
        if($fileCode[0] != '') {
            $CodeID = $fileCode[0];
        }
        if($fileCode[1] != '') {
            $CodeID = $fileCode[1];
        }
        if($fileCode[2] != '') {
            $CodeID = $fileCode[2];
        }
        if($fileCode[3] != '') {
            $CodeID = $fileCode[3];
        }
        if($fileCode[4] != '') {
            $CodeID = $fileCode[4];
        }
        if($fileCode[5] != '') {
            $CodeID = $fileCode[5];
        }
        if($fileCode[6] != '') {
            $CodeID = $fileCode[6];
        }
        if($fileCode[7] != '') {
            $CodeID = $fileCode[7];
        }
        if($fileCode[8] != '') {
            $CodeID = $fileCode[8];
        }
        if($fileCode[9] != '') {
            $CodeID = $fileCode[9];
        }
        if($fileCode[10] != '') {
            $CodeID = $fileCode[10];
        }

        $sql_c_s = "SELECT
                        CAST(m_site as Text) as m_site
                    FROM
                        [HRP].[dbo].[Users]
                    WHERE
                        m_user = '". $_SESSION['user_name'] ."' ";

        $query_c_s = mssql_query($sql_c_s);
        $num_c_s = mssql_num_rows($query_c_s);
        $row_c_s = mssql_fetch_array($query_c_s);

        $es = explode(',', $row_c_s['m_site']);

        foreach ($es as $key => $value) {
            if($key == 0) {
                $Wsite = " AND Site_ID = '". $value ."' ";
            } else {
                $Wsite .= " OR Site_ID = '". $value ."' ";
            }
        }

        $hhh = explode('AND ', $Wsite);
        $Wsite = 'AND ('.$hhh[1].')';

        // $sql_check_em = "SELECT Em_ID FROM [HRP].[dbo].[Employees] WHERE Em_ID = '". $CodeID ."' AND Site_ID = '". $_SESSION['SuperSite'] ."' ";
        $sql_check_em = "SELECT Em_ID, Em_DayCost FROM [HRP].[dbo].[Employees] WHERE Em_ID = '". $CodeID ."' $Wsite ";
        $query_check_em = mssql_query($sql_check_em);
        $num_check_em = mssql_num_rows($query_check_em);
        $row_check_em = mssql_fetch_assoc($query_check_em);
        // echo $sql_check_em.'<br>';

        // echo $se.'<br>';
        // echo $CodeID.'-'.$day.'-'.$num_check_em.'<br>';

        foreach ($es as $key => $values) {
            if($key == 0) {
                $Wsites = " AND p.Site_ID = '". $values ."' ";
            } else {
                $Wsites .= " OR p.Site_ID = '". $values ."' ";
            }
        }

        $hhhs = explode('AND ', $Wsites);
        $Wsites = 'AND ('.$hhhs[1].')';

        $plan = "SELECT
                    p.TimePlan_LateTime,
                    p.CK_in as planIn,
                    p.Ck_Out1 as planOut,
                    p.CK_in2 as planIn2,
                    p.Ck_Out2 as planOut2,
                    p.CKOT_in1 as planOTin1,
                    p.CKOT_Out1 as planOTout1,
                    p.CKOT_in2 as planOTin2,
                    p.CKOT_Out2 as planOTout2
                FROM
                    [HRP].[dbo].[Employees] e inner join
                    [HRP].[dbo].[PlanTime] p on e.Site_ID = p.Site_ID
                WHERE
                    e.Em_ID = '". $CodeID ."'
                    AND p.TimePlan_Status = '1'
                    $Wsites ";

        $query_plan = mssql_query($plan);
        $num_plan = mssql_num_rows($query_plan);
        
        if($row_check_em['Em_DayCost'] == 'Month') {
            if($num_check_em != 0) {
                if(($day > $str) && ($day <= $dates)) {
                    $sql_check = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
                    $query = mssql_query($sql_check);
                    $num = mssql_num_rows($query);

                    if($num == 0) {
                        $num_se = explode(':', $se);
                        $Month = ($num_se[0] * 60) + $num_se[1];

                        if($Month <= '720'){
                            $CK_in = $se;

                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
                            $query_check_2 = mssql_query($sql_check_2);
                            $num_check_2 = mssql_num_rows($query_check_2);

                            if($num_check_2 == 0) {
                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Late, TimePlan_Cal_Status) 
                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '". $check_late ."', '0')";

                                mssql_query($sql_insert);
                                // echo $sql_insert.'<br>';
                            }
                        }
                        if($Month >= '1020'){
                            $Ck_Out2 = $se;

                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
                            $query_check_2 = mssql_query($sql_check_2);
                            $num_check_2 = mssql_num_rows($query_check_2);

                            if($num_check_2 == 0) {
                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Late, TimePlan_Cal_Status) 
                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '". $check_late ."', '0')";

                                mssql_query($sql_insert);
                                // echo $sql_insert.'<br>';
                            }
                        }
                    } else {
                        $num_se = explode(':', $se);
                        $Month = ($num_se[0] * 60) + $num_se[1];

                        if($Month <= '720'){
                            $CK_in = $se;

                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND CK_in = '' ";
                            $query_check_2 = mssql_query($sql_check_2);
                            $num_check_2 = mssql_num_rows($query_check_2);
                            
                            if($num_check_2 == 1) {
                                $sql_edit = "UPDATE 
                                            [HRP].[dbo].[Time_Plan]
                                        SET
                                            CK_in = '". $CK_in ."'
                                        WHERE
                                            Em_ID = '". $CodeID ."'
                                            AND LogTime = '". $day ."' ";

                                // mssql_query($sql_edit);
                                // echo $sql_edit.'<br>';
                            }
                        }
                        if($Month >= '1020') {
                            $Ck_Out2 = $se;

                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
                            $query_check_2 = mssql_query($sql_check_2);
                            $num_check_2 = mssql_num_rows($query_check_2);
                            
                            if($num_check_2 == 1) {
                                $sql_edit = "UPDATE 
                                            [HRP].[dbo].[Time_Plan]
                                        SET
                                            Ck_Out2 = '". $Ck_Out2 ."'
                                        WHERE
                                            Em_ID = '". $CodeID ."'
                                            AND LogTime = '". $day ."' ";

                                mssql_query($sql_edit);
                                // echo $sql_edit.'<br>';
                            }
                        }
                    }
                }
            }
        }
        if($row_check_em['Em_DayCost'] == 'Day') {
            if($num_check_em != 0) {
            	if($num_plan != 0) {
            		$row_plan = mssql_fetch_array($query_plan);

            		$a = explode(':', $row_plan['planIn']);
            		$aa = ($a[0] * 60) + $a[1];
            		$b = explode(':', $row_plan['planOut']);
            		$bb = ($b[0] * 60) + $b[1];
            		$c = explode(':', $row_plan['planIn2']);
            		$cc = ($c[0] * 60) + $c[1];
            		$d = explode(':', $row_plan['planOut2']);
            		$dd = ($d[0] * 60) + $d[1];
            		$e = explode(':', $row_plan['planOTin1']);
            		$ee = ($e[0] * 60) + $e[1];
            		$f = explode(':', $row_plan['planOTout1']);
            		$ff = ($f[0] * 60) + $f[1];
            		$g = explode(':', $row_plan['planOTin2']);
            		$gg = ($g[0] * 60) + $g[1];
            		$h = explode(':', $row_plan['planOTout2']);
            		$hh = ($h[0] * 60) + $h[1];

	                if(($day > $str) && ($day <= $dates)) {
	                    // echo $CodeID.'-'.$day.'-'.$se.'<br>';
	                    $sql_check = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                    $query = mssql_query($sql_check);
	                    $num = mssql_num_rows($query);
	                    
	                    // echo $sql_check.'-'.$num.'<br>';

	                    if($num == 0) {
	                        $num_se = explode(':', $se);
	                        $Day_Time = ($num_se[0] * 60) + $num_se[1];

	                        if($Day_Time >= ($hh - 30) && $Day_Time < ($bb - 15)) {
	                            $CK_in = $se;

	                            if($se > '07:45') {
	                                $late = explode(':', $se);
	                                $check_late = ((($late[0] * 60 ) + $late[1]) - 465);
	                            } else {
	                                $check_late = '0';
	                            }

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Late, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '". $check_late ."', '0')";

	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($bb - 15) && $Day_Time < ($cc - 15)) {
	                            $CK_in = $se;

	                            if($se > '07:45') {
	                                $late = explode(':', $se);
	                                $check_late = ((($late[0] * 60 ) + $late[1]) - 465);
	                            } else {
	                                $check_late = '0';
	                            }

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Late, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '". $check_late ."', '0')";

	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($cc - 15) && $Day_Time < ($cc + 30)) {
	                            $CK_in2 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($cc + 30) && $Day_Time < ($ee - 15)) {
	                            $Ck_Out2 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($ee - 15) && $Day_Time < ($ee + 15)) {
	                            $CKOT_in1 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($ee + 15) && $Day_Time <= $ff) {
	                            $CKOT_Out1 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if($Day_Time >= $gg && $Day_Time < ($gg + 15)) {
	                            $CKOT_in2 = $se;

	                            $dayEX = explode('-', $day);

	                            $days = ($dayEX[2] - 1);
	                            if(strlen($days) == '1') {
	                                $days = '0'.$days;
	                            }else{
	                                $days = $days;
	                            }

	                            $a = '';

	                            if($days == '00') {
	                                $a = ($dayEX[1] - 1);
	                                if(strlen($a) == '1') {
	                                    $a = '0'.$a;
	                                }

	                                if($a == '02') {
	                                    $days = '28';
	                                }
	                                if($a == '01' || $a == '03' || $a == '05' || $a == '07' || $a == '08' || $a == '10' || $a == '12') {
	                                    $days = '31';
	                                }
	                                if($a == '04' || $a == '06' || $a == '09' || $a == '11') {
	                                    $days = '30';
	                                }
	                            } else {
	                                $a = $dayEX[1];
	                            }

	                            $days = $dayEX[0].'-'.$a.'-'.$days;
	                            
	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $days ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $days ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            } else {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_in2 = '". $CKOT_in2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $days ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($gg + 15) && $Day_Time < ($hh - 30)) {
	                            $CKOT_Out2 = $se;

	                            $dayEX = explode('-', $day);

	                            $days = ($dayEX[2] - 1);
	                            if(strlen($days) == '1') {
	                                $days = '0'.$days;
	                            }else{
	                                $days = $days;
	                            }

	                            $a = '';

	                            if($days == '00') {
	                                $a = ($dayEX[1] - 1);
	                                if(strlen($a) == '1') {
	                                    $a = '0'.$a;
	                                }

	                                if($a == '02') {
	                                    $days = '28';
	                                }
	                                if($a == '01' || $a == '03' || $a == '05' || $a == '07' || $a == '08' || $a == '10' || $a == '12') {
	                                    $days = '31';
	                                }
	                                if($a == '04' || $a == '06' || $a == '09' || $a == '11') {
	                                    $days = '30';
	                                }
	                            } else {
	                                $a = $dayEX[1];
	                            }

	                            $days = $dayEX[0].'-'.$a.'-'.$days;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $days ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $days ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            } else {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_Out2 = '". $CKOT_Out2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $days ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                    } else {
	                        $num_se = explode(':', $se);
	                        $Day_Time = ($num_se[0] * 60) + $num_se[1];

                            if($Day_Time >= ($hh - 30) && $Day_Time < ($bb - 15)) {
                                $CK_in = $se;

                                $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
                                $query_check_2 = mssql_query($sql_check_2);
                                $num_check_2 = mssql_num_rows($query_check_2);

                                if($num_check_2 == 1) {
                                    // echo 'UPDATE..'.'<br/>';
                                    $sql_edit = "UPDATE
                                                    [HRP].[dbo].[Time_Plan]
                                                SET
                                                    CK_in = '". $CK_in ."'
                                                WHERE
                                                    Em_ID = '". $CodeID ."'
                                                    AND LogTime = '". $day ."' ";

                                    // mssql_query($sql_edit);
                                    // echo $sql_edit.'<br>';
                                }
                            }
	                        if($Day_Time >= ($bb - 15) && $Day_Time < ($cc - 15)) {
	                            $Ck_Out1 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 1) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                Ck_Out1 = '". $Ck_Out1 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($cc - 15) && $Day_Time < ($cc + 30)) {
	                            $CK_in2 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND CK_in2 = '' AND CK_in2 = ' ' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CK_in2 = '". $CK_in2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= ($cc + 30)) && ($Day_Time < ($dd+15))) {
	                            $Ck_Out2 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND Ck_Out2 = '' AND Ck_Out2 = ' ' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                Ck_Out2 = '". $Ck_Out2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($ee - 15) && $Day_Time < ($ee + 15)) {
	                            $CKOT_in1 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND CKOT_in1 = '' AND CKOT_in1 = ' ' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_in1 = '". $CKOT_in1 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($ee + 15) && $Day_Time <= $ff) {
	                            $CKOT_Out1 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_Out1 = '". $CKOT_Out1 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if($Day_Time >= $gg && $Day_Time < ($gg + 15)) {
	                            $CKOT_in2 = $se;

	                            $dayEX = explode('-', $day);
	                            $days = $dayEX[0].'-'.$dayEX[1].'-'.($dayEX[2] - 1);

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $days ."' AND CKOT_in2 = ''  AND CKOT_in2 = ' ' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_in2 = '". $CKOT_in2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $days ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if($Day_Time >= ($gg + 15) && $Day_Time < ($hh - 30)) {
	                            $CKOT_Out2 = $se;

	                            $dayEX = explode('-', $day);
	                            $days = $dayEX[0].'-'.$dayEX[1].'-'.($dayEX[2] - 1);

	                            // echo $day.'<br>';

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $days ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_in2 = '00:00:00',
	                                                CKOT_Out2 = '". $CKOT_Out2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $days ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if($CKOT_Out2 != '') {
	                            $CKOT_in2 = '00:00';
	                        }
	                    }

                        $sql_search = "SELECT * FROM [HRP].[dbo].[Log_Time] WHERE Em_ID = '".$CodeID."' AND ScanDate = '".$file[1]. "' ";
                        $querys = mssql_query($sql_search);
                        $nums = mssql_num_rows($querys);

                        if($nums == 0) {
                            $sql = " INSERT INTO [HRP].[dbo].[Log_Time] (Em_ID,ScanDate,FingerID,TimeInsert) VALUES ('$CodeID','$file[1]','$file[4]','$dates') ";
                            mssql_query($sql);
                        }

                        if($_SESSION['Rule'] == '3') {
                            $updateCheckWork = "UPDATE
                                                    [HRP].[dbo].[AuditWorkDay]
                                                SET 
                                                    Check_in = '1'
                                                WHERE
                                                    Check_day = '". $dates ."' ";
                            mssql_query($updateCheckWork);
                        }
	                }
            	} else {
	                if(($day > $str) && ($day <= $dates)) {
	                    // echo $CodeID.'-'.$day.'-'.$se.'<br>';
	                    $sql_check = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                    $query = mssql_query($sql_check);
	                    $num = mssql_num_rows($query);
	                    
	                    // echo $sql_check.'-'.$num.'<br>';

	                    if($num == 0) {
	                        $num_se = explode(':', $se);
	                        $Day_Time = ($num_se[0] * 60) + $num_se[1];

	                        if(($Day_Time >= '270') && ($Day_Time < '705')) {
	                            $CK_in = $se;

	                            if($se > '07:45') {
	                                $late = explode(':', $se);
	                                $check_late = ((($late[0] * 60 ) + $late[1]) - 465);
	                            } else {
	                                $check_late = '0';
	                            }

	                            $sql_check_2 = "SELECT CK_in FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Late, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '". $check_late ."', '0')";

	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '705') && ($Day_Time < '765')) {
	                            $CK_in = $se;

	                            if($se > '07:45') {
	                                $late = explode(':', $se);
	                                $check_late = ((($late[0] * 60 ) + $late[1]) - 465);
	                            } else {
	                                $check_late = '0';
	                            }

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Late, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '". $check_late ."', '0')";

	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '765') && ($Day_Time < '810')) {
	                            $CK_in2 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '810') && ($Day_Time < '1095')) {
	                            $Ck_Out2 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '1095') && ($Day_Time < '1110')) {
	                            $CKOT_in1 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '1110') && ($Day_Time < '1439')) {
	                            $CKOT_Out1 = $se;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '0') && ($Day_Time < '15')) {
	                            $CKOT_in2 = $se;

	                            $dayEX = explode('-', $day);

	                            $days = ($dayEX[2] - 1);
	                            if(strlen($days) == '1') {
	                                $days = '0'.$days;
	                            }else{
	                                $days = $days;
	                            }

	                            $a = '';

	                            if($days == '00') {
	                                $a = ($dayEX[1] - 1);
	                                if(strlen($a) == '1') {
	                                    $a = '0'.$a;
	                                }

	                                if($a == '02') {
	                                    $days = '28';
	                                }
	                                if($a == '01' || $a == '03' || $a == '05' || $a == '07' || $a == '08' || $a == '10' || $a == '12') {
	                                    $days = '31';
	                                }
	                                if($a == '04' || $a == '06' || $a == '09' || $a == '11') {
	                                    $days = '30';
	                                }
	                            } else {
	                                $a = $dayEX[1];
	                            }

	                            $days = $dayEX[0].'-'.$a.'-'.$days;
	                            
	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $days ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $days ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."' , '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            } else {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_in2 = '". $CKOT_in2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $days ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '15') && ($Day_Time < '270')){
	                            $CKOT_Out2 = $se;

	                            $dayEX = explode('-', $day);

	                            $days = ($dayEX[2] - 1);
	                            if(strlen($days) == '1') {
	                                $days = '0'.$days;
	                            }else{
	                                $days = $days;
	                            }

	                            $a = '';

	                            if($days == '00') {
	                                $a = ($dayEX[1] - 1);
	                                if(strlen($a) == '1') {
	                                    $a = '0'.$a;
	                                }

	                                if($a == '02') {
	                                    $days = '28';
	                                }
	                                if($a == '01' || $a == '03' || $a == '05' || $a == '07' || $a == '08' || $a == '10' || $a == '12') {
	                                    $days = '31';
	                                }
	                                if($a == '04' || $a == '06' || $a == '09' || $a == '11') {
	                                    $days = '30';
	                                }
	                            } else {
	                                $a = $dayEX[1];
	                            }

	                            $days = $dayEX[0].'-'.$a.'-'.$days;

	                            $sql_check_2 = "SELECT * FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $days ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 == 0) {
	                                $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, Admin_Update, TimePlan_Cal_Status) 
	                                VALUES ('". $CodeID ."', '". $days ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '". $_SESSION['SuperName'] ."', '0')";
	                                mssql_query($sql_insert);
	                                // echo $sql_insert.'<br>';
	                            } else {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_Out2 = '". $CKOT_Out2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $days ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                    } else {
	                        $num_se = explode(':', $se);
	                        $Day_Time = ($num_se[0] * 60) + $num_se[1];

                            if(($Day_Time >= '270') && ($Day_Time < '705')) {
                                $CK_in = $se;

                                $sql_check_2 = "SELECT CK_in FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND CK_in = '' AND CK_in = ' ' AND TimePlan_Cal_Status = '0' ";
                                $query_check_2 = mssql_query($sql_check_2);
                                $num_check_2 = mssql_num_rows($query_check_2);

                                if($num_check_2 > 0) {
                                    // echo 'UPDATE..'.'<br/>';
                                    $sql_edit = "UPDATE
                                                    [HRP].[dbo].[Time_Plan]
                                                SET
                                                    CK_in = '". $CK_in ."'
                                                WHERE
                                                    Em_ID = '". $CodeID ."'
                                                    AND LogTime = '". $day ."' ";

                                    // mssql_query($sql_edit);
                                    // echo $sql_edit.'<br>';
                                }
                            }
	                        if(($Day_Time >= '705') && ($Day_Time < '765')) {
	                            $Ck_Out1 = $se;

	                            $sql_check_2 = "SELECT CK_in, CK_Out1 FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                Ck_Out1 = '". $Ck_Out1 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                            // if($num_check_2 == 0) {
	                            //     $sql_insert = "INSERT INTO [HRP].[dbo].[Time_Plan] (Em_ID, LogTime, CK_in, Ck_Out1, Total, CK_in2, Ck_Out2, OTN, CKOT_in1, CKOT_Out1, OTE, CKOT_in2, CKOT_Out2, TotalOT1, TotalOT15, TotalOT2, FingerID, TimePlan_Status, Site_ID, TimePlan_Date, TimePlan_Cal_Status) 
	                            //     VALUES ('". $CodeID ."', '". $day ."', '". $CK_in ."', '". $Ck_Out1 ."', '', '". $CK_in2 ."', '". $Ck_Out2 ."', '', '". $CKOT_in1 ."', '". $CKOT_Out1 ."', '', '". $CKOT_in2 ."', '". $CKOT_Out2 ."', '', '', '', '$file[4]', '0', '". $_SESSION['SuperSite'] ."', '". $dates ."', '0')";
	                            //     mssql_query($sql_insert);
	                            //     // echo $sql_insert;
	                            // }
	                        }
	                        if(($Day_Time >= '765') && ($Day_Time < '810')) {
	                            $CK_in2 = $se;

	                            $sql_check_2 = "SELECT CK_in2 FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND CK_in2 = '' AND CK_in2 = ' ' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CK_in2 = '". $CK_in2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '810') && ($Day_Time < '1095')) {
	                            $Ck_Out2 = $se;

	                            $sql_check_2 = "SELECT Ck_Out2 FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                Ck_Out2 = '". $Ck_Out2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '1095') && ($Day_Time < '1110')) {
	                            $CKOT_in1 = $se;

	                            $sql_check_2 = "SELECT CKOT_in1 FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND CKOT_in1 = '' AND CKOT_in1 = ' ' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_in1 = '". $CKOT_in1 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '1110') && ($Day_Time < '1439')) {
	                            $CKOT_Out1 = $se;

	                            $sql_check_2 = "SELECT CKOT_Out1 FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $day ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_Out1 = '". $CKOT_Out1 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $day ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '0') && ($Day_Time < '15')) {
	                            $CKOT_in2 = $se;

	                            $dayEX = explode('-', $day);
	                            $days = $dayEX[0].'-'.$dayEX[1].'-'.($dayEX[2] - 1);

	                            $sql_check_2 = "SELECT CKOT_in2 FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $days ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_in2 = '". $CKOT_in2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $days ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if(($Day_Time >= '15') && ($Day_Time < '270')){
	                            $CKOT_Out2 = $se;

	                            $dayEX = explode('-', $day);
	                            $days = $dayEX[0].'-'.$dayEX[1].'-'.($dayEX[2] - 1);

	                            // echo $day.'<br>';

	                            $sql_check_2 = "SELECT CKOT_Out2 FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $CodeID ."' AND LogTime = '". $days ."' AND TimePlan_Cal_Status = '0' ";
	                            $query_check_2 = mssql_query($sql_check_2);
	                            $num_check_2 = mssql_num_rows($query_check_2);

	                            if($num_check_2 > 0) {
	                                // echo 'UPDATE..'.'<br/>';
	                                $sql_edit = "UPDATE 
	                                                [HRP].[dbo].[Time_Plan]
	                                            SET
	                                                CKOT_Out2 = '". $CKOT_Out2 ."'
	                                            WHERE
	                                                Em_ID = '". $CodeID ."'
	                                                AND LogTime = '". $days ."' ";

	                                mssql_query($sql_edit);
	                                // echo $sql_edit.'<br>';
	                            }
	                        }
	                        if($CKOT_Out2 != '') {
	                            $CKOT_in2 = '00:00';
	                        }
	                    }

	                    $sql_search = "SELECT * FROM [HRP].[dbo].[Log_Time] WHERE Em_ID = '".$CodeID."' AND ScanDate = '".$file[1]. "' ";
	                    $querys = mssql_query($sql_search);
	                    $nums = mssql_num_rows($querys);

	                    if($nums == 0) {
	                        $sql = " INSERT INTO [HRP].[dbo].[Log_Time] (Em_ID,ScanDate,FingerID,TimeInsert) VALUES ('$CodeID','$file[1]','$file[4]','$dates') ";
	                        mssql_query($sql);
	                    }

                        if($_SESSION['Rule'] == '3') {
                            $updateCheckWork = "UPDATE
                                                    [HRP].[dbo].[AuditWorkDay]
                                                SET 
                                                    Check_in = '1'
                                                WHERE
                                                    Check_day = '". $dates ."' ";
                            mssql_query($updateCheckWork);
                        }
	                }
            	}
            }
        }
    }
    exit("<script>window.location='../TimePlan.php';</script>");
?>
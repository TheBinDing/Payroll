<?php
    @session_start();
    include("../inc/connect.php");
    ini_set('max_execution_time', 600);

    $Employee = "SELECT Em_ID FROM [HRP].[dbo].[Employees] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
    $query_em = mssql_query($Employee);
    $num_em = mssql_num_rows($query_em);

    $peS = explode('-', $_SESSION['SubStart']);
    $peE = explode('-', $_SESSION['SubEnd']);

    $arrayPeriod = array();

    for($nm=0;$nm<=15;$nm++) {
        $kk = ($peS[2] + $nm);
        if($kk != $peE[2]) {
            if($kk == 1 || $kk == 2 || $kk == 3 || $kk == 4 || $kk == 5 || $kk == 6 || $kk == 7 || $kk == 8 || $kk == 9) {
                $kk = '0'.$kk;
            }
            array_push($arrayPeriod, $peS[0].'-'.$peS[1].'-'.$kk);
        }
        if($kk == $peE[2]) {
            array_push($arrayPeriod, $peS[0].'-'.$peS[1].'-'.$kk);
            break;
        }
    }

    for($i=1;$i<=$num_em;$i++) {
        $row_em = mssql_fetch_array($query_em);

        foreach ($arrayPeriod as $key => $value) {
            $time = "SELECT
                        LogTime,
                        CK_in,
                        Ck_Out1,
                        CK_in2,
                        Ck_Out2,
                        CKOT_in1,
                        CKOT_Out1,
                        CKOT_in2,
                        CKOT_Out2,
                        Total,
                        OTN,
                        OTE,
                        TotalOT1,
                        TotalOT15,
                        TotalOT2,
                        Mny_1,
                        Mny_2,
                        Mny_3,
                        Mny_4,
                        Mny_5,
                        FingerID,
                        TimePlan_Status,
                        TimePlan_Date,
                        Admin_Update,
                        Site_ID,
                        TimePlan_Late,
                        Em_ID,
                        TimePlan_Cal_Status
                    FROM
                        [HRP].[dbo].[Time_Plan]
                    WHERE
                        Em_ID = '". $row_em['Em_ID'] ."'
                        AND LogTime = '". $value ."'
                    ORDER BY
                        Em_ID, LogTime ";

            $query_time = mssql_query($time);
            $num_time = mssql_num_rows($query_time);

            if($num_time > 1) {
                $row_time = mssql_fetch_array($query_time);
                // echo $row_em['Em_ID'].'-'.$row_time['LogTime'].'-'.$row_time['Admin_Update'].'-'.$row_time['Site_ID'].'<br>';

                $delete_time = "DELETE FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $row_em['Em_ID'] ."' AND LogTime = '". $value ."' ";
                mssql_query($delete_time);

                $insert_time = "INSERT INTO [dbo].[Time_Plan]
                                (
                                LogTime,
                                CK_in,
                                Ck_Out1,
                                CK_in2,
                                Ck_Out2,
                                CKOT_in1,
                                CKOT_Out1,
                                CKOT_in2,
                                CKOT_Out2,
                                Total,
                                OTN,
                                OTE,
                                TotalOT1,
                                TotalOT15,
                                TotalOT2,
                                Mny_1,
                                Mny_2,
                                Mny_3,
                                Mny_4,
                                Mny_5,
                                FingerID,
                                TimePlan_Status,
                                TimePlan_Date,
                                Admin_Update,
                                Site_ID,
                                TimePlan_Late,
                                Em_ID,
                                TimePlan_Cal_Status)
                         VALUES
                            (
                            '". $row_time['LogTime'] ."',
                            '". $row_time['CK_in'] ."',
                            '". $row_time['Ck_Out1'] ."',
                            '". $row_time['CK_in2'] ."',
                            '". $row_time['Ck_Out2'] ."',
                            '". $row_time['CKOT_in1'] ."',
                            '". $row_time['CKOT_Out1'] ."',
                            '". $row_time['CKOT_in2'] ."',
                            '". $row_time['CKOT_Out2'] ."',
                            '". $row_time['Total'] ."',
                            '". $row_time['OTN'] ."',
                            '". $row_time['OTE'] ."',
                            '". $row_time['TotalOT1'] ."',
                            '". $row_time['TotalOT15'] ."',
                            '". $row_time['TotalOT2'] ."',
                            '". $row_time['Mny_1'] ."',
                            '". $row_time['Mny_2'] ."',
                            '". $row_time['Mny_3'] ."',
                            '". $row_time['Mny_4'] ."',
                            '". $row_time['Mny_5'] ."',
                            '". $row_time['FingerID'] ."',
                            '". $row_time['TimePlan_Status'] ."',
                            '". $row_time['TimePlan_Date'] ."',
                            '". $row_time['Admin_Update'] ."',
                            '". $row_time['Site_ID'] ."',
                            '". $row_time['TimePlan_Late'] ."',
                            '". $row_time['Em_ID'] ."',
                            '". $row_time['TimePlan_Cal_Status'] ."' ) ";

                mssql_query($insert_time);
            }
        }
    }

    $sql = " SELECT
                T.Em_ID as Em_ID,
                T.LogTime as LogTime,
                T.CK_in as CK_in,
                T.Ck_Out1 as Ck_Out1,
                T.CK_in2 as CK_in2,
                T.Ck_Out2 as Ck_Out2,
                T.CKOT_in1 as CKOT_in1,
                T.CKOT_Out1 as CKOT_Out1,
                T.CKOT_in2 as CKOT_in2,
                T.CKOT_Out2 as CKOT_Out2,
                E.TimePlan_ID as TimePlan_ID,
                PT.TimePlan_Name as TimePlan_Name,
                PT.CK_in as TCK_in,
                PT.Ck_Out1 as TCk_Out1,
                PT.CK_in2 as TCK_in2,
                PT.Ck_Out2 as TCk_Out2,
                PT.CKOT_in1 as TCKOT_in1,
                PT.CKOT_Out1 as TCKOT_Out1,
                PT.CKOT_in2 as TCKOT_in2,
                PT.CKOT_Out2 as TCKOT_Out2,
                PT.TimePlan_LateTime as Late
            FROM
                [HRP].[dbo].[Time_Plan] T LEFT JOIN
                [HRP].[dbo].[Employees] E on T.Em_ID = E.Em_ID LEFT JOIN
                [HRP].[dbo].[PlanTime] PT on E.TimePlan_ID = PT.TimePlan_ID
            Where
                T.LogTime between '". $_SESSION['SubStart'] ."' and '". $_SESSION['SubEnd'] ."' ";
    if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
        $sql .= "AND E.Site_ID = '".$_SESSION['SuperSite']."' ";
    }
    if(!empty($_GET['Name'])) {
        $sql .= "AND E.Em_ID = '". $_GET['Name'] ."' ";
    }
    $sql .= " ORDER BY
                    T.LogTime ";

    $query = mssql_query($sql);
    $num = mssql_num_rows($query);

    for($i=1;$i<=$num;$i++) {
        $row = mssql_fetch_array($query);

        $N1 = 0;$N2 = 0;$N3 = 0;$N4 = 0;$N5 = 0;$N6 = 0;
        $cCK = 0;$OT15 = 0;$OT2 = 0;$Total = 0;

        $Em_ID = $row['Em_ID'];
        $LogTime = $row['LogTime'];
        $TimePlan_ID = $row['TimePlan_ID'];

        $date_in = $row['CK_in'];
        $date_out = $row['Ck_Out1'];
        $date_in2 = $row['CK_in2'];
        $date_out2 = $row['Ck_Out2'];
        $date_OTin1 = $row['CKOT_in1'];
        $date_OTout1 = $row['CKOT_Out1'];
        $date_OTin2 = $row['CKOT_in2'];
        $date_OTout2 = $row['CKOT_Out2'];

        if($date_in * 1 == 0){
            $date_in = 0;
        }
        if($date_out * 1 == 0){
            $date_out = 0;
        }
        if($date_in2 * 1 == 0){
            $date_in2 = 0;
        }
        if($date_out2 * 1 == 0){
            $date_out2 = 0;
        }
        if($date_OTin1 * 1 == 0){
            $date_OTin1 = 0;
        }
        if($date_OTout1 * 1 == 0){
            $date_OTout1 = 0;
        }
        if($date_OTin2 == ''){
            $date_OTin2 = ' ';
        }
        /*if($date_OTout2 * 1 == 0){
            $date_OTout2 = 0;
        }*/

        $N1 = 0;$N2 = 0;$N3 = 0;$N4 = 0;$N5 = 0;$N6 = 0;
        $cCK = 0;$OT15 = 0;$OT2 = 0;$Total = 0;

        if($date_in == ' ' || $date_in == '') {
            $date_in = $date_in;
        } else {
            if($date_in <= '07:45') {
                $date_in = '07:30';
            }else {
                $date_in = $date_in;
            }
        }

        // if($date_out > '12:00') {
        //     $date_out = '12:00';
        // }else {
        //     $date_out = $date_out;
        // }

        $time_ckin = explode(':', $date_in);
        $time_ckout = explode(':', $date_out);

        $time_ckin2 = explode(':', $date_in2);
        $time_ckout2 = explode(':', $date_out2);

        $time_ckoti = explode(':', $date_OTin1);
        $time_ckoto = explode(':', $date_OTout1);

        $time_ckoti2 = explode(':', $date_OTin2);
        $time_ckoto2 = explode(':', $date_OTout2);

        if($time_ckin[1] >= 0 && $time_ckin[1] <= 14) {
            $time_ckin[1] = 0;
        }
        if($time_ckin[1] >= 15 && $time_ckin[1] <= 29) {
            $time_ckin[1] = 30;
        }
        if($time_ckin[1] >= 30 && $time_ckin[1] <= 44) {
            $time_ckin[1] = 30;
        }
        if($time_ckin[1] >= 45 && $time_ckin[1] <= 59) {
            $time_ckin[0] = $time_ckin[0]+1;
            $time_ckin[1] = 0;
        }

        if($time_ckout[1] >= 0 && $time_ckout[1] <= 14) {
            $time_ckout[1] = 0;
        }
        if($time_ckout[1] >= 15 && $time_ckout[1] <= 29) {
            $time_ckout[1] = 30;
        }
        if($time_ckout[1] >= 30 && $time_ckout[1] <= 44) {
            $time_ckout[1] = 30;
        }
        if($time_ckout[1] >= 45 && $time_ckout[1] <= 59) {
            $time_ckout[0] = $time_ckout[0]+1;
            $time_ckout[1] = 0;
        }

        if($time_ckin2[1] >= 0 && $time_ckin2[1] <= 14) {
            $time_ckin2[1] = 0;
        }
        if($time_ckin2[1] >= 15 && $time_ckin2[1] <= 29) {
            $time_ckin2[1] = 30;
        }
        if($time_ckin2[1] >= 30 && $time_ckin2[1] <= 44) {
            $time_ckin2[1] = 30;
        }
        if($time_ckin2[1] >= 45 && $time_ckin2[1] <= 59) {
            $time_ckin2[0] = $time_ckin2[0]+1;
            $time_ckin2[1] = 0;
        }

        if($time_ckout2[1] >= 0 && $time_ckout2[1] <= 14) {
            $time_ckout2[1] = 0;
        }
        if($time_ckout2[1] >= 15 && $time_ckout2[1] <= 29) {
            $time_ckout2[1] = 30;
        }
        if($time_ckout2[1] >= 30 && $time_ckout2[1] <= 44) {
            $time_ckout2[1] = 30;
        }
        if($time_ckout2[1] >= 45 && $time_ckout2[1] <= 59) {
            $time_ckout2[0] = $time_ckout2[0]+1;
            $time_ckout2[1] = 0;
        }

        if($time_ckoti[1] >= 0 && $time_ckoti[1] <= 14) {
            $time_ckoti[1] = 0;
        }
        if($time_ckoti[1] >= 15 && $time_ckoti[1] <= 29) {
            $time_ckoti[1] = 30;
        }
        if($time_ckoti[1] >= 30 && $time_ckoti[1] <= 44) {
            $time_ckoti[1] = 30;
        }
        if($time_ckoti[1] >= 45 && $time_ckoti[1] <= 59) {
            $time_ckoti[0] = $time_ckoti[0]+1;
            $time_ckoti[1] = 0;
        }

        if($time_ckoto[1] >= 0 && $time_ckoto[1] <= 14) {
            $time_ckoto[1] = 0;
        }
        if($time_ckoto[1] >= 15 && $time_ckoto[1] <= 29) {
            $time_ckoto[1] = 30;
        }
        if($time_ckoto[1] >= 30 && $time_ckoto[1] <= 44) {
            $time_ckoto[1] = 30;
        }
        if($time_ckoto[1] >= 45 && $time_ckoto[1] <= 59) {
            $time_ckoto[0] = $time_ckoto[0]+1;
            $time_ckoto[1] = 0;
        }

        if($date_OTin2 != ' ') {
            if($time_ckoti2[1] >= 0 && $time_ckoti2[1] <= 14) {
                $time_ckoti2[1] = 0;
            }
            if($time_ckoti2[1] >= 15 && $time_ckoti2[1] <= 29) {
                $time_ckoti2[1] = 30;
            }
            if($time_ckoti2[1] >= 30 && $time_ckoti2[1] <= 44) {
                $time_ckoti2[1] = 30;
            }
            if($time_ckoti2[1] >= 45 && $time_ckoti2[1] <= 59) {
                $time_ckoti2[0] = $time_ckoti2[0]+1;
                $time_ckoti2[1] = 0;
            }
        }

        if($time_ckoto2[1] >= 0 && $time_ckoto2[1] <= 14) {
            $time_ckoto2[1] = 0;
        }
        if($time_ckoto2[1] >= 15 && $time_ckoto2[1] <= 29) {
            $time_ckoto2[1] = 30;
        }
        if($time_ckoto2[1] >= 30 && $time_ckoto2[1] <= 44) {
            $time_ckoto2[1] = 30;
        }
        if($time_ckoto2[1] >= 45 && $time_ckoto2[1] <= 59) {
            $time_ckoto2[0] = $time_ckoto2[0]+1;
            $time_ckoto2[1] = 0;
        }

        $CK_Isec = ($time_ckin[0] * 60) + $time_ckin[1];
        $CK_Osec = ($time_ckout[0] * 60) + $time_ckout[1];

        $CK_Isec2 = ($time_ckin2[0] * 60) + $time_ckin2[1];
        $CK_Osec2 = ($time_ckout2[0] * 60) + $time_ckout2[1];

        $CK_OTisec = ($time_ckoti[0] * 60) + $time_ckoti[1];
        $CK_OTosec = ($time_ckoto[0] * 60) + $time_ckoto[1];

        // echo $date_OTin2.'<br>';
        if($date_OTin2 != ' ' && $date_OTin2 != '') {
            $CK_OTisec2 = ($time_ckoti2[0] * 60) + $time_ckoti2[1];
        } else {
            $CK_OTisec2 = $date_OTin2;
        }
        $CK_OTosec2 = ($time_ckoto2[0] * 60) + $time_ckoto2[1];

        // echo $CK_OTosec.'<br>';
        if($CK_Osec2 != '0' && $CK_OTisec == '0') {
            if($CK_Osec2 == '1080') {
                $CK_OTisec = '1080';
            }
        }
        if($CK_Isec != '0' && $CK_Osec != '0' && $CK_Isec2 != '0' && $CK_Osec2 == '0' && $CK_OTisec != '0') {
            if($CK_OTosec > 1065 && $CK_OTosec <= 1080) {
                $CK_Osec2 = 1050;
                $CK_OTosec = 1140;
            }
        }
        if($CK_Isec == '' && $CK_Osec == '' && $CK_Isec2 != '0' && $CK_Osec2 == '0' && $CK_OTisec == '0' && $CK_OTosec != '') {
            if($CK_OTosec > 1065 && $CK_OTosec <= 1080) {
                $CK_Osec2 = 1050;
                $CK_OTosec = 1140;
            }
        }
        if($CK_OTisec2 == '0' && $CK_OTosec2 != '0') {
            $CK_OTosec = '1425';
        }

        // echo $CK_OTosec.'<br>';


        // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
        /*---------------------------------------------------------------àªéÒ--------------------------------------------------------------------------*/

        if (($CK_Isec != '0')) {
            if (($CK_Isec) < 450) {
                $CK_Isec = 450;
            }
            else {
                $CK_Isec = $CK_Isec;
            }
        }
        if (($CK_Isec != '0') && ($CK_Osec != '0')) {
            $N1 = (($CK_Osec - $CK_Isec) / 60);
        }
        else if (($CK_Isec != '0') && ($CK_Osec == '0')) {
            if ((($CK_Isec2 != '0') || (($CK_Osec2 != '0') || (($CK_OTisec != '0') || (($CK_OTosec != '0') || (($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))))))) {
                $N1 = ((720 - $CK_Isec) / 60);
            }
        }

        /*---------------------------------------------------------------¼èÒà·ÕèÂ§--------------------------------------------------------------------------*/

        if ((($CK_Osec == '0') && ($CK_Isec2 == '0'))) {
            $T_5 = '0';
            $T_6 = '0';
            if (($CK_Isec != '0')) {
                $T_5 = 720;
            }
            if ((($CK_Osec2 != '0') 
                        || (($CK_OTisec != '0') 
                        || (($CK_OTosec != '0') 
                        || (($CK_OTisec2 == '0') 
                        || ($CK_OTosec2 != '0')))))) {
                $T_6 = 780;
            }
            if ((($T_5 != '0') && ($T_6 != '0'))) {
                $N2 = (($T_6 - $T_5) / 60);
            }
        }

        /*---------------------------------------------------------------àÂç¹--------------------------------------------------------------------------*/

        // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';

        if ((($CK_Isec2 != '0') && ($CK_Osec2 != '0'))) {
            $N3 = (($CK_Osec2 - $CK_Isec2) / 60);
        }
        else if ((($CK_Isec2 != '0') && ($CK_Osec2 == '0'))) {
            if ((($CK_OTisec != '0') 
                        || (($CK_OTosec != '0') 
                        || (($CK_OTisec2 == '0') 
                        || ($CK_OTosec2 != '0'))))) {
                $N3 = ((1050 - $CK_Isec2) / 60);
            }
        }
        else if ((($CK_Isec2 == '0') && ($CK_Osec2 != '0'))) {
            if ((($CK_Isec != '0') || ($CK_Osec != '0'))) {
                $N3 = (($CK_Osec2 - 780) / 60);
            }
        }
        else if ((($CK_Isec2 == '0') && ($CK_Osec2 == '0'))) {
            $T_1 = '0';
            $T_2 = '0';
            if ((($CK_Isec != '0') || ($CK_Osec != '0'))) {
                $T_1 = 780;
            }
            if ((($CK_OTisec != '0')
                        || (($CK_OTosec != '0')
                        || (($CK_OTisec2 == '0')
                        || ($CK_OTosec2 != '0'))))) {
                $T_2 = 1050;
            }
            if ((($T_1 != '0') && ($T_2 != '0'))) {
                $N3 = (($T_2 - $T_1) / 60);
            }
        }

        /*---------------------------------------------------------------µèÍà¹×èÍ§àÂç¹--------------------------------------------------------------------------*/
        // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
        if($CK_Isec != '' && $CK_Osec != '' && $CK_Isec2 != '' && $CK_Osec2 == '' && $CK_OTisec == '' && $CK_OTosec != '') {
            if($CK_OTosec > 1080) {
                if ((($CK_Osec2 == '0') && ($CK_OTisec == '0'))) {
                    $T_7 = '0';
                    $T_8 = '0';
                    if ((($CK_Isec != '0') || (($CK_Osec != '0') || ($CK_Isec2 != '0')))) {
                        $T_7 = 1050;
                    }
                    if ((($CK_OTosec != '0') || (($CK_OTisec2 == '0') || ($CK_OTosec2 != '0')))) {
                        $T_8 = 1110;
                    }
                    if ((($T_7 != '0') && ($T_8 != '0'))) {
                        $N4 = (($T_8 - $T_7) / 60);
                    }
                }
                else if ((($CK_Osec2 == '0') && ($CK_OTisec != '0'))) {
                    $T_7 = '0';
                    $T_8 = '0';
                    if ((($CK_Isec != '0') || (($CK_Osec != '0') || ($CK_Isec2 != '0')))) {
                        $T_7 = 1050;
                    }
                    if ((($CK_OTosec == '0') || (($CK_OTisec2 == '0') || ($CK_OTosec2 == '0')))) {
                        $T_8 = $CK_OTisec;
                    }
                    if ((($T_7 != '0') && ($T_8 != '0'))) {
                        $N4 = (($T_8 - $T_7) / 60);
                    }
                }
            }
        } else {
        // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
            if ((($CK_Osec2 == '0') && ($CK_OTisec == '0'))) {
                $T_7 = '0';
                $T_8 = '0';
                if ((($CK_Isec != '0') || (($CK_Osec != '0') || ($CK_Isec2 != '0')))) {
                    $T_7 = 1050;
                }
                if ((($CK_OTosec != '0') || (($CK_OTisec2 == '0') || ($CK_OTosec2 != '0')))) {
                    $T_8 = 1110;
                }
                if ((($T_7 != '0') && ($T_8 != '0'))) {
                    $N4 = (($T_8 - $T_7) / 60);
                }
            }
            else if ((($CK_Osec2 == '0') && ($CK_OTisec != '0'))) {
                $T_7 = '0';
                $T_8 = '0';
                if ((($CK_Isec != '0') || (($CK_Osec != '0') || ($CK_Isec2 != '0')))) {
                    $T_7 = 1050;
                }
                if ((($CK_OTosec == '0') || (($CK_OTisec2 == '0') || ($CK_OTosec2 == '0')))) {
                    $T_8 = $CK_OTisec;
                }
                if ((($T_7 != '0') && ($T_8 != '0'))) {
                    $N4 = (($T_8 - $T_7) / 60);
                }
            }
        }

        /*---------------------------------------------------------------ÅèÇ§àÇÅÒ 1--------------------------------------------------------------------------*/
        // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
        if ((($CK_OTisec != '0') && ($CK_OTosec != '0'))) {
            // __________________________________
            if ((($CK_OTosec >= 1425) && ($CK_OTosec <= 1440))) {
                $N5 = ((1440 - $CK_OTisec) / 60);
            }
            else {
                $N5 = (($CK_OTosec - $CK_OTisec) / 60);
            }
        }
        else if ((($CK_OTisec != '0') && ($CK_OTosec == '0'))) {
            // __________________________________
            if ((($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))) {
                if (((1440 >= 1425) && (1440 <= 1440))) {
                    $N5 = ((1440 - $CK_OTisec) / 60);
                }
                else {
                    $N5 = ((1440 - $CK_OTisec) / 60);
                }
            }
        }
        else if ((($CK_OTisec == '0') && ($CK_OTosec != '0'))) {
            // __________________________________
            if ((($CK_Isec != '0') || (($CK_Osec != '0') || (($CK_Isec2 != '0') || ($CK_Osec2 != '0'))))) {
                // If dataV("CKOT_in2").ToString <> '0' Or dataV("CKOT_Out2").ToString <> '0' Then
                //     N5 = ((TimeDiff(HR000.Default.OT1_In, "23:30:30") + 30) / 60)
                // Else
                if($CK_OTosec > 1080) {
                    if ((($CK_OTosec >= 1425) && ($CK_OTosec <= 1440))) {
                        $N5 = ((1440 - 1110) / 60);
                    }
                    else if ((($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))) {
                        $N5 = ((1440 - $CK_OTosec) / 60);
                    }
                    else {
                        $N5 = (($CK_OTosec - 1110) / 60);
                    }
                } else {
                    if($CK_OTosec > 1065) {
                        $N5 = ((1080 - 1050) / 60 );
                    }
                }
            }
            else if ((($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))) {
                // MsgBox("4");
                $N5 = ((1440 - $CK_OTosec) / 60);
            }
        }
        else if ((($CK_OTisec == '0') && ($CK_OTosec == '0'))) {
            // __________________________________
            $T_3 = '0';
            $T_4 = '0';
            if ((($CK_Isec != '0') || (($CK_Osec != '0') || (($CK_Isec2 != '0') || ($CK_Osec2 != '0'))))) {
                $T_3 = 1110;
            }
            if ((($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))) {
                $T_4 = 1440;
            }
            if ((($T_3 != '0') && ($T_4 != '0'))) {
                if ((($T_4 >= 1425) && ($T_4 <= 1440))) {
                    $N5 = ((1440 - $T_3) / 60);
                }
                else {
                    $N5 = (($T_4 - $T_3) / 60);
                }
            }
        }

        /*---------------------------------------------------------------ÅèÇ§àÇÅÒ 2--------------------------------------------------------------------------*/

        if (($CK_OTisec2 == '0') || ($CK_OTosec2 != '0')) {
            $N6 = (($CK_OTosec2 - $CK_OTisec2) / 60);
        }

        /*---------------------------------------------------------------¤Ó¹Ç¹--------------------------------------------------------------------------*/
        // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
        /*echo 'N1->'.$N1.'<br>';
        echo 'N2->'.$N2.'<br>';
        echo 'N3->'.$N3.'<br>';
        echo 'N4->'.$N4.'<br>';
        echo 'N5->'.$N5.'<br>';
        echo 'N6->'.$N6.'<br>';*/

        $checkT = ($N1 + ($N2 + ($N3 + ($N4 + ($N5 + $N6)))));

        if ($N1 > 4.5) {
            $N1 = 4.5;
            // $N2 = 1;
            $N2 = 0.5;
        } elseif($N1 < 0) {
            $N1 = 0;
        }
        
        if (($N3 > 4.5)) {
            $N3 = 4.5;
            // $N4 = 1;
            $N4 = 0.5;
        } elseif($N3 < 0) {
            $N3 = 0;
        }

        $Total = ($N1 + ($N3 + ($N5 + $N6)));

        if (($Total >= 9)) {
            $cCK = 9;
            $Total = ($Total - 9);
        }
        else {
            $Total = ($Total + $N4);
            if (($Total >= 9)) {
                $cCK = 9;
                $Total = ($Total - 9);
            }
            else {
                $cCK = $Total;
                $Total = ($Total - $Total);
                $N4 = 0;
            }
            
        }

        if($N6 != '') {
            $OT2 = $N6;
            $Total = $Total - $N6;
            $OT15 = $Total;
        } else {
            $OT15 = $Total;
        }

        if(empty($N2)) {
            $N2 = 0;
        }
        if(empty($N4)) {
            $N4 = 0;
        }
        if(empty($OT15)) {
            $OT15 = 0;
        }
        if(empty($OT2)) {
            $OT2 = 0;
        }

        // echo '>'.$cCK.'->'.$OTN.'->'.$OTE.'->'.$CK_OT1.'->'.$CK_OT2.'<br/>';$B1 = $A1;
        $B1 = 0; $A1 = 0;
        $B2 = 0; $A2 = 0;
        $B3 = 0; $A3 = 0;
        $B4 = 0; $A4 = 0;
        $B5 = 0; $A5 = 0;

        $sql_em = "SELECT Em_LivingExpenses AS Living, Em_Allowance AS Allo, Em_AllowanceDisaster AS AlloDis, Em_AllowanceSafety AS AlloSafe, Em_SpecialAllowance AS SpecAll FROM [HRP].[dbo].[Employees] WHERE Em_ID = '". $Em_ID ."' ";

        // echo $sql_em.'<br>';
        $query_em = mssql_query($sql_em);
        $row_em = mssql_fetch_array($query_em);

        $A1 = $row_em['Living'];
        $A2 = $row_em['Allo'];
        $A3 = $row_em['AlloDis'];
        $A4 = $row_em['AlloSafe'];
        $A5 = $row_em['SpecAll'];

        if($checkT >= 9) {
            $B1 = $A1;
            $B2 = $A2;
            $B3 = $A3;
            $B4 = $A4;
            $B5 = $A5;
        }

        $sql_update = "  UPDATE 
                            [HRP].[dbo].[Time_Plan]
                        SET
                            Total = '". $cCK ."',
                            OTN = '". $N2 ."',
                            OTE = '". $N4 ."',
                            TotalOT1 = '',
                            TotalOT15 = '". $OT15 ."',
                            TotalOT2 = '". $OT2 ."',
                            Mny_1 = '". $B1 ."',
                            Mny_2 = '". $B2 ."',
                            Mny_3 = '". $B3 ."',
                            Mny_4 = '". $B4 ."',
                            Mny_5 = '". $B5 ."',
                            Site_ID = '".$_SESSION['SuperSite']."'
                        WHERE
                            Em_ID = '". $Em_ID ."'
                            AND LogTime = '". $LogTime ."' ";

        mssql_query($sql_update);
        // echo $sql_update.'<br><br>';

        $dateDay = new DateTime();
        $dateDay = $dateDay->format('Y-m-d');

        if($dateDay != $LogTime) {
            $updateStatus = "UPDATE [HRP].[dbo].[Time_Plan] SET TimePlan_Cal_Status = '1' WHERE Em_ID = '". $Em_ID ."' AND LogTime = '". $LogTime ."' ";
            mssql_query($updateStatus);
        }
    }
    $updateCheckWork = "UPDATE
                            [HRP].[dbo].[AuditWorkDay]
                        SET 
                            Check_out = '1'
                        WHERE
                            Check_day = '". $dateDay ."' ";
    mssql_query($updateCheckWork);
    exit("<script>window.location='../TimePlan.php';</script>");
?>
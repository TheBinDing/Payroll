<?php
    @session_start();
    require("../inc/connect.php");

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
                T.TimePlan_Cal_Status = '0' ";
    if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
        $sql .= "AND E.Site_ID = '".$_SESSION['SuperSite']."' ";
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

        $sql_check = "SELECT e.TimePlan_ID AS TimePlan,
                                p.TimePlan_LateTime AS LateTime,
                                p.CK_in AS CK_in,
                                p.Ck_Out1 AS Ck_Out1,
                                p.CK_in2 AS CK_in2,
                                p.Ck_Out2 AS Ck_Out2,
                                p.CKOT_in1 AS CKOT_in1,
                                p.CKOT_Out1 AS CKOT_Out1,
                                p.CKOT_in2 AS CKOT_in2,
                                p.CKOT_Out2 AS CKOT_Out2
                            FROM [HRP].[dbo].[PlanTime] p left join [HRP].[dbo].[Employees] e on p.TimePlan_ID = e.TimePlan_ID 
                            WHERE E.Em_ID = '".$Em_ID."' ";

        $query_check = mssql_query($sql_check);
        $row_chcek = mssql_fetch_array($query_check);
        $TimeCheck = $row_chcek['TimePlan'];

        if($TimeCheck > 1) {
            $N1 = 0;$N2 = 0;$N3 = 0;$N4 = 0;$N5 = 0;$N6 = 0;
            $cCK = 0;$OT15 = 0;$OT2 = 0;$Total = 0;

            $late = $row['LateTime'];
            $TCK_in1 = $row['CK_in'];
            $TCk_Out1 = $row['Ck_Out1'];
            $TCK_in2 = $row['CK_in2'];
            $TCk_Out2 = $row['Ck_Out2'];
            $TCKOT_in1 = $row['CKOT_in1'];
            $TCKOT_Out1 = $row['CKOT_Out1'];
            $TCKOT_in2 = $row['CKOT_in2'];
            $TCKOT_Out2 = $row['CKOT_Out2'];

            $time_tckin = explode(':', $TCK_in1);
            $time_tckout = explode(':', $TCk_Out1);

            $time_tckin2 = explode(':', $TCK_in2);
            $time_tckout2 = explode(':', $TCk_Out2);

            $time_tckoti = explode(':', $TCKOT_in1);
            $time_tckoto = explode(':', $TCKOT_Out1);

            $time_tckoti2 = explode(':', $TCKOT_in2);
            $time_tckoto2 = explode(':', $TCKOT_Out2);

            $De_Isec = ($time_tckin[0] * 60) + $time_tckin[1];
            $De_Osec = ($time_tckout[0] * 60) + $time_tckout[1];

            $De_Isec2 = ($time_tckin2[0] * 60) + $time_tckin2[1];
            $De_Osec2 = ($time_tckout2[0] * 60) + $time_tckout2[1];

            $De_OTisec = ($time_tckoti[0] * 60) + $time_tckoti[1];
            $De_OTosec = ($time_tckoto[0] * 60) + $time_tckoto[1];

            $De_OTisec2 = ($time_tckoti2[0] * 60) + $time_tckoti2[1];
            $De_OTosec2 = ($time_tckoto2[0] * 60) + $time_tckoto2[1];

            /* PLAN */
            $planLate = $row_chcek['LateTime'];
            $planCK_in1 = $row_chcek['CK_in'];
            $planCk_Out1 = $row_chcek['Ck_Out1'];
            $planCK_in2 = $row_chcek['CK_in2'];
            $planCk_Out2 = $row_chcek['Ck_Out2'];
            $planCKOT_in1 = $row_chcek['CKOT_in1'];
            $planCKOT_Out1 = $row_chcek['CKOT_Out1'];
            $planCKOT_in2 = $row_chcek['CKOT_in2'];
            $planCKOT_Out2 = $row_chcek['CKOT_Out2'];

            $plan_tckin = explode(':', $planCK_in1);
            $plan_tckout = explode(':', $planCk_Out1);

            $plan_tckin2 = explode(':', $planCK_in2);
            $plan_tckout2 = explode(':', $planCk_Out2);

            $plan_tckoti = explode(':', $planCKOT_in1);
            $plan_tckoto = explode(':', $planCKOT_Out1);

            $plan_tckoti2 = explode(':', $planCKOT_in2);
            $plan_tckoto2 = explode(':', $planCKOT_Out2);

            $planDe_Isec = ($plan_tckin[0] * 60) + $plan_tckin[1];
            $planDe_Osec = ($plan_tckout[0] * 60) + $plan_tckout[1];

            $planDe_Isec2 = ($plan_tckin2[0] * 60) + $plan_tckin2[1];
            $planDe_Osec2 = ($plan_tckout2[0] * 60) + $plan_tckout2[1];

            $planDe_OTisec = ($plan_tckoti[0] * 60) + $plan_tckoti[1];
            $planDe_OTosec = ($plan_tckoto[0] * 60) + $plan_tckoto[1];

            $planDe_OTisec2 = ($plan_tckoti2[0] * 60) + $plan_tckoti2[1];
            $planDe_OTosec2 = ($plan_tckoto2[0] * 60) + $plan_tckoto2[1];
            /* END PLAN */

            if($date_in != ' ') {
                if($date_in <= $plan_tckin[0].':'.($plan_tckin[1]+$late)) {
                    $date_in = $plan_tckin[0].':'.$plan_tckin[1];
                }else {
                    $date_in = $date_in;
                }
            }

            if($date_out > $time_tckout[0].':'.$time_tckout[1]) {
                $date_out = $time_tckout[0].':'.$time_tckout[1];
            }else {
                $date_out = $date_out;
            }

            if($date_out2 > $time_tckout2[0].':'.$time_tckout2[1]) {
                $date_out2 = $time_tckout2[0].':'.$time_tckout2[1];
            }else {
                $date_out2 = $date_out2;
            }

            if($date_OTout1 > $time_tckoto[0].':'.$time_tckoto[1]) {
                $date_OTout1 = $time_tckoto[0].':'.$time_tckoto[1];
            }else {
                $date_OTout1 = $date_OTout1;
            }

            if($date_OTout2 > $time_tckoto2[0].':'.$time_tckoto2[1]) {
                $date_OTout2 = $time_tckoto2[0].':'.$time_tckoto2[1];
            }else {
                $date_OTout2 = $date_OTout2;
            }

            // echo $TCK_in1.'-'.$TCk_Out1.'-'.$TCK_in2.'-'.$TCk_Out2.'-'.$TCKOT_in1.'-'.$TCKOT_Out1.'-'.$TCKOT_in2.'-'.$TCKOT_Out2.'<br>';
            // echo $date_in.'-'.$date_out.'-'.$date_in2.'-'.$date_out2.'-'.$date_OTin1.'-'.$date_OTout1.'-'.$date_OTin2.'-'.$date_OTout2.'<br>';

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

            $CK_Isecc = ($time_ckin[0] * 60) + $time_ckin[1];
            $CK_Osecc = ($time_ckout[0] * 60) + $time_ckout[1];

            $CK_Isecc2 = ($time_ckin2[0] * 60) + $time_ckin2[1];
            $CK_Osecc2 = ($time_ckout2[0] * 60) + $time_ckout2[1];

            $CK_OTisecc = ($time_ckoti[0] * 60) + $time_ckoti[1];
            $CK_OTosecc = ($time_ckoto[0] * 60) + $time_ckoto[1];

            // echo $date_OTin2.'<br>';
            if($date_OTin2 != ' ') {
                $CK_OTisec2 = ($time_ckoti2[0] * 60) + $time_ckoti2[1];
            } else {
                $CK_OTisec2 = $date_OTin2;
            }
            $CK_OTosec2 = ($time_ckoto2[0] * 60) + $time_ckoto2[1];

            // echo $CK_OTosec.'<br>';
            if($CK_Osec2 != '0' && $CK_OTisec == '0') {
                if($CK_Osec2 == $planDe_Osec2) {
                    $CK_OTisec = $planDe_Osec2;
                }
            }

            if($CK_Isec != '0' && $CK_Osec != '0' && $CK_Isec2 != '0' && $CK_Osec2 == '0' && $CK_OTisec != '0') {
                if($CK_OTosec > ($planDe_Osec2 - 15) && $CK_OTosec <= ($planDe_Osec2 + 60)) {
                    $CK_Osec2 = ($planDe_Osec2 - 30);
                    $CK_OTosec = ($planDe_Osec2 + 60);
                }
            }
            if($CK_Isec == '' && $CK_Osec == '' && $CK_Isec2 != '0' && $CK_Osec2 == '0' && $CK_OTisec == '0' && $CK_OTosec != '') {
                if($CK_OTosec > ($planDe_Osec2 - 15) && $CK_OTosec <= ($planDe_Osec2 + 60)) {
                    $CK_Osec2 = ($planDe_Osec2 - 30);
                    $CK_OTosec = ($planDe_Osec2 + 60);
                }
            }
            if($CK_OTisec2 == '0' && $CK_OTosec2 != '0') {
                $CK_OTosec = $planDe_OTisec2;
            }
            if($CK_Osec >= $planDe_Isec2) {
                $CK_Osec = $planDe_Osec;
                $CK_Isec2 = $planDe_Isec2;
            }
            if($CK_Isec != '0') {
                if($CK_Isec <= $planDe_Isec) {
                    $CK_Isec = $planDe_Isec;
                }
            }

            // echo $CK_OTosec.'<br>';

            // echo $planDe_Isec.'-'.$planDe_Osec.'-'.$planDe_Isec2.'-'.$planDe_Osec2.'-'.$planDe_OTisec.'-'.$planDe_OTosec.'-'.$planDe_OTisec2.'-'.$planDe_OTosec2.'<br>';
            // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
            /*---------------------------------------------------------------เช้า--------------------------------------------------------------------------*/

            if (($CK_Isec != '0')) {
                if (($CK_Isec) < $CK_Isec) {
                    $CK_Isec = $CK_Isec;
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
                    $N1 = (($planDe_Osec - $CK_Isec) / 60);
                }
            }

            /*---------------------------------------------------------------ผ่าเที่ยง--------------------------------------------------------------------------*/

            if ((($CK_Osecc == '0') && ($CK_Isecc2 == '0'))) {
                $T_5 = '0';
                $T_6 = '0';
                if (($CK_Isecc != '0')) {
                    $T_5 = $planDe_Osec;
                }
                if ((($CK_Osecc2 != '0') 
                            || (($CK_OTisecc != '0') 
                            || (($CK_OTosecc != '0') 
                            || (($CK_OTisecc2 == '0') 
                            || ($CK_OTosecc2 != '0')))))) {
                    $T_6 = $planDe_Isec2;
                }
                if ((($CK_Osecc2 == '0') 
                            || (($CK_OTisecc != '0') 
                            || (($CK_OTosecc != '0') 
                            || (($CK_OTisecc2 == '0') 
                            || ($CK_OTosecc2 != '0')))))) {
                    $T_6 = $planDe_Isec2;
                }
                if ((($T_5 != '0') && ($T_6 != '0'))) {
                    $N2 = (($T_6 - $T_5) / 60);
                }
            }

            /*---------------------------------------------------------------เย็น--------------------------------------------------------------------------*/

            // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';

            if ($CK_Osec2 > $planDe_Osec2 && $CK_Osec2 < $planDe_OTisec) {
                $CK_Osec2 = $planDe_Osec2;
            }
            if ((($CK_Isec2 != '0') && ($CK_Osec2 != '0'))) {
                $N3 = (($CK_Osec2 - $CK_Isec2) / 60);
            }
            else if ((($CK_Isec2 != '0') && ($CK_Osec2 == '0'))) {
                if ((($CK_OTisec != '0') 
                            || (($CK_OTosec != '0') 
                            || (($CK_OTisec2 == '0') 
                            || ($CK_OTosec2 != '0'))))) {
                    $N3 = (($planDe_Osec2 - $CK_Isec2) / 60);
                }
            }
            else if ((($CK_Isec2 == '0') && ($CK_Osec2 != '0'))) {
                if ((($CK_Isec != '0') || ($CK_Osec != '0'))) {
                    $N3 = (($CK_Osec2 - $planDe_Isec2) / 60);
                }
            }
            else if ((($CK_Isec2 == '0') && ($CK_Osec2 == '0'))) {
                $T_1 = '0';
                $T_2 = '0';
                if ((($CK_Isec != '0') || ($CK_Osec != '0'))) {
                    $T_1 = $planDe_Isec2;
                }
                if ((($CK_OTisec != '0')
                            || (($CK_OTosec != '0')
                            || (($CK_OTisec2 == '0')
                            || ($CK_OTosec2 != '0'))))) {
                    $T_2 = $planDe_Osec2;
                }
                if ((($T_1 != '0') && ($T_2 != '0'))) {
                    $N3 = (($T_2 - $T_1) / 60);
                }
            }

            /*---------------------------------------------------------------ต่อเนื่องเย็น--------------------------------------------------------------------------*/
            // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
            if($CK_Isecc != '' && $CK_Osecc != '' && $CK_Isecc2 != '' && $CK_Osecc2 == '' && $CK_OTisecc == '' && $CK_OTosecc != '') {
                if($CK_OTosecc > ($planDe_Osecc2+30)) {
                    if ((($CK_Osecc2 == '0') && ($CK_OTisecc == '0'))) {
                        $T_7 = '0';
                        $T_8 = '0';
                        if ((($CK_Isecc != '0') || (($CK_Osecc != '0') || ($CK_Isecc2 != '0')))) {
                            $T_7 = $planDe_Osec2;
                        }
                        if ((($CK_OTosecc != '0') || (($CK_OTisecc2 == '0') || ($CK_OTosecc2 != '0')))) {
                            $T_8 = $planDe_OTisec;
                        }
                        if ((($T_7 != '0') && ($T_8 != '0'))) {
                            $N4 = (($T_8 - $T_7) / 60);
                        }
                    }
                    else if ((($CK_Osecc2 == '0') && ($CK_OTisecc != '0'))) {
                        $T_7 = '0';
                        $T_8 = '0';
                        if ((($CK_Isecc != '0') || (($CK_Osecc != '0') || ($CK_Isecc2 != '0')))) {
                            $T_7 = $planDe_Osec2;
                        }
                        if ((($CK_OTosecc == '0') || (($CK_OTisecc2 == '0') || ($CK_OTosecc2 == '0')))) {
                            $T_8 = $CK_OTisec;
                        }
                        if ((($T_7 != '0') && ($T_8 != '0'))) {
                            $N4 = (($T_8 - $T_7) / 60);
                        }
                    }
                }
            } else {
                if ((($CK_Osecc2 == '0') && ($CK_OTisecc == '0'))) {
                    $T_7 = '0';
                    $T_8 = '0';
                    if ((($CK_Isecc != '0') || (($CK_Osecc != '0') || ($CK_Isecc2 != '0')))) {
                        $T_7 = $planDe_Osec2;
                    }
                    if ((($CK_OTosecc != '0') || (($CK_OTisecc2 == '0') || ($CK_OTosecc2 != '0')))) {
                        $T_8 = $planDe_OTisec;
                    }
                    if ((($T_7 != '0') && ($T_8 != '0'))) {
                        $N4 = (($T_8 - $T_7) / 60);
                    }
                }
                else if ((($CK_Osecc2 == '0') && ($CK_OTisecc != '0'))) {
                    $T_7 = '0';
                    $T_8 = '0';
                    if ((($CK_Isecc != '0') || (($CK_Osecc != '0') || ($CK_Isecc2 != '0')))) {
                        $T_7 = $planDe_Osec2;
                    }
                    if ((($CK_OTosecc == '0') || (($CK_OTisecc2 == '0') || ($CK_OTosecc2 == '0')))) {
                        $T_8 = $CK_OTisec;
                    }
                    if ((($T_7 != '0') && ($T_8 != '0'))) {
                        $N4 = (($T_8 - $T_7) / 60);
                    }
                }
            }

            /*---------------------------------------------------------------ล่วงเวลา 1--------------------------------------------------------------------------*/
            // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
            if ((($CK_OTisec != '0') && ($CK_OTosec != '0'))) {
                // __________________________________
                if ((($CK_OTosec >= ($planDe_OTosec - 15)) && ($CK_OTosec <= $planDe_OTosec))) {
                    $N5 = (($planDe_OTosec - $CK_OTisec) / 60);
                }
                else {
                    $N5 = (($CK_OTosec - $CK_OTisec) / 60);
                }
            }
            else if ((($CK_OTisec != '0') && ($CK_OTosec == '0'))) {
                // __________________________________
                if ((($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))) {
                    if ((($planDe_OTosec >= ($planDe_OTosec - 15)) && ($planDe_OTosec <= $planDe_OTosec))) {
                        $N5 = (($planDe_OTosec - $CK_OTisec) / 60);
                    }
                    else {
                        $N5 = (($planDe_OTosec - $CK_OTisec) / 60);
                    }
                }
            }
            else if ((($CK_OTisec == '0') && ($CK_OTosec != '0'))) {
                // __________________________________
                if ((($CK_Isec != '0') || (($CK_Osec != '0') || (($CK_Isec2 != '0') || ($CK_Osec2 != '0'))))) {
                    // If dataV("CKOT_in2").ToString <> '0' Or dataV("CKOT_Out2").ToString <> '0' Then
                    //     N5 = ((TimeDiff(HR000.Default.OT1_In, "23:30:30") + 30) / 60)
                    // Else
                    if($CK_OTosec > ($planDe_Osec2 + 30)) {
                        if ((($CK_OTosec >= ($planDe_OTosec - 15)) && ($CK_OTosec <= $planDe_OTosec))) {
                            $N5 = (($planDe_OTosec - $planDe_OTisec) / 60);
                        }
                        else if ((($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))) {
                            // $N5 = (($planDe_OTosec - $CK_OTosec) / 60);
                            $N5 = (($CK_OTosec - $planDe_OTisec) / 60);
                        }
                        else {
                            $N5 = (($CK_OTosec - $planDe_OTisec) / 60);
                        }
                    } else {
                        if($CK_OTosec > ($planDe_Osec2 + 15)) {
                            $N5 = ((($planDe_Osec2 + 30) - $planDe_Osec2) / 60 );
                        }
                    }
                }
                else if ((($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))) {
                    // MsgBox("4");
                    $N5 = (($planDe_OTosec - $CK_OTosec) / 60);
                }
            }
            else if ((($CK_OTisec == '0') && ($CK_OTosec == '0'))) {
                // __________________________________
                $T_3 = '0';
                $T_4 = '0';
                if ((($CK_Isec != '0') || (($CK_Osec != '0') || (($CK_Isec2 != '0') || ($CK_Osec2 != '0'))))) {
                    $T_3 = $planDe_OTisec;
                }
                if ((($CK_OTisec2 == '0') || ($CK_OTosec2 != '0'))) {
                    $T_4 = $planDe_OTosec;
                }
                if ((($T_3 != '0') && ($T_4 != '0'))) {
                    if ((($T_4 >= ($planDe_OTosec - 15)) && ($T_4 <= $planDe_OTosec))) {
                        if($planDe_OTosec = '1439') {
                            $planDe_OTosec = 1440;
                        }
                        $N5 = (($planDe_OTosec - $T_3) / 60);
                    }
                    else {
                        $N5 = (($T_4 - $T_3) / 60);
                    }
                }
            }

            /*---------------------------------------------------------------ล่วงเวลา 2--------------------------------------------------------------------------*/

            if (($CK_OTisec2 == '0') || ($CK_OTosec2 != '0')) {
                // $N6 = ((($CK_OTosec2 + 1440) - $planDe_OTosec2) / 60);
                $N6 = (($CK_OTosec2 - $CK_OTisec2) / 60);
            }
            /*---------------------------------------------------------------คำนวน--------------------------------------------------------------------------*/
            echo $row['LateTime'].'-'.$row['CK_in'].'-'.$row['Ck_Out1'].'-'.$row['CK_in2'].'-'.$row['Ck_Out2'].'-'.$row['CKOT_in1'].'-'.$row['CKOT_Out1'].'-'.$row['CKOT_in2'].'-'.$row['CKOT_Out2'].'<br>';
            echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
            echo 'N1->'.$N1.'<br>';
            echo 'N2->'.$N2.'<br>';
            echo 'N3->'.$N3.'<br>';
            echo 'N4->'.$N4.'<br>';
            echo 'N5->'.$N5.'<br>';
            echo 'N6->'.$N6.'<br>';

            $checkT = ($N1 + ($N2 + ($N3 + ($N4 + ($N5 + $N6)))));

            $NN4 = ($planDe_OTisec - $planDe_Osec2)/60;

            if (($N1+$N2) > 4.5) {
                $N1 = 4.5;
                $N2 = 1;
                // $N2 = 0.5;
            } elseif($N1 < 4.5) {
                $N1 = $N1;
                $N2 = 0;
            }
            
            if (($N3+$N4) > 4.5) {
                $N3 = 4.5;
                $N4 = $NN4;
                // $N4 = 0.5;
            } elseif($N3 < 4.5) {
                $N3 = $N3;
                $N4 = 0;
            }

            $bbbb = (1440 - $planDe_OTisec) / 60;

            $Total = ($N1 + ($N3 + ($N5 + $N6)));

            if (($Total >= 9)) {
                $cCK = 9;
                $Total = ($Total - 9);
            } else {
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
                   
            if ($Total >= $bbbb) {
                if (($cCK == 9)) {
                    $OT15 = $bbbb;
                }
                
                $Total = ($Total - $bbbb);
            } else {
                if (($cCK == 9)) {
                    $OT15 = $Total;
                }
                
                $Total = ($Total - $Total);
            }
            
            $OT2 = $Total;

            // echo $cCK .'-'. $OT15 .'-'. $OT2.'<br>';

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
            // echo $sql_update.'<br>';

            $updateStatus = "UPDATE [HRP].[dbo].[Time_Plan] SET TimePlan_Cal_Status = '1' WHERE Em_ID = '". $Em_ID ."' AND LogTime = '". $LogTime ."' ";
            mssql_query($updateStatus);
        } else {
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
            /*---------------------------------------------------------------เช้า--------------------------------------------------------------------------*/

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

            /*---------------------------------------------------------------ผ่าเที่ยง--------------------------------------------------------------------------*/

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

            /*---------------------------------------------------------------เย็น--------------------------------------------------------------------------*/

            // echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';

            if ($CK_Osec2 > 1050 && $CK_Osec2 < 1110) {
                $CK_Osec2 = 1050;
            }
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

            /*---------------------------------------------------------------ต่อเนื่องเย็น--------------------------------------------------------------------------*/
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

            /*---------------------------------------------------------------ล่วงเวลา 1--------------------------------------------------------------------------*/
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

            /*---------------------------------------------------------------ล่วงเวลา 2--------------------------------------------------------------------------*/

            if (($CK_OTisec2 == '0') || ($CK_OTosec2 != '0')) {
                $N6 = (($CK_OTosec2 - $CK_OTisec2) / 60);
            }

            /*---------------------------------------------------------------คำนวน--------------------------------------------------------------------------*/
            echo $Em_ID.'-'.$CK_Isec.'-'.$CK_Osec.'-'.$CK_Isec2.'-'.$CK_Osec2.'-'.$CK_OTisec.'-'.$CK_OTosec.'-'.$CK_OTisec2.'-'.$CK_OTosec2.'<br/>';
            echo 'N1->'.$N1.'<br>';
            echo 'N2->'.$N2.'<br>';
            echo 'N3->'.$N3.'<br>';
            echo 'N4->'.$N4.'<br>';
            echo 'N5->'.$N5.'<br>';
            echo 'N6->'.$N6.'<br>';

            $checkT = ($N1 + ($N2 + ($N3 + ($N4 + ($N5 + $N6)))));

            if ($N1 > 4.5) {
                $N1 = 4.5;
                $N2 = 1;
                // $N2 = 0.5;
            } elseif($N1 < 0) {
                $N1 = 0;
            }
            
            if (($N3 > 4.5)) {
                $N3 = 4.5;
                $N4 = 1;
                // $N4 = 0.5;
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
                   
            // if ($Total >= 5.5) {
            //     if (($cCK == 9)) {
            //         $OT2 = $N6;
            //         $Total = $Total - $N6;
            //         $OT15 = $Total;
            //     }
                
            //     $Total = ($Total - 5.5);
            // }
            // else {
            //     if (($cCK == 9)) {
            //         $OT15 = $Total;
            //     }
                
            //     $Total = ($Total - $Total);
            // }
            
            // $OT2 = $Total;

            // echo $cCK .'-'. $OT15 .'-'. $OT2.'<br>';

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
            // $jo = $jo + 1;
            // echo $jo.'-'.$B1.'-'.$LogTime.'<br>';

            // echo $cCK.'-'.$OT15.'-'.$OT2.'-'.$N2.'-'.$N4.'<br>';
            // echo '------------'.'<br>';
            // echo $checkT.'-'.$B1.'<br><br>';

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

            $updateStatus = "UPDATE [HRP].[dbo].[Time_Plan] SET TimePlan_Cal_Status = '1' WHERE Em_ID = '". $Em_ID ."' AND LogTime = '". $LogTime ."' ";
            mssql_query($updateStatus);
        }
    }
?>
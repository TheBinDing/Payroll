<?php
    @session_start();
    include("../inc/connect.php");
    
    $Em_ID = $_POST['Em_ID'];
    $LogTime = new datetime($_POST['LogTime']);
    $LogTime = $LogTime->format('Y-m-d');
    $date_in = $_POST['CK_in'];
    $date_out = $_POST['Ck_Out1'];
    $date_in2 = $_POST['CK_in2'];
    $date_out2 = $_POST['Ck_Out2'];
    $date_OTin1 = $_POST['CKOT_in1'];
    $date_OTout1 = $_POST['CKOT_Out1'];
    $date_OTin2 = $_POST['CKOT_in2'];
    $date_OTout2 = $_POST['CKOT_Out2'];
    $Del = $_POST['Del'];

    if($Del == 1) {
        $Delete = " DELETE
                    FROM [HRP].[dbo].[Time_Plan]
                    WHERE
                        LogTime = '". $LogTime ."'
                        AND Em_ID = '". $Em_ID ."' ";

        mssql_query($Delete);
    } else {
        $time_upin = explode(':', $date_in);
        $time_upout = explode(':', $date_out);

        $time_upin2 = explode(':', $date_in2);
        $time_upout2 = explode(':', $date_out2);

        $time_upoti = explode(':', $date_OTin1);
        $time_upoto = explode(':', $date_OTout1);

        $time_upoti2 = explode(':', $date_OTin2);
        $time_upoto2 = explode(':', $date_OTout2);
        
        if($time_upin[2] == '' && $date_in != ' ' && $date_in != '') {
            $date_ins = $date_in.':00';
        } else {
            $date_ins = $date_in;
        }
        if($time_upout[2] == '' && $date_out != ' ' && $date_out != '') {
            $date_outs = $date_out.':00';
        } else {
            $date_outs = $date_out;
        }
        if($time_upin2[2] == '' && $date_in2 != ' ' && $date_in2 != '') {
            $date_ins2 = $date_in2.':00';
        } else {
            $date_ins2 = $date_in2;
        }
        if($time_upout2[2] == '' && $date_out2 != ' ' && $date_out2 != '') {
            $date_outs2 = $date_out2.':00';
        } else {
            $date_outs2 = $date_out2;
        }
        if($time_upoti[2] == '' && $date_OTin1 != ' ' && $date_OTin1 != '') {
            $date_OTins1 = $date_OTin1.':00';
        } else {
            $date_OTins1 = $date_OTin1;
        }
        if($time_upoto[2] == '' && $date_OTout1 != ' ' && $date_OTout1 != '') {
            $date_OTouts1 = $date_OTout1.':00';
        } else {
            $date_OTouts1 = $date_OTout1;
        }
        if($time_upoti2[2] == '' && $date_OTin2 != ' ' && $date_OTin2 != '') {
            $date_OTins2 = $date_OTin2.':00';
        } else {
            $date_OTins2 = $date_OTin2;
        }
        if($time_upoto2[2] == '' && $date_OTout2 != ' ' && $date_OTout2 != '') {
            $date_OTouts2 = $date_OTout2.':00';
        } else {
            $date_OTouts2 = $date_OTout2;
        }

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

        $late = $row['Late'];

        $N1 = 0;$N2 = 0;$N3 = 0;$N4 = 0;$N5 = 0;$N6 = 0;
        $cCK = 0;$OT15 = 0;$OT2 = 0;$Total = 0;

        if($date_in == ' ' || $date_in == '') {
            $date_in = $date_in;
        } else {
            if($date_in < '07:45') {
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

        $date_now = new datetime();
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_check = "  SELECT
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
                            TotalOT2
                        FROM
                            [HRP].[dbo].[Time_Plan]
                        WHERE
                            Em_ID = '". $Em_ID ."'
                            AND LogTime = '". $LogTime ."' ";

        $query_check = mssql_query($sql_check);
        $num_check = mssql_num_rows($query_check);
        $row_check = mssql_fetch_array($query_check);

        // echo $sql_check.'<br><br>';

        if($date_in == 0) {
            $date_in = '';
        }
        if($date_out == 0) {
            $date_out = '';
        }
        if($date_in2 == 0) {
            $date_in2 = '';
        }
        if($date_out2 == 0) {
            $date_out2 = '';
        }
        if($date_OTin1 == 0) {
            $date_OTin1 = '';
        }
        if($date_OTout1 == 0) {
            $date_OTout1 = '';
        }
        if($date_OTin2 != '00:00') {
            $date_OTin2 = $date_OTin2;
        }
        if($date_OTout2 == 0) {
            $date_OTout2 = '';
        }

        if($num_check != 0) {

            $sql_insert_log = " INSERT INTO [HRP].[dbo].[TimePlanLog]
                                    (Em_ID,LogTime,CK_in,Ck_Out1,CK_in2,Ck_Out2,CKOT_in1,CKOT_Out1,CKOT_in2,CKOT_Out2,Total,OTN,OTE,TotalOT1,TotalOT15,TotalOT2,TimePlan_Date,Admin_Update)
                                VALUES
                                    (
                                        '". $Em_ID ."',
                                        '". $LogTime ."',
                                        '". $row_check['CK_in'] ."',
                                        '". $row_check['Ck_Out1'] ."',
                                        '". $row_check['CK_in2'] ."',
                                        '". $row_check['Ck_Out2'] ."',
                                        '". $row_check['CKOT_in1'] ."',
                                        '". $row_check['CKOT_Out1'] ."',
                                        '". $row_check['CKOT_in2'] ."',
                                        '". $row_check['CKOT_Out2'] ."',
                                        '". $row_check['Total'] ."',
                                        '". $row_check['OTN'] ."',
                                        '". $row_check['OTE'] ."',
                                        '". $row_check['TotalOT1'] ."',
                                        '". $row_check['TotalOT15'] ."',
                                        '". $row_check['TotalOT2'] ."',
                                        '". $date_now ."',
                                        '". $_SESSION['SuperName'] ."')";
            mssql_query($sql_insert_log);
            // echo $sql_insert_log.'<br>';
            $sql_update = "  UPDATE 
                            [HRP].[dbo].[Time_Plan]
                        SET
                            CK_in = '".$date_ins."',
                            Ck_Out1 = '".$date_outs."',
                            CK_in2 = '".$date_ins2."',
                            Ck_Out2 = '".$date_outs2."',
                            CKOT_in1 = '".$date_OTins1."',
                            CKOT_Out1 = '".$date_OTouts1."',
                            CKOT_in2 = '".$date_OTins2."',
                            CKOT_Out2 = '".$date_OTouts2."',
                            Total = '". $cCK ."',
                            OTN = '". $N2 ."',
                            OTE = '". $N4 ."',
                            TotalOT1 = '',
                            TotalOT15 = '". $OT15 ."',
                            TotalOT2 = '". $OT2 ."',
                            TimePlan_Date = '".$date_now."',
                            Mny_1 = '". $B1 ."',
                            Mny_2 = '". $B2 ."',
                            Mny_3 = '". $B3 ."',
                            Mny_4 = '". $B4 ."',
                            Mny_5 = '". $B5 ."',
                            Admin_Update = '".$_SESSION['SuperName']."',
                            Site_ID = '".$_SESSION['SuperSite']."',
                            TimePlan_Status = '0',
                            TimePlan_Cal_Status = '1'
                        WHERE
                            Em_ID = '". $Em_ID ."'
                            AND LogTime = '". $LogTime ."' ";

            mssql_query($sql_update);
            // echo $sql_update.'<br>';
        }
        if($num_check == 0) {
            $sql_insert = " INSERT INTO [HRP].[dbo].[Time_Plan]
                                (Em_ID,LogTime,CK_in,Ck_Out1,CK_in2,Ck_Out2,CKOT_in1,CKOT_Out1,CKOT_in2,CKOT_Out2,Total,OTN,OTE,TotalOT1,TotalOT15,TotalOT2,TimePlan_Date,Admin_Update,Site_ID,Mny_1,Mny_2,Mny_3,Mny_4,Mny_5,TimePlan_Status,TimePlan_Cal_Status)
                            VALUES
                                ('". $Em_ID ."', '". $LogTime ."', '". $date_ins ."', '". $date_outs ."', '". $date_ins2 ."', '". $date_outs2 ."','".$date_OTins1."', '".$date_OTouts1."', '".$date_OTins2."', '".$date_OTouts2."', '". $cCK ."', '". $N2 ."', '". $N4 ."', '0', '". $OT15 ."', '". $OT2 ."', '".$date_now."', '".$_SESSION['SuperName']."', '".$_SESSION['SuperSite']."', '". $B1 ."', '". $B2 ."', '". $B3 ."', '". $B4 ."', '". $B5 ."', '0', '1')";

            mssql_query($sql_insert);
            // echo $sql_insert.'<br>';

            if($_SESSION['Rule'] == '3') {
                $updateCheckWork = "UPDATE
                                        [HRP].[dbo].[AuditWorkDay]
                                    SET 
                                        Check_in = '1'
                                    WHERE
                                        Check_day = '". $date_now ."' ";
                mssql_query($updateCheckWork);
            }
        }

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
                    Em_ID = '". $Em_ID ."'
                    AND LogTime = '". $LogTime ."'
                ORDER BY
                    Em_ID, LogTime ";

            // echo $time.'<br>';
            $query_time = mssql_query($time);
            $num_time = mssql_num_rows($query_time);

            if($num_time > 1) {
                $row_time = mssql_fetch_array($query_time);
                // echo $row_em['Em_ID'].'-'.$row_time['LogTime'].'-'.$row_time['Admin_Update'].'-'.$row_time['Site_ID'].'<br>';

                $delete_time = "DELETE FROM [HRP].[dbo].[Time_Plan] WHERE Em_ID = '". $Em_ID ."' AND LogTime = '". $LogTime ."' ";
                mssql_query($delete_time);
                // echo $delete_time.'<br>';

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
                // echo $insert_time.'<br>';
            }
    }
?>
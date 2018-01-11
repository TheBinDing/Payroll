<?php
    @session_start();
    include("../inc/connect.php");

    $sql = "SELECT
                CK_in,
                Ck_Out1,
                CK_in2,
                Ck_Out2,
                LogTime,
                Em_ID
            FROM
                [HRP].[dbo].[Time_Plan]
            WHERE
                LogTime between '2017-06-01' and '2017-06-15'
                AND Site_ID = '26' ";
    $query = mssql_query($sql);
    $num = mssql_num_rows($query);

    for($i=1;$i<=$num;$i++) {
    	$row = mssql_fetch_array($query);

    	$Time = $row['LogTime'];
    	$ID = $row['Em_ID'];
    	// $m = explode(':', $row['CK_in']);
    	// $ms = (($m[0] * 60) + $m[1]);

    	// if($ms > 690) {
    	// 	$update = "UPDATE
    	// 					[HRP].[dbo].[Time_Plan]
    	// 				SET
    	// 					CK_in = ''
    	// 				WHERE
    	// 					Em_ID = '". $ID ."'
    	// 					AND LogTime = '". $Time ."' ";

    	// 	// echo $update.'<br>';
    	// 	mssql_query($update);
    	// }

        $update = "UPDATE
                        [HRP].[dbo].[Time_Plan]
                    SET
                        Ck_Out1 = '". $row['CK_in2'] ."',
                        CK_in2 = '". $row['Ck_Out2'] ."',
                        Ck_Out2 = ''
                    WHERE
                        Em_ID = '". $ID ."'
                        AND LogTime = '". $Time ."' ";

        mssql_query($update);
    }
?>
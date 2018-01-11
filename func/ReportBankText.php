<?php
    @session_start();
    require("../inc/connect.php");

    $Group = $_GET['Group'];
    $Site = $_GET['Site'];
    $Position = $_GET['Position'];
    $Period = $_GET['Period'];
	$Day = $_GET['Day'];

	$Day = new datetime($Day);
	$Day = $Day->format('ymd');

    $where .= !empty($Group)?  " AND (M.MT_GroupID = '". $Group ."') " : "";
    $where .= !empty($Position)?  " AND (M.MT_PositionID = '". $Position ."') " : "";

    $sql_site = "SELECT CAST(Site_Name as Text) as SiteName FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $Site ."' ";
    $query_site = mssql_query($sql_site);
    $row_site = mssql_fetch_assoc($query_site);

    $date = new datetime();
    $date = $date->format('ymd');

    $strExcelFileName = iconv('TIS-620', 'UTF-8', $row_site['SiteName']).'_'.$date.'_out'.".txt";
    header("Content-Disposition: attachment; filename=\"$strExcelFileName\"");

    $sql_period = "SELECT Per_Week AS PWeek, Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$Period."' ";
    $query_period = mssql_query($sql_period);
    $Periods = mssql_fetch_array($query_period);
    $Period_Start = new datetime($Periods['StartDate']);
    $Period_Start = $Period_Start->format('Y-m-d');
    $Period_End = new datetime($Periods['EndDate']);
    $Period_End = $Period_End->format('Y-m-d');
    $Period_Week = $Periods['PWeek'];

    $sql = " SELECT
                m.Em_ID as id,
                CAST(m.MT_Name as Text) as Fullname,
                CAST(m.MT_GroupName as Text) as GroupName,
                CAST(m.MT_PositionName as Text) as Position,
                m.MT_AccountNumber as Account,
				CAST(m.MT_Titel as Text) as Titel,
                m.MT_CashCard as CashCard
            FROM
                [HRP].[dbo].[Time_Plan] t
                left join [HRP].[dbo].[MoneyTotal] m on t.Em_ID = m.Em_ID
                left join [HRP].[dbo].[Sites] s on m.Site_ID = s.Site_ID
            WHERE
                s.Site_ID = '". $Site ."'
                AND m.MT_Period = '". $Period ."'
				AND m.MT_AccountNumber != ''
                $where
            GROUP BY
                m.Em_ID, m.MT_Name, m.MT_GroupName, m.MT_PositionName, m.MT_AccountNumber, m.MT_Titel, m.MT_CashCard
            ORDER BY
                m.MT_GroupName ASC ";
    $query = mssql_query($sql);
    $num = mssql_num_rows($query);

    for($i=1;$i<=$num;$i++) {
        $row = mssql_fetch_array($query);

        $explode = explode('-', $row['Account']);
        $Account = $explode[0].''.$explode[1].''.$explode[2].''.$explode[3];

		$sql_social = "SELECT MT_Totals AS Totals, MT_TotalOT1 AS TotalOT1, MT_TotalOT15 AS TotalOT15, MT_TotalOT2 AS TotalOT2, MT_SumTotals as mTotals , MT_Socail as Socials, MT_Mny_1 AS M1, MT_Mny_2 AS M2, MT_Mny_3 AS M3, MT_Mny_4 AS M4, MT_Mny_5 AS M5 FROM [HRP].[dbo].[MoneyTotal] where Em_ID = '".$row['id']."' and MT_Period = '".$Period."' ";
		$query_social = mssql_query($sql_social);
		$row_social = mssql_fetch_array($query_social);

		$sql_d = "SELECT
					SUM(L.List_Price) as price
				FROM
					[HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
				WHERE
					L.Em_ID = '". $row['id'] ."'
					AND L.List_Period = '". $Period ."'
					AND I.Item_Status = '0' ";

		$query_d = mssql_query($sql_d);
		$num_d = mssql_num_rows($query_d);
		$row_d = mssql_fetch_array($query_d);

		$price_d = $row_d['price'];
		$price_d = !empty($price_d)?  " $price_d " : "0";

		$sql_item = "SELECT
						L.List_Num,
						L.List_Price as Price,
						I.Item_Name as Item_Name,
						I.Item_Status as Status,
						L.List_Status AS List_Status
					FROM
						[HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
					WHERE
						L.Em_ID = '".$row['id']."'
						AND L.List_Status = '1'
						AND L.List_Period = '".$Period."' ";

		$q = mssql_query($sql_item);
		$n = mssql_num_rows($q);
		$Gl_1 = 0;$Gl_2 = 0;$Gl_3 = 0;$Gl_4 = 0;
		for($j=1;$j<=$n;$j++) {
			$r = mssql_fetch_array($q);
			$r_name = iconv('TIS-620', 'UTF-8', $r['Item_Name']);
			if($r_name == iconv('TIS-620', 'UTF-8', 'รายรับอื่นๆ')) {
				$Gl_1 = $Gl_1 + $r['Price'];
			}
			if($r_name == iconv('TIS-620', 'UTF-8', 'ค่าแรงตกงวดก่อน')) {
				$Gl_2 = $Gl_2 + $r['Price'];
			}
			if($r_name == iconv('TIS-620', 'UTF-8', 'ค่าล่วงเวลาพิเศษ')) {
				$Gl_3 = $Gl_3 + $r['Price'];
			}
			if($r_name == iconv('TIS-620', 'UTF-8', 'ค่าครองชีพ')) {
				$Gl_4 = $Gl_4 + $r['Price'];
			}
		}

		$TotalM = $row_social['M1'] + $row_social['M2'] + $row_social['M3'] + $row_social['M4'] + $row_social['M5'];
		$mTotals = $row_social['Totals'] + $row_social['TotalOT15'] + $row_social['TotalOT1'] + $row_social['TotalOT2'];
		$sumTotalGl = $TotalM + $Gl_1 + $Gl_2 + $Gl_3 + $Gl_4;
		// echo $Gl_1.'-'.$Gl_2.'-'.$Gl_3.'-'.$Gl_4.'<br>';
		// echo $row_social['Totals'].'-'.$row_social['TotalOT15'].'-'.$row_social['TotalOT1'].'-'.$row_social['TotalOT2'].'<br>';
		// echo $mTotals.'-'.$sumTotalGl.'-'.$row_social['Socials'].'-'.$price_d.'<br>';
		$IISJ = ((($mTotals + $sumTotalGl) - $row_social['Socials']) - $price_d);
		$Sums = $Sums + $IISJ;

		if($row['Titel'] == 'Mr') {
			$Titel = iconv('TIS-620', 'UTF-8', 'นาย');
		}
		if($row['Titel'] == 'Ms') {
			$Titel = iconv('TIS-620', 'UTF-8', 'นางสาว');
		}
		if($row['Titel'] == 'Mrs') {
			$Titel = iconv('TIS-620', 'UTF-8', 'นาง');
		}

        $FileName = str_pad($i,6,0,str_pad_left).' 7106 9999999 '.$Account.' '.str_pad(round($IISJ).'00',15,0,str_pad_left).' '.$Day.' '.str_pad($row['id'],5,0,str_pad_left).'                  '.$Titel.iconv('TIS-620', 'UTF-8', $row['Fullname']).'  '.iconv('TIS-620', 'UTF-8', $row['Lastname']);

		if($i == 1) {
			$FileNameAll = $FileName;
		} else {
			$FileNameAll = $FileNameAll."\r\n".$FileName;
		}
    }
    $num1 = $num + 1;
    $num2 = $num + 2;
    $ss = str_pad($num1,6,0,str_pad_left).' 9000'.'         '.'0000000000 '.str_pad(round($Sums).'00',15,0,str_pad_left).' 000000';
    $ssa = str_pad($num2,6,0,str_pad_left).' 9100'.'         '.'0000000000 '.str_pad(round($Sums).'00',15,0,str_pad_left).' 000000';
	$FileNames = $FileNameAll."\r\n".$ss."\r\n".$ssa;
	$FileNames = (String)$FileNames;
	print($FileNames);
?>
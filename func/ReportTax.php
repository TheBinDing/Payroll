<?php
    @session_start();
    require("../inc/connect.php");

    $Site = $_GET['Site'];
    $Period = $_GET['Period'];
    $Year = $_GET['Year'];
    $Months = $_GET['Month'];

    if($Period % 2 == 0) {
        $PeriodF = ($Period - 1);
    }

    $sql_period_start = "SELECT Per_StartDate FROM [HRP].[dbo].[Periods] WHERe Per_ID = '".$PeriodF."'";
    $query_period_start = mssql_query($sql_period_start);
    $row_period_start = mssql_fetch_assoc($query_period_start);

    $sql_period_end = "SELECT Per_EndDate FROM [HRP].[dbo].[Periods] WHERe Per_ID = '".$Period."'";
    $query_period_end = mssql_query($sql_period_end);
    $row_period_end = mssql_fetch_assoc($query_period_end);

    $Period_Start = $row_period_start['Per_StartDate'];
    $Period_End = $row_period_end['Per_EndDate'];

    $sql_site = "SELECT CAST(Site_Name as Text) as SiteName FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $Site ."' ";
    $query_site = mssql_query($sql_site);
    $row_site = mssql_fetch_assoc($query_site);

    $strExcelFileName = 'โครงการ '.':'.$row_site['SiteName'].".xls";".xls";
    header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
    header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
    header("Pragma:no-cache");

    if(!empty($Months)) {
        $YY = new datetime();
        $Year = $YY->format('Y');
        if($Months == 1) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '31-0'.$Months.'-'.$Year;
        }
        if($Months == 2) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '28-0'.$Months.'-'.$Year;
        }
        if($Months == 3) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '31-0'.$Months.'-'.$Year;
        }
        if($Months == 4) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '30-0'.$Months.'-'.$Year;
        }
        if($Months == 5) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '31-0'.$Months.'-'.$Year;
        }
        if($Months == 6) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '30-0'.$Months.'-'.$Year;
        }
        if($Months == 7) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '31-0'.$Months.'-'.$Year;
        }
        if($Months == 8) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '31-0'.$Months.'-'.$Year;
        }
        if($Months == 9) {
            $Period_Start = '01-0'.$Months.'-'.$Year;
            $Period_End = '30-0'.$Months.'-'.$Year;
        }
        if($Months == 10) {
            $Period_Start = '01-'.$Months.'-'.$Year;
            $Period_End = '31-'.$Months.'-'.$Year;
        }
        if($Months == 11) {
            $Period_Start = '01-'.$Months.'-'.$Year;
            $Period_End = '30-'.$Months.'-'.$Year;
        }
        if($Months == 12) {
            $Period_Start = '01-'.$Months.'-'.$Year;
            $Period_End = '31-'.$Months.'-'.$Year;
        }
    }

    $sql_period = "SELECT Per_ID FROM [HRP].[dbo].[Periods] WHERE Per_StartDate = '".$Period_Start."' or Per_EndDate = '".$Period_End."' ";
    $query_period = mssql_query($sql_period);
    $num_period = mssql_num_rows($query_period);

    for($v=1;$v<=$num_period;$v++) {
        $row_period = mssql_fetch_array($query_period);
        if($v == 1) {
            $per = "AND MT_Period between '".$row_period['Per_ID']."' ";
            $per_s = $row_period['Per_ID'];
        } else {
            $per .= " AND '".$row_period['Per_ID']."' ";
            $per_e = $row_period['Per_ID'];
        }
    }

	$sql = "SELECT
				m.Em_ID as Em_ID,
				m.MT_Card as Cards,
				m.MT_Name as Names,
				m.MT_Titel as Titel,
				SUM(CAST(m.MT_Totals as int)) as Total,
				SUM(CAST(m.MT_TotalOT1 as int)) as TO1,
				SUM(CAST(m.MT_TotalOT15 as int)) as TO15,
				SUM(CAST(m.MT_TotalOT2 as int)) as TO2,
				SUM(CAST(m.MT_Socail as int)) as Socail,
				SUM(CAST(m.MT_Mny_1 as int)) as Mny1,
				SUM(CAST(m.MT_Mny_2 as int)) as Mny2,
				SUM(CAST(m.MT_Mny_3 as int)) as Mny3,
				SUM(CAST(m.MT_Mny_4 as int)) as Mny4
			FROM
				[HRP].[dbo].[MoneyTotal] m
			WHERE
				m.Site_ID = '". $Site ."'
				AND m.MT_Period between '". $per_s ."' AND '". $per_e ."'
			GROUP BY
				m.Em_ID,
				m.MT_Card,
				m.MT_Name,
				m.MT_Titel ";
	$query = mssql_query($sql);
	$num = mssql_num_rows($query);
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
    <body>
        <div id="SiXhEaD_Excel" align="center" x:publishsource="Excel">
            <table x:str border=1 cellpadding=0 cellspacing=1 width=100% style="border-collapse:collapse">
                <tr>
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">บัตรประจำตัวประชาชน
                    </td>
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ชื่อ-สกุล
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ปกติ
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ล่วงเวลา1
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ล่วงเวลา1.5
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ล่วงเวลา2
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ค่าร้านค้า
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ค่าอุปกรณ์รวม
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ค่า Adv
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ค่าใช้จ่าย อื่นๆ
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ค่าครองชีพ
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ค่าแรงตกงวดก่อน
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ค่าล่วงเวลาพิเศษ
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">รายรับอื่นๆ
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ประกันสังคม
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">เบี้ยเลี้ยง
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">ค่าเลี้ยงภัย
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">เบี้ยเลี้ยงเซตตี้
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">เบี้ยเลี้ยงพิเศษ
                    </td>
                </tr>
                <?php
                    while($row = mssql_fetch_array($query)) {
                        $Titel = $row['Titel'];

                        if($Titel == 'Mr') {
                            $Titel = 'นาย';
                        }
                        if($Titel == 'Ms') {
                            $Titel = 'นาง';
                        }
                        if($Titel == 'Mrs') {
                            $Titel = 'นางสาว';
                        }

						$item = "SELECT
									l.List_Price as Price,
									i.Item_Name as Item_Name
								FROM
									[HRP].[dbo].[Item_List] l inner join
									[HRP].[dbo].[Items] i on l.Item_ID = i.Item_ID
								WHERE
									Site_ID = '". $Site ."'
									AND Per_ID between '". $per_s ."' AND '". $per_e ."'
									AND i.Item_Status = '0'
									AND Em_ID = '". $row['Em_ID'] ."' ";

						$query_item = mssql_query($item);
						$num = mssql_num_rows($query);

						$PriceOne = '0';
						$PriceTwo = '0';
						$PriceThree = '0';
						$PriceFour = '0';

						for($one=1;$one<=$num;$one++) {
							$row_item = mssql_fetch_array($query_item);

							if(iconv('TIS-620','UTF-8', $row_item['Item_Name']) == 'ค่าร้านค้า') {
								$PriceOne = $row_item['Price'];
							}
							if(iconv('TIS-620','UTF-8', $row_item['Item_Name']) == 'ค่าอุปกรณ์รวม') {
								$PriceTwo = $row_item['Price'];
							}
							if(iconv('TIS-620','UTF-8', $row_item['Item_Name']) == 'ค่า Adv') {
								$PriceThree = $row_item['Price'];
							}
							if(iconv('TIS-620','UTF-8', $row_item['Item_Name']) == 'ค่าใช้จ่าย อื่นๆ') {
								$PriceFour = $row_item['Price'];
							}
						}

						$item_one = "SELECT
										l.List_Price as Price,
										i.Item_Name as Item_Name
									FROM
										[HRP].[dbo].[Item_List] l inner join
										[HRP].[dbo].[Items] i on l.Item_ID = i.Item_ID
									WHERE
										Site_ID = '". $Site ."'
										AND Per_ID between '". $per_s ."' AND '". $per_e ."'
										AND i.Item_Status = '1'
										AND Em_ID = '". $row['Em_ID'] ."' ";

						$query_one = mssql_query($item_one);
						$num_one = mssql_num_rows($query_one);

						$PriceOOne = '0';
						$PriceOTwo = '0';
						$PriceOThree = '0';
						$PriceOFour = '0';

						for($oone=1;$oone<=$num_one;$oone++) {
							$row_one = mssql_fetch_array($query_one);

							if(iconv('TIS-620','UTF-8', $row_one['Item_Name']) == 'ค่าครองชีพ') {
								$PriceOOne = $row_one['Price'];
							}
							if(iconv('TIS-620','UTF-8', $row_one['Item_Name']) == 'ค่าแรงตกงวดก่อน') {
								$PriceOTwo = $row_one['Price'];
							}
							if(iconv('TIS-620','UTF-8', $row_one['Item_Name']) == 'ค่าล่วงเวลาพิเศษ') {
								$PriceOThree = $row_one['Price'];
							}
							if(iconv('TIS-620','UTF-8', $row_one['Item_Name']) == 'รายรับอื่นๆ') {
								$PriceOFour = $row_one['Price'];
							}
						}
                ?>
                <tr>
                    <td height="25" align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Cards']; ?></td>
                    <td align="left" valign="middle" style="font-size: 15px;"><?php echo $Titel.' '.iconv('TIS-620','UTF-8', $row['Names']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['Total']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['TO1']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['TO15']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['TO2']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($PriceOne); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($PriceTwo); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($PriceThree); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($PriceFour); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($PriceOOne); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($PriceOTwo); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($PriceOThree); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($PriceOFour); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['Socail']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['Mny1']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['Mny2']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['Mny3']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['Mny4']); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>

<script>
    window.onbeforeunload = function(){return false;};
    setTimeout(function(){window.close();}, 10000);
</script>
<?php
    @session_start();
    require("../inc/connect.php");

    $Site = $_GET['Site'];;
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

    $strExcelFileName = 'ประกันสังคม-'.' '.iconv('TIS-620', 'UTF-8', $row_site['SiteName']).".xls";
    header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
    header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
    header("Pragma:no-cache");

    // $sql_period = "SELECT Per_Week AS PWeek, Per_StartDate AS StartDate, Per_EndDate AS EndDate FROM [HRP].[dbo].[Periods] WHERE Per_ID = '".$Period."' ";
    // $query_period = mssql_query($sql_period);
    // $Periods = mssql_fetch_array($query_period);
    // $Period_Start = new datetime($Periods['StartDate']);
    // $Period_Start = $Period_Start->format('Y-m-d');
    // $Period_End = new datetime($Periods['EndDate']);
    // $Period_End = $Period_End->format('Y-m-d');
    // $Period_Week = $Periods['PWeek'];

    $M = explode('-', $Period_Start);

    if($M[1] == 1 || $Months == 1) {
        $Month = 'มกราคม';
    }
    if($M[1] == 2 || $Months == 2) {
        $Month = 'กุมภาพันธ์';
    }
    if($M[1] == 3 || $Months == 3) {
        $Month = 'มีนาคม';
    }
    if($M[1] == 4 || $Months == 4) {
        $Month = 'เมษายน';
    }
    if($M[1] == 5 || $Months == 5) {
        $Month = 'พฤษภาคม';
    }
    if($M[1] == 6 || $Months == 6) {
        $Month = 'มิถุนายม';
    }
    if($M[1] == 7 || $Months == 7) {
        $Month = 'กรกฏาคม';
    }
    if($M[1] == 8 || $Months == 8) {
        $Month = 'สิงหาคม';
    }
    if($M[1] == 9 || $Months == 9) {
        $Month = 'กันยายน';
    }
    if($M[1] == 10 || $Months == 10) {
        $Month = 'ตุลาคม';
    }
    if($M[1] == 11 || $Months == 11) {
        $Month = 'พฤศจิกายน';
    }
    if($M[1] == 12 || $Months == 12) {
        $Month = 'ธันวาคม';
    }

    if(!empty($Months)) {
        /*$YY = new datetime();
        $Year = $YY->format('Y');*/
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

    echo $sql_period = "SELECT Per_ID FROM [HRP].[dbo].[Periods] WHERE Per_StartDate = '".$Period_Start."' or Per_EndDate = '".$Period_End."' ";
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

    $sql_site = "SELECT
					e.Em_ID,
					e.Em_card as Card,
					e.Em_Titel as Titel,
					CAST(e.Em_Fullname as Text) as Fullname,
					CAST(e.Em_Lastname as Text) as Lastname,
					e.Em_People AS People
				FROM
					[HRP].[dbo].[Employees] e inner join
					[HRP].[dbo].[MoneyTotal] m on e.Em_ID = m.Em_ID
				WHERE
                    m.Site_ID = '".$Site."'
					AND m.MT_Period between '".$per_s."' AND '".$per_e."'
				GROUP BY
					e.Em_ID,
					e.Em_card,
					e.Em_Titel,
					e.Em_Fullname,
					e.Em_Lastname,
					e.Em_People
				ORDER BY
					Em_ID desc ";

    $query_site = mssql_query($sql_site);
	/*echo $sql_site.'<br>';*/

    $response = array();
    while ($row_site = mssql_fetch_array($query_site))
    {
        $response[] = $row_site;
    }
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
                    <td colspan="7">
                        <div align="center" style="font-size: 15px;">บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</div>
                        <div align="center" style="font-size: 15px;">เลขที่บัญชี 1000136990</div>
                        <div align="center" style="font-size: 15px;">เงินสมทบ ประจำเดือน <?php echo ' '.$Month; ?></div>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ลำดับ</strong></td>
                    <td width="60" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>เลขที่บัตรประชาชน</strong></td>
                    <td width="69" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>คำนำหน้า</strong></td>
                    <td width="69" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ชื่อ</strong></td>
                    <td width="69" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>นามสกุล</strong></td>
                    <td width="160" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ค่าแรงปกติ</strong></td>
                    <td width="180" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>เงินสมทบ</strong></td>
                </tr>
                <?php
                    foreach ($response as $key => $value) {
                        $sql = " SELECT
                                    SUM(CAST(MT_Totals as float)) as Totals
                                FROM
                                    [HRP].[dbo].[MoneyTotal]
                                WHERE
                                    Site_ID = '".$Site."'
                                    AND Em_ID = '".$value['Em_ID']."'
                                    $per ";
                        $query = mssql_query($sql);
                        $num = mssql_num_rows($query);
                        
                        $sql_Socail = " SELECT
                                    SUM(CAST(MT_Socail as float)) as Socail
                                FROM
                                    [HRP].[dbo].[MoneyTotal]
                                WHERE
                                    Site_ID = '".$Site."'
                                    AND Em_ID = '".$value['Em_ID']."'
                                    $per ";
                        $query_Socail = mssql_query($sql_Socail);
                        $num_Socail = mssql_num_rows($query_Socail);

                        if($value['Titel'] == 'Mr') {
                            $Titel = 'นาย';
                        }
                        if($value['Titel'] == 'Ms') {
                            $Titel = 'นางสาว';
                        }
                        if($value['Titel'] == 'Mrs') {
                            $Titel = 'นาง';
                        }
                        $row = mssql_fetch_array($query);
                        $row_Socail = mssql_fetch_array($query_Socail);

                        $zz = ($zz + 1);

                        if($row['Totals'] != 0) {
                ?>
                <tr>
                    <td height="25" align="center" valign="middle" style="font-size: 15px;"><?php echo $zz.'-'.$value['People']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $value['Card']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $Titel; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620', 'UTF-8', $value['Fullname']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620', 'UTF-8', $value['Lastname']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($row['Totals']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;">
                        <?php
                            echo number_format($row_Socail['Socail']);
                        ?>
                    </td>
                </tr>
                <?php
                        }
                        $sum = $sum + $row['Totals'];
                        $sum1 = $sum1 + $row_Socail['Socail'];
                    }
                ?>
                <tr>
                    <td height="25" align="center" valign="middle" style="font-size: 15px;"></td>
                    <td align="center" valign="middle" style="font-size: 15px;"></td>
                    <td align="center" valign="middle" style="font-size: 15px;"></td>
                    <td align="center" valign="middle" style="font-size: 15px;"></td>
                    <td align="center" valign="middle" style="font-size: 15px;"></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo number_format($sum); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;">
                        <?php
                            echo number_format($sum1);
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>

<script>
    window.onbeforeunload = function(){return false;};
    setTimeout(function(){window.close();}, 10000);
</script>
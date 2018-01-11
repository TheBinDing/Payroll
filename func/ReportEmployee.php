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

    $strExcelFileName = iconv('TIS-620','UTF-8', 'รายชื่อพนักงาน').':'.$row_site['SiteName'].".xls";".xls";
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
                e.Em_ID AS Em_ID,
                e.Em_Card AS Card,
                CAST(e.Em_Fullname AS Text) AS Fullname,
                CAST(e.Em_Lastname AS Text) AS Lastname,
                e.Em_Money AS Moneies,
                e.Em_Titel AS Sex,
                e.Em_DateBirthDay AS BrithDay,
                CAST(e.Em_Address AS Text) AS Address,
                e.Em_Mobile AS Phone,
                e.Em_DateOpen AS OpenWork,
                e.Em_DateBlacklist AS OutWork,
                e.Em_Status_Reason AS Remark,
                e.Em_BankBranch AS BankName,
                e.Em_AccountNumber AS BankNum,
                e.Em_LivingExpenses AS LivingExpenses,
                CAST(s.Site_Name AS Text) AS Site_Name,
                CAST(g.Group_Name AS Text) AS Group_Name,
                CAST(p.Pos_Name AS Text) AS Pos_Name,
                b.Blood_Name AS Blood,
                CAST(ba.Bank_Name AS Text) AS Bank
            FROM
                [HRP].[dbo].[Employees] e inner join
                [HRP].[dbo].[MoneyTotal] m on e.Em_ID = m.Em_ID inner join
                [HRP].[dbo].[Sites] s on e.Site_ID = s.Site_ID inner join
                [HRP].[dbo].[Group] g on e.Group_ID = g.Group_ID inner join
                [HRP].[dbo].[Position] p on e.Pos_ID = p.Pos_ID inner join
                [HRP].[dbo].[GroupBlood] b on e.Blood_ID = b.Blood_ID inner join
                [HRP].[dbo].[Banks] ba on e.Bank_ID = ba.Bank_ID
            WHERE
                m.Site_ID = '".$Site."'
                AND m.MT_Period between '".$per_s."' AND '".$per_e."'
            GROUP BY
                e.Em_ID,
                e.Em_Card,
                e.Em_Fullname,
                e.Em_Lastname,
                e.Em_Money,
                e.Em_Titel,
                e.Em_DateBirthDay,
                e.Em_Address,
                e.Em_Mobile,
                e.Em_DateOpen,
                e.Em_DateBlacklist,
                e.Em_Status_Reason,
                e.Em_BankBranch,
                e.Em_AccountNumber,
                e.Em_LivingExpenses,
                s.Site_Name,
                g.Group_Name,
                p.Pos_Name,
                b.Blood_Name,
                ba.Bank_Name
            ORDER BY
                Em_ID desc ";
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
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'รหัสบัตรประชาชน'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'รหัสพนักงาน'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'เพศ'); ?></strong>
                    </td>
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'ชื่อ-นามสกุล'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'ค่าแรง'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'ตำแหน่ง'); ?></strong>
                    </td>
                    <td width="110" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'ชุด'); ?></strong>
                    </td>
                    <td width="250" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'โครงการ'); ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'วันเกิด'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'กรุ๊ปเลือด'); ?></strong>
                    </td>
                    <td width="250" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'ที่อยู่'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'เบอร์โทร'); ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'เริ่มทำงาน'); ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'วันที่ออกจากงาน'); ?></strong>
                    </td>
                    <td width="120" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'รายละเอียด'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'ธนาคาร'); ?></strong>
                    </td>
                    <td width="120" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'ชื่อธนาคาร'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'เลขบัญชี'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', 'เบี้ยเลี้ยง'); ?></strong>
                    </td>
                </tr>
            <?php
            if($num > 0){
            while($row = mssql_fetch_array($query)) {
                if($row['Sex'] == 'Mr') {
                    $Titel = 'นาย ';
                }
                if($row['Sex'] == 'Ms') {
                    $Titel = 'นางสาว ';
                }
                if($row['Sex'] == 'Mrs') {
                    $Titel = 'นาง ';
                }

                $BrithDay = new datetime($row['BrithDay']);
                $BrithDay = $BrithDay->format('d-m-Y');
                $BrithDay = explode('-', $BrithDay);
                if($BrithDay[1] == '01') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'มกราคม');
                }
                if($BrithDay[1] == '02') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'กุมภาพันธ์');
                }
                if($BrithDay[1] == '03') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'มีนาคม');
                }
                if($BrithDay[1] == '04') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'เมษายน');
                }
                if($BrithDay[1] == '05') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'พฤษภาคม');
                }
                if($BrithDay[1] == '06') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'มิถุนายน');
                }
                if($BrithDay[1] == '07') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'กรกฏาคม');
                }
                if($BrithDay[1] == '08') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'สิงหาคม');
                }
                if($BrithDay[1] == '09') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'กันยายน');
                }
                if($BrithDay[1] == '10') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'ตุลาคม');
                }
                if($BrithDay[1] == '11') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'พฤศจิกายน');
                }
                if($BrithDay[1] == '12') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', 'ธันวาคม');
                }
                $BrithDay = $BrithDay[0].'-'.$BrithDay[1].'-'.($BrithDay[2]+543);

                $OpenWork = new datetime($row['OpenWork']);
                $OpenWork = $OpenWork->format('d-m-Y');
                $OpenWork = explode('-', $OpenWork);
                if($OpenWork[1] == '01') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'มกราคม');
                }
                if($OpenWork[1] == '02') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'กุมภาพันธ์');
                }
                if($OpenWork[1] == '03') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'มีนาคม');
                }
                if($OpenWork[1] == '04') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'เมษาคม');
                }
                if($OpenWork[1] == '05') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'พฤษภาคม');
                }
                if($OpenWork[1] == '06') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'มิถุนายน');
                }
                if($OpenWork[1] == '07') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'กรกฏาคม');
                }
                if($OpenWork[1] == '08') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'สิงหาคม');
                }
                if($OpenWork[1] == '09') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'กันยายน');
                }
                if($OpenWork[1] == '10') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'ตุลาคม');
                }
                if($OpenWork[1] == '11') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'พฤศจิกายน');
                }
                if($OpenWork[1] == '12') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', 'ธันวาคม');
                }
                $OpenWork = $OpenWork[0].'-'.$OpenWork[1].'-'.($OpenWork[2]+543);

                $OutWork = new datetime($row['OutWork']);
                $OutWork = $OutWork->format('d-m-Y');
                $OutWork = explode('-', $OutWork);
                if($OutWork[1] == '01') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'มกราคม');
                }
                if($OutWork[1] == '02') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'กุมภาพันธ์');
                }
                if($OutWork[1] == '03') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'มีนาคม');
                }
                if($OutWork[1] == '04') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'เมษาคม');
                }
                if($OutWork[1] == '05') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'พฤษภาคม');
                }
                if($OutWork[1] == '06') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'มิถุนายน');
                }
                if($OutWork[1] == '07') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'กรกฏาคม');
                }
                if($OutWork[1] == '08') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'สิงหาคม');
                }
                if($OutWork[1] == '09') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'กันยายน');
                }
                if($OutWork[1] == '10') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'ตุลาคม');
                }
                if($OutWork[1] == '11') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'พฤศจิกายน');
                }
                if($OutWork[1] == '12') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', 'ธันวาคม');
                }
                $OutWork = $OutWork[0].'-'.$OutWork[1].'-'.($OutWork[2]+543);

				if($OutWork == '01-01-1900') {
					$OutWork = '';
				}
            ?>
                <tr>
                    <td height="25" align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Card']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Em_ID']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $Titel); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Fullname']).' '.iconv('TIS-620','UTF-8', $row['Lastname']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Moneies']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Pos_Name']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Group_Name']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Site_Name']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $BrithDay; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Blood']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Address']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Phone']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $OpenWork; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $OUT; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Remark']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Bank']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['BankName']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['BankNum']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['LivingExpenses']; ?></td>
                </tr>
            <?php
            }
            }
            ?>
            </table>
        </div>
    </body>
</html>

<script>
    window.onbeforeunload = function(){return false;};
    setTimeout(function(){window.close();}, 10000);
</script>
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

    $strExcelFileName = 'รายงานค่าครองชีพ'.':'.$row_site['SiteName'].".xls";".xls";
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
                Em_ID,
                MT_Titel as Titel,
                CAST(MT_Name as text) as name,
                CAST(MT_PositionName as text) as position,
                CAST(MT_GroupName as text) as groups
            FROM
                [HRP].[dbo].[MoneyTotal]
            WHERE
                Site_ID = '". $Site ."'
                AND MT_Year = '". $Year ."' ";
    if(!empty($Months)) {
        $sql .= " AND MT_Period between '".$per_s."' AND '".$per_e."' ";
    } else {
        $sql .= " AND MT_Period = '". $Period ."' ";
    }
    $sql .= " ORDER BY
                Em_Id ASC ";
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
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ลำดับ'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ชื่อ-นามสกุล'; ?></strong>
                    </td>
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ตำแหน่ง'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ชุด'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ค่าครองชีพ'; ?></strong>
                    </td>
                </tr>
            <?php
            for($i=1;$i<=$num;$i++) {
                $row = mssql_fetch_array($query);
                if($row['Titel'] == 'Mr') {
                    $Titel = 'นาย';
                }
                if($row['Titel'] == 'Ms') {
                    $Titel = 'นางสาว';
                }
                if($row['Titel'] == 'Mrs') {
                    $Titel = 'นาง';
                }

                $IDs = $row['Em_ID'];

                $sql_loop = "SELECT
                                l.List_Price as Price
                            FROM
                                [HRP].[dbo].[Item_List] l inner join
                                [HRP].[dbo].[Items] i on l.Item_ID = i.Item_ID
                            WHERE
                                i.Item_ID = '5'
                                AND l.Em_ID = '". $IDs ."'
                                AND l.Per_ID between '".$per_s."' AND '".$per_e."' ";
                $query_loop = mssql_query($sql_loop);
                $num_loop = mssql_num_rows($query_loop);

                $price = 0;

                for($z=1;$z<=$num_loop;$z++) {
                    $row_loop = mssql_fetch_array($query_loop);

                    $price = $price + $row_loop['Price'];

                    $a = $a + $z;
            ?>
                <tr>
                    <td height="25" valign="middle" style="font-size: 15px;text-align: center;"><?php echo $a; ?></td>
                    <td height="25" valign="middle" style="font-size: 15px;"><?php echo $Titel.' '.iconv('TIS-620','UTF-8', $row['name']); ?></td>
                    <td height="25" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['position']); ?></td>
                    <td height="25" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['groups']); ?></td>
                    <td height="25" valign="middle" style="font-size: 15px;text-align: center;"><?php echo number_format($price); ?></td>
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
<?php
    @session_start();
    require("inc/connect.php");

    $sql_site = "SELECT CAST(Site_Name as Text) as SiteName FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
    $query_site = mssql_query($sql_site);
    $row_site = mssql_fetch_assoc($query_site);

    $strExcelFileName = 'รายชื่อพนักงาน'.':'.iconv('TIS-620', 'UTF-8', $row_site['SiteName']).".xls";
    // header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
    // header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
    // header("Pragma:no-cache");

    $sql = "SELECT
                E.Em_ID AS Em_ID,
                E.Em_Card AS Card,
                CAST(E.Em_Fullname AS Text) AS Fullname,
                E.Em_Money AS Moneies,
                E.Em_Titel AS Sex,
                CAST(S.Site_Name AS Text) AS Site_Name,
                CAST(G.Group_Name AS Text) AS Group_Name,
                CAST(P.Pos_Name AS Text) AS Pos_Name,
                E.Em_DateBirthDay AS BrithDay,
                B.Blood_Name AS Blood,
                CAST(E.Em_Address AS Text) AS Address,
                E.Em_Mobile AS Phone,
                E.Em_DateOpen AS OpenWork,
                E.Em_DateBlacklist AS OutWork,
                E.Em_Status_Reason AS Remark,
                CAST(Ba.Bank_Name AS Text) AS Bank,
                E.Em_BankBranch AS BankName,
                E.Em_AccountNumber AS BankNum,
                E.Em_LivingExpenses AS LivingExpenses
            FROM
                [HRP].[dbo].[Employees] AS E,
                [HRP].[dbo].[Sites] AS S,
                [HRP].[dbo].[Group] AS G,
                [HRP].[dbo].[Position] AS P,
                [HRP].[dbo].[GroupBlood] AS B,
                [HRP].[dbo].[Banks] AS Ba
            WHERE
                E.Site_ID = S.Site_ID
                AND E.Group_ID = G.Group_ID
                AND E.Pos_ID = P.Pos_ID
                AND E.Blood_ID = B.Blood_ID
                AND E.Bank_ID = Ba.Bank_ID
                AND E.Site_ID = '". $_SESSION['SuperSite'] ."' ";
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
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">รหัสบัตรประชาชน</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>รหัสพนักงาน</strong></td>
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ชื่อ-นามสกุล</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ค่าแรง</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>เพศ</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ตำแหน่ง</strong></td>
                    <td width="110" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ชุด</strong></td>
                    <td width="250" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>โครงการ</strong></td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>วันเกิด</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>กรุ๊ปเลือด</strong></td>
                    <td width="250" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ที่อยู่</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>เบอร์โทร</strong></td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>เริ่มทำงาน</strong></td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>วันที่ออกจากงาน</strong></td>
                    <td width="120" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>รายละเอียด</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ธนาคาร</strong></td>
                    <td width="120" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ชื่อธนาคาร</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>เลขบัญชี</strong></td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>เบี้ยเลี้ยง</strong></td>
                </tr>
            <?php
            if($num > 0){
            while($row = mssql_fetch_array($query)) {
                if($row['Titel'] == 'Mr') {
                    $Titel = 'นาย ';
                }
                if($row['Titel'] == 'Ms') {
                    $Titel = 'นางสาว ';
                }
                if($row['Titel'] == 'Mrs') {
                    $Titel = 'นาง ';
                }

				$BrithDay = new datetime($row['BrithDay']);
				$BrithDay = $BrithDay->format('d-M-Y');

				$OpenWork = new datetime($row['OpenWork']);
				$OpenWork = $OpenWork->format('d-M-Y');

				$OutWork = new datetime($row['OutWork']);
				$OutWork = $OutWork->format('d-M-Y');

				if($OutWork == '01-01-1900') {
					$OutWork = '';
				}
            ?>
                <tr>
                    <td height="25" align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Card']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Em_ID']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Fullname']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Moneies']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Sex']; ?></td>
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
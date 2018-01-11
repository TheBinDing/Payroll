<?php
    @session_start();
    require("../inc/connect.php");

    $Status = $_GET['Status'];

    $sql_site = "SELECT CAST(Site_Name as Text) as SiteName FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
    $query_site = mssql_query($sql_site);
    $row_site = mssql_fetch_assoc($query_site);

    $strExcelFileName = 'รายชื่อพนักงาน : '.$row_site['SiteName'].".xls";".xls";
    header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
    header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
    header("Pragma:no-cache");

    $sql = "SELECT
                E.Em_ID AS Em_ID,
                E.Em_Card AS Card,
                CAST(E.Em_Fullname AS Text) AS Fullname,
                CAST(E.Em_Lastname AS Text) AS Lastname,
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
                E.Em_LivingExpenses AS LivingExpenses,
                CAST(R.Re_Name AS Text) AS Re_Name
            FROM
                [HRP].[dbo].[Employees] AS E,
                [HRP].[dbo].[Sites] AS S,
                [HRP].[dbo].[Group] AS G,
                [HRP].[dbo].[Position] AS P,
                [HRP].[dbo].[GroupBlood] AS B,
                [HRP].[dbo].[Banks] AS Ba,
                [HRP].[dbo].[Religion] AS R
            WHERE
                E.Site_ID = S.Site_ID
                AND E.Group_ID = G.Group_ID
                AND E.Pos_ID = P.Pos_ID
                AND E.Blood_ID = B.Blood_ID
                AND E.Bank_ID = Ba.Bank_ID
                AND E.Re_ID = R.Re_ID
                AND E.Em_Status = '". $Status ."'
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
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'รหัสบัตรประชาชน'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'รหัสพนักงาน'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'เพศ'; ?></strong>
                    </td>
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ชื่อ-นามสกุล'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'สัญชาติ'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ค่าแรง'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ตำแหน่ง'; ?></strong>
                    </td>
                    <td width="110" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ชุด'; ?></strong>
                    </td>
                    <td width="250" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'โครงการ'; ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'วันเกิด'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'กรุ๊ปเลือด'; ?></strong>
                    </td>
                    <td width="250" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ที่อยู่'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'เบอร์โทร'; ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'เริ่มทำงาน'; ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'วันที่ออกจากงาน'; ?></strong>
                    </td>
                    <td width="120" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'รายละเอียด'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ธนาคาร'; ?></strong>
                    </td>
                    <td width="120" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'ชื่อธนาคาร'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'เลขบัญชี'; ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo 'เบี้ยเลี้ยง'; ?></strong>
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
                    $BrithDay[1] = 'มกราคม';
                }
                if($BrithDay[1] == '02') {
                    $BrithDay[1] = 'กุมภาพันธ์';
                }
                if($BrithDay[1] == '03') {
                    $BrithDay[1] = 'มีนาคม';
                }
                if($BrithDay[1] == '04') {
                    $BrithDay[1] = 'เมษายน';
                }
                if($BrithDay[1] == '05') {
                    $BrithDay[1] = 'พฤษภาคม';
                }
                if($BrithDay[1] == '06') {
                    $BrithDay[1] = 'มิถุนายน';
                }
                if($BrithDay[1] == '07') {
                    $BrithDay[1] = 'กรกฏาคม';
                }
                if($BrithDay[1] == '08') {
                    $BrithDay[1] = 'สิงหาคม';
                }
                if($BrithDay[1] == '09') {
                    $BrithDay[1] = 'กันยายน';
                }
                if($BrithDay[1] == '10') {
                    $BrithDay[1] = 'ตุลาคม';
                }
                if($BrithDay[1] == '11') {
                    $BrithDay[1] = 'พฤศจิกายน';
                }
                if($BrithDay[1] == '12') {
                    $BrithDay[1] = 'ธันวาคม';
                }
                $BrithDay = $BrithDay[0].'-'.$BrithDay[1].'-'.($BrithDay[2]+543);

                $OpenWork = new datetime($row['OpenWork']);
                $OpenWork = $OpenWork->format('d-m-Y');
                $OpenWork = explode('-', $OpenWork);
                if($OpenWork[1] == '01') {
                    $OpenWork[1] = 'มกราคม';
                }
                if($OpenWork[1] == '02') {
                    $OpenWork[1] = 'กุมภาพันธ์';
                }
                if($OpenWork[1] == '03') {
                    $OpenWork[1] = 'มีนาคม';
                }
                if($OpenWork[1] == '04') {
                    $OpenWork[1] = 'เมษายน';
                }
                if($OpenWork[1] == '05') {
                    $OpenWork[1] = 'พฤษภาคม';
                }
                if($OpenWork[1] == '06') {
                    $OpenWork[1] = 'มิถุนายน';
                }
                if($OpenWork[1] == '07') {
                    $OpenWork[1] = 'กรกฏาคม';
                }
                if($OpenWork[1] == '08') {
                    $OpenWork[1] = 'สิงหาคม';
                }
                if($OpenWork[1] == '09') {
                    $OpenWork[1] = 'กันยายน';
                }
                if($OpenWork[1] == '10') {
                    $OpenWork[1] = 'ตุลาคม';
                }
                if($OpenWork[1] == '11') {
                    $OpenWork[1] = 'พฤศจิกายน';
                }
                if($OpenWork[1] == '12') {
                    $OpenWork[1] = 'ธันวาคม';
                }
                $OpenWork = $OpenWork[0].'-'.$OpenWork[1].'-'.($OpenWork[2]+543);

				if($Status != 'W') {
					$OutWork = new datetime($row['OutWork']);
					$OutWork = $OutWork->format('d-m-Y');
					$OutWork = explode('-', $OutWork);
					if($OutWork[1] == '01') {
						$OutWork[1] = 'มกราคม';
					}
					if($OutWork[1] == '02') {
						$OutWork[1] = 'กุมภาพันธ์';
					}
					if($OutWork[1] == '03') {
						$OutWork[1] = 'มีนาคม';
					}
					if($OutWork[1] == '04') {
						$OutWork[1] = 'เมษายน';
					}
					if($OutWork[1] == '05') {
						$OutWork[1] = 'พฤษภาคม';
					}
					if($OutWork[1] == '06') {
						$OutWork[1] = 'มิถุนายน';
					}
					if($OutWork[1] == '07') {
						$OutWork[1] = 'กรกฏาคม';
					}
					if($OutWork[1] == '08') {
						$OutWork[1] = 'สิงหาคม';
					}
					if($OutWork[1] == '09') {
						$OutWork[1] = 'กันยายน';
					}
					if($OutWork[1] == '10') {
						$OutWork[1] = 'ตุลาคม';
					}
					if($OutWork[1] == '11') {
						$OutWork[1] = 'พฤศจิกายน';
					}
					if($OutWork[1] == '12') {
						$OutWork[1] = 'ธันวาคม';
					}
					$OutWork = $OutWork[0].'-'.$OutWork[1].'-'.($OutWork[2]+543);

					if($OutWork == '01-มกราคม-1900') {
						$OutWork = '';
					}
				}
            ?>
                <tr>
                    <td height="25" align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Card']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Em_ID']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $Titel; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Fullname']).' '.iconv('TIS-620','UTF-8', $row['Lastname']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Re_Name']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Moneies']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Pos_Name']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Group_Name']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Site_Name']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $BrithDay; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Blood']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620','UTF-8', $row['Address']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $row['Phone']; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $OpenWork; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $OutWork; ?></td>
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
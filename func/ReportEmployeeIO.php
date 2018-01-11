<?php
    @session_start();
    require("../inc/connect.php");

    $sql_site = "SELECT CAST(Site_Name as Text) as SiteName FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_GET['Site'] ."' ";
    $query_site = mssql_query($sql_site);
    $row_site = mssql_fetch_assoc($query_site);

    $strExcelFileName = iconv('TIS-620','UTF-8', '��ª��;�ѡ�ҹ').':'.iconv('TIS-620','UTF-8', $row_site['SiteName']).".xls";".xls";
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
                AND E.Bank_ID = Ba.Bank_ID ";
    if($_GET['Site'] != '1') {
        $sql .= "   AND E.Site_ID = '". $_GET['Site'] ."' ";
    }
    if($_GET['Position'] != '') {
        $sql .= "   AND E.Pos_ID = '". $_GET['Position'] ."' "; 
    }
    if($_GET['Group'] != '') {
        $sql .= "   AND E.Group_ID = '". $_GET['Group'] ."' "; 
    }
    if($_GET['Choise'] == '') {
        $sql .= "   AND E.Em_DateOpen between '". $_GET ['Start'] ."' and '". $_GET ['End'] ."' "; 
    }
    if($_GET['Choise'] == 'W') {
        $sql .= "   AND E.Em_Status = 'W'
                    AND E.Em_DateOpen between '". $_GET ['Start'] ."' and '". $_GET ['End'] ."' ";
    }
    if($_GET['Choise'] == '0') {
        $sql .= "   AND E.Em_Status = 'O'
                    AND E.Em_DateBlacklist between '". $_GET ['Start'] ."' and '". $_GET ['End'] ."' ";
    }
    if($_GET['Choise'] == 'B') {
        $sql .= "   AND E.Em_Status = 'B'
                    AND E.Em_DateBlacklist between '". $_GET ['Start'] ."' and '". $_GET ['End'] ."' ";
    }

    $query = mssql_query($sql);
    $num = mssql_num_rows($query);
    echo $sql;
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
                        <strong><?php echo iconv('TIS-620','UTF-8', '���ʺѵû�ЪҪ�'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '���ʾ�ѡ�ҹ'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '��'); ?></strong>
                    </td>
                    <td width="200" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '����-���ʡ��'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '����ç'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '���˹�'); ?></strong>
                    </td>
                    <td width="110" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '�ش'); ?></strong>
                    </td>
                    <td width="250" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '�ç���'); ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '�ѹ�Դ'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '�������ʹ'); ?></strong>
                    </td>
                    <td width="250" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '�������'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '������'); ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '������ӧҹ'); ?></strong>
                    </td>
                    <td width="160" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '�ѹ����͡�ҡ�ҹ'); ?></strong>
                    </td>
                    <td width="120" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '��������´'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '��Ҥ��'); ?></strong>
                    </td>
                    <td width="120" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '���͸�Ҥ��'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '�Ţ�ѭ��'); ?></strong>
                    </td>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;">
                        <strong><?php echo iconv('TIS-620','UTF-8', '��������§'); ?></strong>
                    </td>
                </tr>
            <?php
            if($num > 0){
            while($row = mssql_fetch_array($query)) {
                if($row['Sex'] == 'Mr') {
                    $Titel = '��� ';
                }
                if($row['Sex'] == 'Ms') {
                    $Titel = '�ҧ��� ';
                }
                if($row['Sex'] == 'Mrs') {
                    $Titel = '�ҧ ';
                }

                $BrithDay = new datetime($row['BrithDay']);
                $BrithDay = $BrithDay->format('d-m-Y');
                $BrithDay = explode('-', $BrithDay);
                if($BrithDay[1] == '01') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '���Ҥ�');
                }
                if($BrithDay[1] == '02') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '����Ҿѹ��');
                }
                if($BrithDay[1] == '03') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '�չҤ�');
                }
                if($BrithDay[1] == '04') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '����¹');
                }
                if($BrithDay[1] == '05') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '����Ҥ�');
                }
                if($BrithDay[1] == '06') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '�Զع�¹');
                }
                if($BrithDay[1] == '07') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '�á�Ҥ�');
                }
                if($BrithDay[1] == '08') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '�ԧ�Ҥ�');
                }
                if($BrithDay[1] == '09') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '�ѹ��¹');
                }
                if($BrithDay[1] == '10') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '���Ҥ�');
                }
                if($BrithDay[1] == '11') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '��Ȩԡ�¹');
                }
                if($BrithDay[1] == '12') {
                    $BrithDay[1] = iconv('TIS-620','UTF-8', '�ѹ�Ҥ�');
                }
                $BrithDay = $BrithDay[0].'-'.$BrithDay[1].'-'.($BrithDay[2]+543);

                $OpenWork = new datetime($row['OpenWork']);
                $OpenWork = $OpenWork->format('d-m-Y');
                $OpenWork = explode('-', $OpenWork);
                if($OpenWork[1] == '01') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '���Ҥ�');
                }
                if($OpenWork[1] == '02') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '����Ҿѹ��');
                }
                if($OpenWork[1] == '03') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '�չҤ�');
                }
                if($OpenWork[1] == '04') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '���Ҥ�');
                }
                if($OpenWork[1] == '05') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '����Ҥ�');
                }
                if($OpenWork[1] == '06') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '�Զع�¹');
                }
                if($OpenWork[1] == '07') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '�á�Ҥ�');
                }
                if($OpenWork[1] == '08') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '�ԧ�Ҥ�');
                }
                if($OpenWork[1] == '09') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '�ѹ��¹');
                }
                if($OpenWork[1] == '10') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '���Ҥ�');
                }
                if($OpenWork[1] == '11') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '��Ȩԡ�¹');
                }
                if($OpenWork[1] == '12') {
                    $OpenWork[1] = iconv('TIS-620','UTF-8', '�ѹ�Ҥ�');
                }
                $OpenWork = $OpenWork[0].'-'.$OpenWork[1].'-'.($OpenWork[2]+543);

                $OutWork = new datetime($row['OutWork']);
                $OutWork = $OutWork->format('d-m-Y');
                $OutWork = explode('-', $OutWork);
                if($OutWork[1] == '01') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '���Ҥ�');
                }
                if($OutWork[1] == '02') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '����Ҿѹ��');
                }
                if($OutWork[1] == '03') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '�չҤ�');
                }
                if($OutWork[1] == '04') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '���Ҥ�');
                }
                if($OutWork[1] == '05') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '����Ҥ�');
                }
                if($OutWork[1] == '06') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '�Զع�¹');
                }
                if($OutWork[1] == '07') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '�á�Ҥ�');
                }
                if($OutWork[1] == '08') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '�ԧ�Ҥ�');
                }
                if($OutWork[1] == '09') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '�ѹ��¹');
                }
                if($OutWork[1] == '10') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '���Ҥ�');
                }
                if($OutWork[1] == '11') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '��Ȩԡ�¹');
                }
                if($OutWork[1] == '12') {
                    $OutWork[1] = iconv('TIS-620','UTF-8', '�ѹ�Ҥ�');
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
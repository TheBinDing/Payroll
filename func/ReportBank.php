<?php
    @session_start();
    require("../inc/connect.php");

    $Group = $_GET['Group'];
    $Site = $_GET['Site'];
    $Position = $_GET['Position'];
    $Period = $_GET['Period'];

    $sql_site = "SELECT CAST(Site_Name as Text) as SiteName FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $Site ."' ";
    $query_site = mssql_query($sql_site);
    $row_site = mssql_fetch_assoc($query_site);

    $strExcelFileName = iconv('TIS-620', 'UTF-8', $row_site['SiteName']).".xls";
    header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
    header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
    header("Pragma:no-cache");

    $where .= !empty($Group)?  " AND (M.MT_GroupID = '". $Group ."') " : "";
    $where .= !empty($Position)?  " AND (M.MT_PositionID = '". $Position ."') " : "";

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
				m.MT_Titel as Titel,
                m.MT_CashCard as CashCard
            FROM
                [HRP].[dbo].[Time_Plan] t
                left join [HRP].[dbo].[MoneyTotal] m on t.Em_ID = m.Em_ID
                left join [HRP].[dbo].[Sites] s on m.Site_ID = s.Site_ID
            WHERE
                s.Site_ID = '". $Site ."'
                AND m.MT_Period = '". $Period ."'
                $where
            GROUP BY
                m.Em_ID, m.MT_Name, m.MT_GroupName, m.MT_PositionName, m.MT_AccountNumber, m.MT_Titel, m.MT_CashCard
            ORDER BY
                m.MT_GroupName ASC ";
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
                    <td colspan="7">
                        <div align="center" style="font-size: 20px;">โครงการ <?php echo iconv('TIS-620', 'UTF-8', $row_site['SiteName']); ?></div>
                        <div align="right" style="font-size: 15px;">งวดที่ <?php echo $Period_Week; ?> ประจำวันที่ <?php echo $Period_Start.' ถึง '.$Period_End; ?></div>
                        <br>
                    </td>
                </tr>
                <?php
                    $sql_socials = "SELECT
                                        SUM(MT_Totals) AS Totals,
                                        SUM(MT_TotalOT1) AS TotalOT1,
                                        SUM(MT_TotalOT15) AS TotalOT15,
                                        SUM(MT_TotalOT2) AS TotalOT2,
                                        SUM(MT_SumTotals) as mTotals ,
                                        SUM(MT_Socail) as Socials,
                                        SUM(MT_Mny_1) AS M1,
                                        SUM(MT_Mny_2) AS M2,
                                        SUM(MT_Mny_3) AS M3,
                                        SUM(MT_Mny_4) AS M4,
                                        SUM(MT_Mny_5) AS M5
                                    FROM
                                        [HRP].[dbo].[MoneyTotal]
                                    WHERE
                                        Site_ID = '".$Site."'
                                        AND MT_Period = '".$Period."' ";
                    $query_socials = mssql_query($sql_socials);
                    $row_socials = mssql_fetch_array($query_socials);

                    $TotalMs = $row_socials['M1'] + $row_socials['M2'] + $row_socials['M3'] + $row_socials['M4'] + $row_socials['M5'];

					$sql_Item = "SELECT
									CAST(L.List_Price as int) AS Price,
									m.Em_ID
								FROM
									[HRP].[dbo].[Item_List] L 
									left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
									left join [HRP].[dbo].[MoneyTotal] M on L.Em_ID = M.Em_ID
								WHERE
									L.List_Status = '1'
									AND I.Item_Status = '1'
									AND L.List_Period = '".$Period."'
									AND L.Site_ID = '". $Site ."'
									AND m.Em_ID != ''
								GROUP BY
									L.List_Price,m.Em_ID ";
					$q_Item = mssql_query($sql_Item);
					$n_Item = mssql_num_rows($q_Item);
					$Gl_1 = 0;$Gl_2 = 0;
					for($j=1;$j<=$n_Item;$j++) {
						$r = mssql_fetch_array($q_Item);
						$Gls_1 = $Gls_1 + $r['Price'];
					}

					$sql_ds = "SELECT
                            I.Item_Name AS IName,
                            /*L.List_Price AS Price,
							M.Em_ID*/
                            L.List_Price as Price
                        FROM
                            [HRP].[dbo].[Item_List] L left join
                            [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID left join
                            [HRP].[dbo].[MoneyTotal] M on L.Em_ID = M.Em_ID
                        WHERE
                            L.Site_ID = '". $Site ."'
                            AND L.Per_ID = '". $Period ."'
                            AND M.MT_Period = '". $Period ."'
                            AND L.List_Status = '1'
                            AND I.Item_Status = '0'
                        /*GROUP BY
                            I.Item_Name,
							L.List_Price,
							M.Em_ID*/ ";

					$query_ds = mssql_query($sql_ds);
					$num_ds = mssql_num_rows($query_ds);
					// echo $sql_ds.'<br>';
					$a = 0;$b = 0;$c = 0;$d = 0;

					for($is=1;$is<=$num_ds;$is++) {
						$row_ds = mssql_fetch_array($query_ds);
						$name = iconv('TIS-620', 'UTF-8', $row_ds['IName']);
						$name = iconv('UTF-8', 'TIS-620', $name);
						$price_ds = $row_ds['Price'];

						if($name == iconv('UTF-8', 'TIS-620', 'ค่าร้านค้า')) {
							$a = $a + $price_ds;
						}
						if($name == iconv('UTF-8', 'TIS-620', 'ค่าอุปกรณ์รวม')) {
							$b = $b + $price_ds;
						}
						if($name == iconv('UTF-8', 'TIS-620', 'ค่า Adv')) {
							$c = $c + $price_ds;
						}
						if($name == iconv('UTF-8', 'TIS-620', 'ค่าใช้จ่าย อื่นๆ')) {
							$d = $d + $price_ds;
						}
					}
					$sumPrice = $Gls_1;

					// echo $TotalMs.'-'.$sumPrice.'<br>';
					$sumMny = $TotalMs + $sumPrice;

                    /*$sql_ds = "SELECT
                                SUM(L.List_Price) as price
                            FROM
                                [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
                            WHERE
                                L.Site_ID = '".$Site."'
                                AND L.List_Period = '". $Period ."'
                                AND I.Item_Status = '0' ";

                    $query_ds = mssql_query($sql_ds);
                    $num_ds = mssql_num_rows($query_ds);
                    $row_ds = mssql_fetch_array($query_ds);

                    $price_ds = $row_ds['price'];
                    $price_ds = !empty($price_ds)?  " $price_ds " : "0";*/

                    $sql_items = "SELECT
                                    L.List_Num,
                                    L.List_Price as Price,
                                    I.Item_Name as Item_Name,
                                    I.Item_Status as Status,
                                    L.List_Status AS List_Status
                                FROM
                                    [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
                                WHERE
                                    L.Site_ID = '".$Site."'
                                    AND L.List_Status = '1'
                                    AND L.List_Period = '".$Period."' ";
                    $qs = mssql_query($sql_items);
                    $ns = mssql_num_rows($qs);
                    $Gl_s1 = 0;$Gl_s2 = 0;$Gl_s3 = 0;$Gl_s4 = 0;
                    for($js=1;$js<=$ns;$js++) {
                        $rs = mssql_fetch_array($qs);
                        if($rs['Item_Name'] == iconv('UTF-8', 'TIS-620', 'รายรับอื่นๆ')) {
                            $Gl_s1 = $rs['Price'];
                        }
                        if($rs['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าแรงตกงวดก่อน')) {
                            $Gl_s2 = $rs['Price'];
                        }
                        if($rs['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลาพิเศษ')) {
                            $Gl_s3 = $rs['Price'];
                        }
                        if($rs['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าครองชีพ')) {
                            $Gl_s4 = $rs['Price'];
                        }
                    }

                    $mTotalss = $row_socials['Totals'] + $row_socials['TotalOT15'] + $row_socials['TotalOT1'] + $row_socials['TotalOT2'];
                    $sumTotalGls = $TotalMs + $Gl_s1 + $Gl_s2 + $Gl_s3 + $Gl_s4;
                    echo $mTotalss.'-'.$sumMny.'-'.$row_socials['Socials'].'-'.$a.'-'.$b.'-'.$c.'-'.$d;
                    $IISJs = ((($mTotalss + $sumMny) - $row_socials['Socials']) - $a - $b - $c - $d);
                ?>
                <tr>
                    <td colspan="7">
                        <div align="right" style="font-size: 15px;"><?php echo 'ยอดเงินทั้งหมด '.$IISJs.' บาท'; ?></div>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="100" height="30" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ชื่อ-สกุล</strong></td>
                    <td width="60" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ชุด</strong></td>
                    <td width="69" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ตำแหน่ง</strong></td>
                    <td width="160" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>หมายเลขบัญชีธนาคาร</strong></td>
                    <td width="180" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>หมายเลขบัญชีบัตรเงินสด</strong></td>
                    <td width="80" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>ค่าแรงสุทธิ</strong></td>
                    <td width="130" align="center" valign="middle" style="font-size: 15px;background: #CCFFFF;"><strong>เซ็นต์ยืนยันรับเงิน</strong></td>
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
            ?>
                <tr>
                    <td height="25" align="center" valign="middle" style="font-size: 15px;"><?php echo $Titel.iconv('TIS-620', 'UTF-8', $row['Fullname']).' '.iconv('TIS-620', 'UTF-8', $row['Lastname']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620', 'UTF-8', $row['GroupName']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo iconv('TIS-620', 'UTF-8', $row['Position']); ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php if($row['Account'] != '') { echo $row['Account']; } else { echo '-'; } ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php if($row['CashCard'] != '') { echo $row['CashCard']; } else { echo '-'; } ?></td>
                    <?php
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
                                        [HRP].[dbo].[Item_List] L
										left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
                                    WHERE
                                        L.Em_ID = '".$row['id']."'
										AND L.List_Status = '1'
										AND L.List_Period = '".$Period."' ";
                        $q = mssql_query($sql_item);
                        $n = mssql_num_rows($q);
                        $Gl_1 = 0;$Gl_2 = 0;$Gl_3 = 0;$Gl_4 = 0;
                        for($j=1;$j<=$n;$j++) {
                            $r = mssql_fetch_array($q);
							if($r['Item_Name'] == iconv('UTF-8', 'TIS-620', 'รายรับอื่นๆ')) {
								$Gl_1 = $Gl_1 + $r['Price'];
							}
							if($r['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าแรงตกงวดก่อน')) {
								$Gl_2 = $Gl_2 + $r['Price'];
							}
							if($r['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลาพิเศษ')) {
								$Gl_3 = $Gl_3 + $r['Price'];
							}
							if($r['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าครองชีพ')) {
								$Gl_4 = $Gl_4 + $r['Price'];
							}
                        }

                        $TotalM = $row_social['M1'] + $row_social['M2'] + $row_social['M3'] + $row_social['M4'] + $row_social['M5'];
                        $mTotals = $row_social['Totals'] + $row_social['TotalOT15'] + $row_social['TotalOT1'] + $row_social['TotalOT2'];
						// echo $TotalM.'-'.$Gl_1.'-'.$Gl_2.'-'.$Gl_3.'-'.$Gl_4.'<br>';
                        $sumTotalGl = $TotalM + $Gl_1 + $Gl_2 + $Gl_3 + $Gl_4;
                        // echo $mTotals.'-'.$sumTotalGl.'-'.$row_social['Socials'].'-'.$price_d.'<br>';
                        $IISJ = ((($mTotals + $sumTotalGl) - $row_social['Socials']) - $price_d);
                    ?>
                    <td align="center" valign="middle" style="font-size: 15px;"><?php echo $IISJ; ?></td>
                    <td align="center" valign="middle" style="font-size: 15px;"></td>
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
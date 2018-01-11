<?php
require('../inc/connect.php');
require('../fpdf.php');
require('../func/PDF01Search.php');

class PDF extends FPDF
{
    function Group($name) {
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->SetXY(10,34);

        foreach ($name AS $key => $value) {
            $this->Cell(10,5,$key+1,1,0,'C');
            $this->Cell(40,5,$value,1,1);
        }
        $this->SetFont('Tahoma','B', 11);
        $this->Cell(50,5, iconv('UTF-8', 'TIS-620', 'รวม'),1,1,'R');
    }

    function NumP($site, $name, $start, $end, $period)
    {
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $n = 34;

        foreach ($name as $va) {
            $this->SetXY(60,$n);

            $sql = "SELECT
                        E.Em_ID
                    FROM
                        [HRP].[dbo].[Time_Plan] TP
                        left join [HRP].[dbo].[Employees] E on TP.Em_ID = E.Em_ID
                        left join [HRP].[dbo].[Sites] S on E.Site_ID = S.Site_ID
                        left join [HRP].[dbo].[Group] G on E.Group_ID = G.Group_ID
                        left join [HRP].[dbo].[Position] P on E.Pos_ID = P.Pos_ID
                    WHERE
                        G.Group_ID = '". $va ."'
                        AND S.Site_ID = '". $site ."' 
                        AND TP.LogTime BETWEEN CONVERT(DATETIME, '". $start ."', 102) AND CONVERT(DATETIME, '". $end ."', 102)
                    GROUP BY
                        E.Em_ID";

            $sql = "SELECT
                        m.Em_ID
                    FROM
                        [HRP].[dbo].[MoneyTotal] m left join
                        [HRP].[dbo].[Sites] S on m.Site_ID = S.Site_ID
                    WHERE
                        m.MT_GroupID = '". $va ."'
                        AND S.Site_ID = '". $site ."' 
                        AND m.MT_Period = '". $period ."' 
                    GROUP BY
                        m.Em_ID ";

            $query = mssql_query($sql);
            $num = mssql_num_rows($query);

            $this->Cell(12,5,$num,1,1,'C');

            $n = $n + 5;
            $ss = $ss + $num;
        }
        $this->SetXY(60,$n);
        $this->Cell(12,5,$ss,1,1,'C');
    }

    function Hour($site, $name, $start, $end, $social, $per, $GroupID)
    {
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $n = 34;

        foreach ($name as $va) {
            $this->SetXY(72,$n);

            $sql = "SELECT
                        SUM(CAST(TP.Total as float)) as Total,
                        SUM(CAST(TP.OTN as float)) as OTN,
                        SUM(CAST(TP.OTE as float)) as OTE,
                        SUM(CAST(TP.TotalOT15 as float)) as total15,
                        SUM(CAST(TP.TotalOT2 as float)) as total2
                    FROM
                        [HRP].[dbo].[Time_Plan] TP left join
                        [HRP].[dbo].[MoneyTotal] m on TP.Em_ID = m.Em_ID left join
                        [HRP].[dbo].[Sites] S on m.Site_ID = s.Site_ID
                    WHERE
                        m.MT_GroupID = '". $va ."'
                        AND S.Site_ID = '". $site ."'
                        AND TP.LogTime BETWEEN CONVERT(DATETIME, '". $start ."', 102) AND CONVERT(DATETIME, '". $end ."', 102) 
                        AND MT_Period = '".$per."' ";

            $query = mssql_query($sql);
            // echo $sql.'<br><br>';
            $num = mssql_num_rows($query);
            $Total = '0';$totalOT = '0';$totalwork = '0';$wokr_p = '0';
            for($ss=1;$ss<=$num;$ss++) {
                $row = mssql_fetch_array($query);

                $Total = $Total + number_format($row['Total'], 2, '.', '');
                $totalOT = $totalOT + number_format(($row['OTN'] + $row['OTE'] + $row['total15'] + $row['total2']), 2, '.', '');
            }
            $totalwork = $Total + $totalOT;
            $wokr_p = ($totalOT / $Total) * 100;

            $sql_m = "SELECT
                        SUM(CAST(MT.MT_Totals AS int)) AS Totals,
                        SUM(CAST(MT.MT_TotalOT1 AS int)) AS TotalOT1,
                        SUM(CAST(MT.MT_TotalOT15 AS int)) AS TotalOT15,
                        SUM(CAST(MT.MT_TotalOT2 AS int)) AS TotalOT2,
                        SUM(CAST(MT.MT_Mny_1 AS int)) AS Mny,
                        SUM(CAST(MT.MT_Mny_2 AS int)) AS Mny2,
                        SUM(CAST(MT.MT_Mny_3 AS int)) AS Mny3,
                        SUM(CAST(MT.MT_Mny_4 AS int)) AS Mny4,
                        SUM(CAST(MT.MT_Mny_5 AS int)) AS Mny5,
                        SUM(CAST(MT_Socail as int)) AS Socail
                    FROM
                        [HRP].[dbo].[MoneyTotal] MT
                        left join [HRP].[dbo].[Sites] S on MT.Site_ID = S.Site_ID
                    where
                        MT.MT_GroupID = '". $va ."'
                        AND S.Site_ID = '". $site ."' 
                        AND MT_Period = '".$per."' ";

            $query_m = mssql_query($sql_m);
            $row_m = mssql_fetch_array($query_m);
            $total = $row_m['Totals'];
            if($total == 0) {
                $total = 1;
            }
            $totalOT1 = $row_m['TotalOT15'] + $row_m['TotalOT1'] + $row_m['TotalOT2'];
            $totals = $total + $totalOT1;
            // $socials = $totals * $social;
            $wokr_o = ($totalOT1 / $total) * 100;

            $sql_o = "SELECT
                    L.List_Price AS Price
                FROM
                    [HRP].[dbo].[Time_Plan] TP
                    left join [HRP].[dbo].[MoneyTotal] m on TP.Em_ID = m.Em_ID
                    left join [HRP].[dbo].[Sites] S on m.Site_ID = S.Site_ID
                    left join [HRP].[dbo].[Item_List] L on m.Em_ID = L.Em_ID
                    left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
                WHERE
                    m.MT_GroupID = '". $va ."'
                    AND S.Site_ID = '". $site ."' 
                    AND L.Per_ID = '". $per ."'
                    AND I.Item_Status = '1'
                    AND L.List_Status = '1'
                GROUP BY
                    L.List_Price,L.Item_ID ";

            $query_o = mssql_query($sql_o);
            $num_o = mssql_num_rows($query_o);
            $price = 0;

            for($i=1;$i<=$num_o;$i++) {
                $row_o = mssql_fetch_array($query_o);
                $price = $price + $row_o['Price'];
            }

            $sql_Item = "SELECT
                            m.Em_ID,
                            L.List_Price as Price
                        FROM
                            [HRP].[dbo].[Item_List] L 
                            left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
                            left join [HRP].[dbo].[MoneyTotal] M on L.Em_ID = M.Em_ID
                            left join [HRP].[dbo].[Sites] S on M.Site_ID = S.Site_ID
                        WHERE
                            L.Site_ID = '". $site ."' 
                            AND L.Per_ID = '". $per ."'
                            AND M.MT_Period = '". $per ."'
                            AND I.Item_Status = '1'
                            AND L.List_Status = '1'
                            AND M.MT_GroupID = '". $va ."'
                        GROUP BY
                            m.Em_ID,
                            L.List_Price,
                            L.List_Date ";

            // echo $sql_Item.'<br>';
            $q_Item = mssql_query($sql_Item);
            $n_Item = mssql_num_rows($q_Item);
            $Gl_1 = 0;$Gl_2 = 0;
            for($j=1;$j<=$n_Item;$j++) {
                $r = mssql_fetch_array($q_Item);
                $Gl_1 = $Gl_1 + $r['Price'];
            }
            $sumPrice = $Gl_1;

            // echo $row_m['Mny'].'-'.$sumPrice.'<br>';
            $sumMny = ($row_m['Mny'] + $row_m['Mny2'] + $row_m['Mny3'] + $row_m['Mny4'] + $row_m['Mny5']) + $sumPrice;

            $sql_d = "SELECT
                        I.Item_Name AS IName,
                        L.List_Price AS Price,
                        e.Em_ID,
                        L.List_Create
                    FROM
                        [HRP].[dbo].[Item_List] L left join
                        [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID left join
                        [HRP].[dbo].[Employees] E on L.Em_ID = e.Em_ID inner join
                        [HRP].[dbo].[Group] g on e.Group_ID = g.Group_ID
                    WHERE
                        g.Group_ID = '". $va ."'
                        AND L.Site_ID = '". $site ."' 
                        AND L.Per_ID = '". $per ."'
                        AND L.List_Status = '1'
                        AND I.Item_Status = '0'
                    GROUP BY
                        I.Item_Name,
                        L.List_Price,
                        e.Em_ID,
                        L.List_Create ";

            $query_d = mssql_query($sql_d);
            $num_d = mssql_num_rows($query_d);
            // echo $sql_d.'<br>';
            $a = 0;$b = 0;$c = 0;$d = 0;

            for($i=1;$i<=$num_d;$i++) {
                $row_d = mssql_fetch_array($query_d);
                $name = iconv('TIS-620', 'UTF-8', $row_d['IName']);
                $name = iconv('UTF-8', 'TIS-620', $name);
                $price_d = $row_d['Price'];

                if($name == iconv('UTF-8', 'TIS-620', 'ค่าร้านค้า')) {
                    $a = $a + $price_d;
                }
                if($name == iconv('UTF-8', 'TIS-620', 'ค่าอุปกรณ์รวม')) {
                    $b = $b + $price_d;
                }
                if($name == iconv('UTF-8', 'TIS-620', 'ค่า Adv')) {
                    $c = $c + $price_d;
                }
                if($name == iconv('UTF-8', 'TIS-620', 'ค่าใช้จ่าย อื่นๆ')) {
                    $d = $d + $price_d;
                }
            }

            $this->Cell(14,5,$Total,1,0,'C');
            $this->Cell(12,5,$totalOT,1,0,'C');
            $this->Cell(12,5,$totalwork,1,0,'C');
            $this->Cell(12,5,number_format($wokr_p, 2, '.', ''),1,0,'C');
            $this->Cell(14,5,number_format($total),1,0,'C');
            $this->Cell(12,5,number_format($totalOT1),1,0,'C');
            $this->Cell(12,5,number_format($totals),1,0,'C');
            $this->Cell(12,5,number_format($wokr_o, 2, '.', ''),1,0,'C');

            $this->SetXY(172,$n);
            $this->Cell(15,5, number_format($sumMny),1,0,'C');

            $this->SetXY(187,$n);
            $this->Cell(17,5, number_format($row_m['Socail']),1,0,'C');

            $this->SetXY(204,$n);
            $this->Cell(17,5,number_format($a),1,0,'C');
            $this->Cell(17,5,number_format($b),1,0,'C');
            $this->Cell(17,5,number_format($c),1,0,'C');
            $this->Cell(17,5,number_format($d),1,0,'C');

            $this->SetXY(272,$n);
            // echo $totals.'-'.$sumMny.'-'.$row_m['Socail'].'-'.$a.'-'.$b.'-'.$c.'-'.$d.'<br>';
            $TotalSum = (((((($totals + $sumMny) - $row_m['Socail']) - $a) - $b) - $c) - $d);
            $this->Cell(20,5,number_format($TotalSum),1,0,'C');

            $n = $n + 5;
            $aa = $aa + $Total;
            $bb = $bb + $totalOT;
            $cc = $cc + $totalwork;
            $ee = $ee + $total;
            $ff = $ff + $totalOT1;
            $gg = $gg + $totals;
            $hh = '';
            // echo $row_m['Mny'].'-'.$sumPrice.'='.$sumMny.'<br>';

            $pp = $pp + $sumMny;

            $sss = $sss + $row_m['Socail'];

            $jj = $jj + $a;
            $kk = $kk + $b;
            $ii = $ii + $c;
            $ww = $ww + $d;

            $ts = $ts + ($TotalSum + $pp - $sss - $ww);

            $G1 = ($bb / $aa) * 100;
            $G2 = ($ff / $ee) * 100;
        }
        $SumAllTotals = $gg + $pp - $sss - $jj - $kk - $ii - $ww;
        $this->SetXY(72,$n);
        $this->Cell(14,5,number_format($aa),1,0,'C');
        $this->Cell(12,5,number_format($bb),1,0,'C');
        $this->Cell(12,5,number_format($cc),1,0,'C');
        $this->Cell(12,5,number_format($G1, 2, '.', ''),1,0,'C');
        $this->Cell(14,5,number_format($ee),1,0,'C');
        $this->Cell(12,5,number_format($ff),1,0,'C');
        $this->Cell(12,5,number_format($gg),1,0,'C');
        $this->Cell(12,5,number_format($G2, 2, '.', ''),1,0,'C');

        $this->SetXY(172,$n);
        $this->Cell(15,5,number_format($pp),1,0,'C');

        $this->SetXY(187,$n);
        $this->Cell(17,5,number_format($sss),1,0,'C');

        $this->SetXY(204,$n);
        $this->Cell(17,5,number_format($jj),1,0,'C');
        $this->Cell(17,5,number_format($kk),1,0,'C');
        $this->Cell(17,5,number_format($ii),1,0,'C');
        $this->Cell(17,5,number_format($ww),1,0,'C');

        $this->SetXY(272,$n);
        $this->Cell(20,5,number_format($SumAllTotals),1,0,'C');

        $this->Ln(10);
        $this->SetFont('Tahoma','B',12);
        $this->Cell(80,6,iconv('UTF-8', 'TIS-620', 'สรุปค่าใช้จ่าย'),0,1);
        $this->SetFont('Tahoma','B',9);
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', '     ค่าแรง'),0,0);
        $this->Cell(40,6,'     '.number_format($ee),0,1,'R');
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', '     ค่าล่วงเวลา'),0,0);
        $this->Cell(40,6,'     '.number_format($ff),0,1,'R');
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', '     รายได้อื่นๆ'),'B',0);
        $this->Cell(40,6,'     '.number_format($pp),'B',1,'R');
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', '     หัก ป.ก.ส.'),0,0);
        $this->Cell(40,6,'     '.number_format($sss),0,1,'R');
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', '     หักค่าร้านค้า'),0,0);
        $this->Cell(40,6,'     '.number_format($jj),0,1,'R');
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', '     หักค่าอุปกรณ์'),0,0);
        $this->Cell(40,6,'     '.number_format($kk),0,1,'R');
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', '     หัก Avd'),0,0);
        $this->Cell(40,6,'     '.number_format($ii),0,1,'R');
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', '     หักอื่นๆ'),'B',0);
        $this->Cell(40,6,'     '.number_format($ww),'B',0,'R');
        $this->SetFont('Tahoma','B',12);
        $this->Cell(80,6,'(...................................)',0,0,'R');
        $this->Cell(50,6,'(...................................)',0,0,'C');
        $this->Cell(50,6,'(...................................)',0,1,'L');
        $this->Cell(40,6,iconv('UTF-8', 'TIS-620', 'ค่าใช้จ่ายสุทธิ'),0,0);
        $this->Cell(40,6,number_format($SumAllTotals),0,0,'R');
        $this->Cell(80,6, iconv('UTF-8', 'TIS-620', 'ผู้จัดทำ            '),0,0,'R');
        $this->Cell(50,6, iconv('UTF-8', 'TIS-620', 'ผู้ตรวจ'),0,0,'C');
        $this->Cell(50,6, iconv('UTF-8', 'TIS-620', '             ผู้อนุมัติ'),0,1,'L');
    }
}

$pdf = new PDF( 'L' , 'mm' , 'A4');

$NameG = array();
$NameID = array();
$EM = array();
for($i=1;$i<=$num_e;$i++){
    $row_e = mssql_fetch_array($query_e);
    $GroupID = $row_e['GroupID'];
    $GroupName = iconv('TIS-620', 'UTF-8', $row_e['GroupName']);
    $GroupName = iconv('UTF-8', 'TIS-620', $GroupName);
    $SiteName = iconv('TIS-620', 'UTF-8', $row_e['Site_Name']);
    $SiteName = iconv('UTF-8', 'TIS-620', $SiteName);
    array_push($NameID,$GroupID);
    array_push($NameG,$GroupName);
    array_push($EM,$row_e['Em_ID']);
}

$pdf->AddPage();
$title = 'Cover Page';
$pdf->SetTitle($title);
$pdf->AddFont('Tahoma','B','Tahoma.php');
$pdf->SetFont('Tahoma','B', 15);

$pdf->Cell(282,7,iconv('UTF-8', 'TIS-620', 'บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)'),'LTR',1,'C');

$pdf->AddFont('Tahoma','','Tahoma.php');
$pdf->SetFont('Tahoma','B', 11);
$pdf->Cell(140,7,iconv('UTF-8', 'TIS-620', 'โครงการ : ').$SiteName,'L',0,'C');
$pdf->Cell(42,7,iconv('UTF-8', 'TIS-620', 'งวดที่ : ').$Period_Week,0,0,'C');
$pdf->Cell(100,7,iconv('UTF-8', 'TIS-620', 'วันที่ : ').$Period_Start.iconv('UTF-8', 'TIS-620', ' ถึง ').$Period_End,'R',1,'C');
$pdf->Cell(10,10,iconv('UTF-8', 'TIS-620', 'ลำดับ'),1,0,'C');
$pdf->Cell(40,5,iconv('UTF-8', 'TIS-620', 'ชุด'),'LTR',0,'C');
$pdf->Cell(12,5,iconv('UTF-8', 'TIS-620', 'จำนวน'),'LTR',0,'C');
$pdf->Cell(50,5,iconv('UTF-8', 'TIS-620', 'ชั่วโมงทำงาน'),1,0,'C');
$pdf->Cell(50,5,iconv('UTF-8', 'TIS-620', 'คำนวณเป็นเงิน'),1,0,'C');
$pdf->Cell(15,5,iconv('UTF-8', 'TIS-620', 'รายได้'),'LTR',0,'C');
$pdf->Cell(105,5,iconv('UTF-8', 'TIS-620', 'รายจ่าย'),1,1,'C');

$pdf->Cell(50,5,iconv('UTF-8', 'TIS-620', ''),'LBR',0);
$pdf->Cell(12,5,iconv('UTF-8', 'TIS-620', '(คน)'),'LBR',0,'C');
$pdf->Cell(14,5,iconv('UTF-8', 'TIS-620', 'ปกติ'),'LBR',0,'C');
$pdf->Cell(12,5,iconv('UTF-8', 'TIS-620', 'OT'),'LBR',0,'C');
$pdf->Cell(12,5,iconv('UTF-8', 'TIS-620', 'รวม'),'LBR',0,'C');
$pdf->Cell(12,5,iconv('UTF-8', 'TIS-620', '%'),'LBR',0,'C');
$pdf->Cell(14,5,iconv('UTF-8', 'TIS-620', 'ปกติ'),'LBR',0,'C');
$pdf->Cell(12,5,iconv('UTF-8', 'TIS-620', 'OT'),'LBR',0,'C');
$pdf->Cell(12,5,iconv('UTF-8', 'TIS-620', 'รวม'),'LBR',0,'C');
$pdf->Cell(12,5,iconv('UTF-8', 'TIS-620', '%'),'LBR',0,'C');
$pdf->Cell(15,5,iconv('UTF-8', 'TIS-620', 'อื่นๆ'),'LBR',0,'C');
$pdf->Cell(17,5,iconv('UTF-8', 'TIS-620', 'ป.ก.ส.'),'LBR',0,'C');
$pdf->Cell(17,5,iconv('UTF-8', 'TIS-620', 'ร้านค้า'),'LBR',0,'C');
$pdf->Cell(17,5,iconv('UTF-8', 'TIS-620', 'อุปกรณ์'),'LBR',0,'C');
$pdf->Cell(17,5,iconv('UTF-8', 'TIS-620', 'Avd.'),'LBR',0,'C');
$pdf->Cell(17,5,iconv('UTF-8', 'TIS-620', 'อื่นๆ'),'LBR',0,'C');
$pdf->Cell(20,5,iconv('UTF-8', 'TIS-620', 'รวม'),'LBR',1,'C');
$pdf->Group($NameG);
$pdf->NumP($Site, $NameID, $Period_Start, $Period_End, $Period);
$pdf->Hour($Site, $NameID, $Period_Start, $Period_End, $PS_Social, $Period, $GroupID);
$pdf->Output();
?>

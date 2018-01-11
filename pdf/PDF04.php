<?php
require('../inc/connect.php');
require('../fpdf.php');
require('../func/PDF04Search.php');

class PDF extends FPDF
{
    function BasicTable($data1, $data2, $data3, $data4, $data5, $y, $m, $g, $s, $p, $social, $na, $ps, $id, $site)
    {
        $sql_social = "SELECT
							MT_Totals AS Totals,
							MT_TotalOT1 AS TotalOT1,
							MT_TotalOT15 AS TotalOT15,
							MT_TotalOT2 AS TotalOT2,
							MT_SumTotals as mTotals ,
							MT_Socail as Socials,
							MT_Mny_1 AS M1,
							MT_Mny_2 AS M2,
							MT_Mny_3 AS M3,
							MT_Mny_4 AS M4,
							MT_Mny_5 AS M5
						FROM
							[HRP].[dbo].[MoneyTotal]
						where
							Em_ID = '".$id."'
							and MT_Period = '".$p."' ";
        $query_social = mssql_query($sql_social);
        $row_social = mssql_fetch_array($query_social);

        $TotalM = $row_social['M1'] + $row_social['M2'] + $row_social['M3'] + $row_social['M4'] + $row_social['M5'];

        // $sql_o = "SELECT
        //             SUM(L.List_Price) as price
        //         FROM
        //             [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
        //         WHERE
        //             L.Em_ID = '". $id ."'
        //             AND L.List_Period = '". $p ."'
        //             AND I.Item_Status = '1' ";

        // $query_o = mssql_query($sql_o);
        // $num_o = mssql_num_rows($query_o);
        // $row_o = mssql_fetch_assoc($query_o);

        // if($row_o['price'] == '') {
        //     $row_o['price'] = 0;
        // }

        $sql_d = "SELECT
                    SUM(L.List_Price) as price
                FROM
                    [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
                WHERE
                    L.Em_ID = '". $id ."'
                    AND L.List_Period = '". $p ."'
                    AND I.Item_Status = '0'
                    AND List_Status = '1'
                GROUP BY
                    L.List_Price,L.Item_ID ";

        $query_d = mssql_query($sql_d);
        $num_d = mssql_num_rows($query_d);

		for($psp=1;$psp<=$num_d;$psp++) {
			$row_d = mssql_fetch_array($query_d);
			$price_d = $price_d + $row_d['price'];
		}

        if(count($data1) < 16) {
            $run = 16;
        } else {
            $run = count($data1);
        }

        $a = $m / 9;$b = $m / 8;

        for($n=0;$n<$run;$n++){
            $sum = $sum + $data2[$n];
            $sam = $sam + $data3[$n];
            $sun = $sun + $data4[$n];
            $sums = $sums + $data5[$n];
        }

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
						L.Em_ID = '".$id."'
						AND L.List_Status = '1'
						AND L.List_Period = '".$p."' ";
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

        $mTotals = $row_social['Totals'] + $row_social['TotalOT15'] + $row_social['TotalOT1'] + $row_social['TotalOT2'];
        $sumTotalGl = $TotalM + $Gl_1 + $Gl_2 + $Gl_3 + $Gl_4;
		// echo $TotalM.'-'.$Gl_1.'-'.$Gl_2.'-'.$Gl_3.'-'.$Gl_4.'<br>';
        // echo $row_social['mTotals'].'+'.$sumTotalGl.'-'.$row_social['Socials'].'-'.$price_d.'<br>';
        // echo $sql_social.'<br>';
		//echo $mTotals.'-'.$sumTotalGl.'-'.$row_social['Socials'].'-'.$price_d.'<br>';
        $IISJ = ((($mTotals + $sumTotalGl) - $row_social['Socials']) - $price_d);
        $other = $Gl_1 + $Gl_2 + $Gl_3 + $Gl_4;

        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 9);
        // $this->SetXY(40,$y);
        $this->Cell(59,3.9,$na,'LTR',0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(12,3.9, iconv('UTF-8', 'TIS-620', 'วันที่'),1,0,'C');
        for($i=0;$i<$run;$i++) {
            $this->AddFont('angsa','','angsa.php');
            $this->SetFont('angsa','', 12);
            $this->Cell(7,3.9,$data1[$i],1,0,'C');
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 9);
        $this->Cell(8,3.9, iconv('UTF-8', 'TIS-620', 'ชม.'),1,0,'C');
        $this->Cell(13,3.9,iconv('UTF-8', 'TIS-620', 'ค่าแรง'),'TR',0,'C');
        $this->Cell(30,3.9,iconv('UTF-8', 'TIS-620', 'รายได้อื่นๆ'),'TR',0,'C');
        $this->Cell(30,3.9,iconv('UTF-8', 'TIS-620', 'รายการหักค่าใช้จ่าย'),'TR',0,'C');
        $this->Cell(30,3.9,iconv('UTF-8', 'TIS-620', 'ยอดคงเหลือ'),'TR',1,'C');

        $this->AddFont('AngsanaNew','','angsa.php');
        $this->SetFont('AngsanaNew','', 12);
        // $this->SetXY(40,$y+5);
        $this->Cell(13,3.9,iconv('UTF-8', 'TIS-620', 'ค่าแรง'),'L',0);
        $this->Cell(46,3.9,$m,'R',0);
        $this->Cell(12,3.9, iconv('UTF-8', 'TIS-620', 'เวลาปกติ'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(7,3.9,$data2[$i],1,0,'C');
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 9);
        $this->Cell(8,3.9, $sum,1,0,'C');
        $this->AddFont('AngsanaNew','','angsa.php');
        $this->SetFont('AngsanaNew','', 12);
        $this->Cell(13,3.9, number_format($row_social['Totals']),'TR',0,'C');
        $this->Cell(15,3.9,iconv('UTF-8', 'TIS-620', 'เบี้ยเลี้ยง'),'TR',0,'C');
        $this->Cell(15,3.9,number_format($TotalM),'TR',0,'C');
        $this->Cell(20,3.9,iconv('UTF-8', 'TIS-620', 'ค่าประกันสังคม'),'TR',0,'C');
        $this->Cell(10,3.9, number_format($row_social['Socials']),'TR',0,'C');
        $this->Cell(20,3.9,iconv('UTF-8', 'TIS-620', 'ค่าแรงรวม'),'TR',0,'C');
        $this->Cell(10,3.9, number_format($mTotals),'TR',1,'C');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        // $this->SetXY(40,$y+10);
        $this->Cell(13,3.9,iconv('UTF-8', 'TIS-620', 'ชุด'),'L',0);
        $this->Cell(46,3.9,$g,'R',0);
        $this->Cell(12,3.9, iconv('UTF-8', 'TIS-620', 'OT 1'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(7,3.9,$data3[$i],1,0,'C');
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 9);
        $this->Cell(8,3.9, $sam,1,0,'C');
        $this->AddFont('AngsanaNew','','angsa.php');
        $this->SetFont('AngsanaNew','', 12);
        $this->Cell(13,3.9, number_format($row_social['TotalOT1']),'TR',0,'C');
        $this->Cell(15,3.9,iconv('UTF-8', 'TIS-620', 'ค่าแรงตก'),'TR',0,'C');
        $this->Cell(15,3.9, number_format($Gl_2),'TR',0,'C');
        $this->Cell(20,3.9,iconv('UTF-8', 'TIS-620', 'ค่าภาษี'),'TR',0);
        $this->Cell(10,3.9,iconv('UTF-8', 'TIS-620', '0'),'TR',0,'C');
        $this->Cell(20,3.9,iconv('UTF-8', 'TIS-620', 'รายได้อื่นๆรวม'),'TR',0,'C');
        $this->Cell(10,3.9, number_format($sumTotalGl),'TR',1,'C');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        // $this->SetXY(40,$y+15);
        $this->Cell(13,3.9,iconv('UTF-8', 'TIS-620', 'ตำแหน่ง'),'L',0);
        $this->Cell(46,3.9,$ps,'R',0);
        $this->Cell(12,3.9, iconv('UTF-8', 'TIS-620', 'OT 1.5'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(7,3.9,$data4[$i],1,0,'C');
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 9);
        $this->Cell(8,3.9, $sun,1,0,'C');
        $this->AddFont('AngsanaNew','','angsa.php');
        $this->SetFont('AngsanaNew','', 12);
        $this->Cell(13,3.9, number_format($row_social['TotalOT15']),'TR',0,'C');
        $this->Cell(15,3.9,iconv('UTF-8', 'TIS-620', 'OT พิเศษ'),'TR',0,'C');
        $this->Cell(15,3.9, number_format($Gl_3),'TR',0,'C');
        $this->Cell(20,3.9,iconv('UTF-8', 'TIS-620', 'ค่าร้านค้า+'),'TR',0);
        $this->Cell(10,8, number_format($price_d),'TR',0,'C');
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 24);
        $this->Cell(30,3.9, number_format($IISJ),'TR',1,'C');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        // $this->SetXY(40,$y+20);
        $this->Cell(13,3.9,iconv('UTF-8', 'TIS-620', 'โครงการ'),'LB',0);
        // $this->Cell(20,5,'  '.$site,'BR',0);
        $this->Cell(46,3.9,$site,'BR',0);
        $this->Cell(12,3.9, iconv('UTF-8', 'TIS-620', 'OT 2'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(7,3.9,$data5[$i],1,0,'C');
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 9);
        $this->Cell(8,3.9, $sums,1,0,'C');
        $this->AddFont('AngsanaNew','','angsa.php');
        $this->SetFont('AngsanaNew','', 12);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(13,3.9, number_format($row_social['TotalOT2']),'TBR',0,'C');
        $this->Cell(15,3.9,iconv('UTF-8', 'TIS-620', 'ค่าอื่นๆ'),'TBR',0,'C');
        $this->Cell(15,3.9, number_format($Gl_1 + $Gl_4),'TBR',0,'C');
        $this->Cell(20,3.9,iconv('UTF-8', 'TIS-620', 'อุป+Avn'),'BR',0);
        $this->Cell(10,3.9,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(30,3.9,iconv('UTF-8', 'TIS-620', ''),'BR',1,'C');
        $this->Cell(294,0.5,iconv('UTF-8', 'TIS-620', ''),'B',1,'C');
    }
}

$pdf=new PDF( 'L' , 'mm' , array( 305,236 ) );
$pdf->AddPage();
$title = 'Cover More';
$pdf->SetTitle($title);
$pdf->AddFont('Tahoma','','Tahoma.php');
$pdf->SetFont('Tahoma','', 16);

$pdf->Cell(0,5,iconv('UTF-8', 'TIS-620', 'สรุปค่าแรงวันที่  ').$Period_Start.iconv('UTF-8', 'TIS-620', ' ถึง ').$Period_End,0,1,'C');

$pdf->AddFont('angsa','','angsa.php');
$pdf->SetFont('angsa','', 12);
for($s=1;$s<=$num_e;$s++) {
    $row_e = mssql_fetch_array($query_e);
    $Eid = $row_e['ID'];
    if($row_e['Titel'] == 'Mr') {
        $Titel = 'นาย ';
    }
    if($row_e['Titel'] == 'Ms') {
        $Titel = 'นางสาว ';
    }
    if($row_e['Titel'] == 'Mrs') {
        $Titel = 'นาง ';
    }

    $sql = "SELECT
        TB1.Date_ AS LogTime,
        TB2_1.Total AS Total,
        TB2_1.OTN AS OTN,
        TB2_1.OTE AS OTE,
        TB2_1.TotalOT15 AS OT15,
        TB2_1.TotalOT2 AS OT2
    FROM
        (SELECT
                dbo.Time_Plan.CK_in,
                dbo.Time_Plan.Ck_Out1,
                dbo.Time_Plan.CK_in2,
                dbo.Time_Plan.Ck_Out2,
                dbo.Time_Plan.CKOT_in1,
                dbo.Time_Plan.CKOT_Out1,
                dbo.Time_Plan.CKOT_in2,
                dbo.Time_Plan.CKOT_Out2,
                dbo.Time_Plan.Total,
                dbo.Time_Plan.OTN,
                dbo.Time_Plan.OTE,
                dbo.Time_Plan.TotalOT15,
                dbo.Time_Plan.TotalOT2,
                dbo.Time_Plan.FingerID,
                dbo.Time_Plan.LogTime,
                dbo.Time_Plan.Em_ID,
                dbo.Time_Plan.TimePlan_ID
        FROM
                dbo.PlanTime CROSS JOIN dbo.Time_Plan
        GROUP BY
                dbo.Time_Plan.CK_in,
                dbo.Time_Plan.Ck_Out1,
                dbo.Time_Plan.CK_in2,
                dbo.Time_Plan.Ck_Out2,
                dbo.Time_Plan.CKOT_in1,
                dbo.Time_Plan.CKOT_Out1,
                dbo.Time_Plan.CKOT_in2,
                dbo.Time_Plan.CKOT_Out2,
                dbo.Time_Plan.Total,
                dbo.Time_Plan.OTN,
                dbo.Time_Plan.OTE,
                dbo.Time_Plan.TotalOT15,
                dbo.Time_Plan.TotalOT2,
                dbo.Time_Plan.FingerID,
                dbo.Time_Plan.LogTime,
                dbo.Time_Plan.Em_ID,
                dbo.Time_Plan.TimePlan_ID) AS TB2_1
    RIGHT OUTER JOIN
        (SELECT
                E.Em_ID,
                E.Em_Fullname,
                D.Date_
        FROM
                dbo.Datetable AS D CROSS JOIN dbo.Employees AS E
        WHERE
                (D.Date_ BETWEEN CONVERT(DATETIME, '".$Period_Start."', 102) AND CONVERT(DATETIME, '".$Period_End."', 102))
        GROUP BY
                E.Em_ID,
                E.Em_Fullname,
                D.Date_) AS TB1 ON TB2_1.Em_ID = TB1.Em_ID AND TB2_1.LogTime = TB1.Date_
    WHERE (TB1.Em_ID = '". $Eid ."')
    GROUP BY
        TB1.Date_,
        TB1.Em_ID,
        TB1.Em_Fullname,
        TB2_1.LogTime,
        TB2_1.Total,
        TB2_1.OTN,
        TB2_1.OTE,
        TB2_1.TotalOT15,
        TB2_1.TotalOT2 ";

    $query = mssql_query($sql);
    $num = mssql_num_rows($query);
    $data1 = array();
    $data2 = array();
    $data3 = array();
    $data4 = array();
    $data5 = array();

    for($i=1;$i<=$num;$i++) {
        $row = mssql_fetch_array($query);
        $dataTime = new datetime($row['LogTime']);
        $dataTime = $dataTime->format('d');
        if($row['Total'] == 0) {
            $Total = '';
        } else {
            $Total = $row['Total'];
        }
        if($row['OTN'] == 0) {
            $OT1 = '';
        } else {
            $OT1 = $row['OTN'];
        }
        $OT15 = $row['OT15'] + $row['OTE'];
        if($OT15 == 0) {
            $OT15 = '';
        } else {
            $OT15 = $OT15;
        }
        if($row['OT2'] == 0) {
            $OT12 = '';
        } else {
            $OT12 = $row['OT2'];
        }
        array_push($data1,$dataTime);
        array_push($data2,$Total);
        array_push($data3,$OT1);
        array_push($data4,$OT15);
        array_push($data5,$OT12);
    }

    $name = $Titel.iconv('TIS-620', 'UTF-8', $row_e['Fullname']).' '.iconv('TIS-620', 'UTF-8', $row_e['Lastname']);
    $name = iconv('UTF-8', 'TIS-620', $name);

    /* $name_len = strlen($name);
    if($name_len > '17' && $name_len < '20') {
        $name = substr($name, 0, -3);
        $name = $name.' ...';
    }
    elseif($name_len > '19') {
        $name = substr($name, 0, -8);
        $name = $name.' ...';
    } */

    $group = iconv('TIS-620', 'UTF-8', $row_e['GroupName']);
    $group = iconv('UTF-8', 'TIS-620', $group);
    $position = iconv('TIS-620', 'UTF-8', $row_e['Position']);
    $position = iconv('UTF-8', 'TIS-620', $position);
    $site = iconv('TIS-620', 'UTF-8', $row_e['Site']);
    $site = iconv('UTF-8', 'TIS-620', $site);
	$nn = iconv('UTF-8', 'TIS-620', 'อาคารโรงพยาบาล');
	$n1 = iconv('UTF-8', 'TIS-620', 'อาคารโรงพยาบาลปศุสัตว์ มอ.หาดใหญ่ (คนต่างด้าว)');
    $n2 = iconv('UTF-8', 'TIS-620', 'อาคารโรงพยาบาลปศุสัตว์ มอ.หาดใหญ่ (คนไทย)');
	if($site == $n1) {
		$name_site = explode($nn , $site);
		$site = $name_site[1];
	}
	if($site == $n2) {
		$name_site = explode($nn , $site);
		$site = $name_site[1];
	}
    $money = $row_e['Money'];
    
    $pdf->BasicTable($data1, $data2, $data3, $data4, $data5, $nn, $money, $group, $Sites, $Period, $PS_Social, $name, $position, $Eid, $site);    
    if($s % 10 == 0) {
        $pdf->Ln(10);
    }
}
$pdf->Output();
?>

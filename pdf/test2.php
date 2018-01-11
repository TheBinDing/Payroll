<?php
require('../inc/connect.php');
require('../fpdf.php');
require('../func/PDF02Search.php');

class PDF extends FPDF
{
    function BasicTable($data1)
    {
        if(count($data1) < 16) {
            $run = 16;
        } else {
            $run = count($data1);
        }
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->SetXY(10,45);
        $this->Cell(15,7, iconv('UTF-8', 'TIS-620', 'วันที่'),1,0,'C');
        for($i=0;$i<$run;$i++)
            $this->Cell(15,7,$data1[$i],1,0,'C');
        $this->Cell(15,7, iconv('UTF-8', 'TIS-620', 'รวม'),1,0,'C');
        $this->Ln();
    }

    function BasicTable2($data2)
    {
        if(count($data2) < 16) {
            $run = 16;
        } else {
            $run = count($data2);
        }
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->SetXY(10,52);
        $this->Cell(15,7, iconv('UTF-8', 'TIS-620', 'เวลาปกติ'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(15,7,$data2[$i],1,0,'C');
            $sum = $sum + $data2[$i];
        }
        $this->Cell(15,7, $sum,1,0,'C');
        $this->Ln();
    }

    function BasicTable3($data)
    {
        if(count($data3) < 16) {
            $run = 16;
        } else {
            $run = count($data3);
        }
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->SetXY(10,59);
        $this->Cell(15,7, iconv('UTF-8', 'TIS-620', 'OT 1'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(15,7,$data3[$i],1,0,'C');
            $sam = $sam + $data3[$i];
        }
        $this->Cell(15,7, $sam,1,0,'C');
        $this->Ln();
    }

    function BasicTable4($data4)
    {
        if(count($data4) < 16) {
            $run = 16;
        } else {
            $run = count($data4);
        }
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->SetXY(10,66);
        $this->Cell(15,7, iconv('UTF-8', 'TIS-620', 'OT 1.5'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(15,7,$data4[$i],1,0,'C');
            $sun = $sun + $data4[$i];
        }
        $this->Cell(15,7, $sun,1,0,'C');
        $this->Ln();
    }

    function BasicTable5($data5)
    {
        if(count($data5) < 16) {
            $run = 16;
        } else {
            $run = count($data5);
        }
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->SetXY(10,73);
        $this->Cell(15,7, iconv('UTF-8', 'TIS-620', 'OT 2'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(15,7,$data5[$i],1,0,'C');
            $sums = $sums + $data5[$i];
        }
        $this->Cell(15,7, $sums,1,0,'C');
        $this->Ln();
    }

    function Testsss()
    {
        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetFont('angsa', '', 14);

        $this->SetXY(10,87);
        $this->Cell(90,7,iconv('UTF-8', 'TIS-620', 'ค่าแรง'),'LBR',0,'R');

        $this->SetXY(10,94);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'รายได้ปกติ'),'LBR',0);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'TTTT'),'LBR',0,'R');

        $this->SetXY(10,101);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลา 1'),'LBR',0);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'TTTT'),'LBR',0,'R');

        $this->SetXY(10,108);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลา 1.5'),'LBR',0);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'TTTT'),'LBR',0,'R');

        $this->SetXY(10,115);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลา 2'),'LBR',0);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'TTTT'),'LBR',0,'R');

        $this->SetXY(10,122);
        $this->Cell(90,7,iconv('UTF-8', 'TIS-620', 'รายได้อื่นๆ'),'LBR',0,'R');

        $this->SetXY(10,129);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าเบี้ยเลี้ยง'),'LBR',0);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'TTTT'),'LBR',0,'R');

        $this->SetXY(10,136);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าแรงตกงวดก่อน'),'LBR',0);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'TTTT'),'LBR',0,'R');

        $this->SetXY(10,143);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลาพิเศษ'),'LBR',0);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'TTTT'),'LBR',0,'R');

        $this->SetXY(10,150);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าอื่นๆ'),'LBR',0);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'TTTT'),'LBR',0,'R');

        $this->SetXY(100,87);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'รายการ'),'LBR',0,'C');
        $this->Cell(12,7,iconv('UTF-8', 'TIS-620', 'QTY'),'BR',0,'C');
        $this->Cell(12,7,iconv('UTF-8', 'TIS-620', 'ราคา'),'BR',0,'C');
        $this->Cell(12,7,iconv('UTF-8', 'TIS-620', 'งวดที่'),'BR',0,'C');
        $this->Cell(12,7,iconv('UTF-8', 'TIS-620', 'งวดละ'),'BR',0,'C');
        $this->Cell(12,7,iconv('UTF-8', 'TIS-620', 'คงเหลือ'),'BR',0,'C');
        $this->Ln();

        for($z=1;$z<=9;$z++) {
            if($z == 1) {
                $this->SetXY(100,94);
            } elseif ($z == 2) {
                $this->SetXY(100,101);
            } elseif ($z == 3) {
                $this->SetXY(100,108);
            } elseif ($z == 4) {
                $this->SetXY(100,115);
            } elseif ($z == 5) {
                $this->SetXY(100,122);
            } elseif ($z == 6) {
                $this->SetXY(100,129);
            } elseif ($z == 7) {
                $this->SetXY(100,136);
            } elseif ($z == 8) {
                $this->SetXY(100,143);
            } elseif ($z == 9) {
                $this->SetXY(100,150);
            }
            $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'ค่า Adv.'),'LBR',0,'C');
            $this->Cell(12,7,iconv('UTF-8', 'TIS-620', '1'),'BR',0,'C');
            $this->Cell(12,7,iconv('UTF-8', 'TIS-620', '1000'),'BR',0,'C');
            $this->Cell(12,7,iconv('UTF-8', 'TIS-620', '170'),'BR',0,'C');
            $this->Cell(12,7,iconv('UTF-8', 'TIS-620', '1000'),'BR',0,'C');
            $this->Cell(12,7,iconv('UTF-8', 'TIS-620', '0'),'BR',0,'C');
        }

        $this->SetXY(220,87);
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'รายได้'),'BR',0,'R');

        $this->SetXY(220,94);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าแรง'),'LBR',0,'R');
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', '0'),'LBR',0,'R');

        $this->SetXY(220,101);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าประกันสังคม'),'LBR',0,'R');
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', '0'),'LBR',0,'R');

        $this->SetXY(220,108);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'ค่าภาษี'),'LBR',0,'R');
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', '0'),'LBR',0,'R');

        $this->SetXY(220,115);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'รายได้อื่นๆ'),'LBR',0,'R');
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', '0'),'LBR',0,'R');

        $this->SetXY(220,122);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', 'รายจ่าย'),'LBR',0,'R');
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', '0'),'LBR',0,'R'); /**/

        $this->SetXY(220,129);
        $this->Cell(30,14,iconv('UTF-8', 'TIS-620', 'ยอดคงเหลือ'),'L',0,'R');
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', ''),'R',0,'R');

        $this->SetXY(220,136);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', ''),'LB',0);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', ''),'BR',0,'R');

        $this->SetXY(220,143);
        $this->Cell(30,14,iconv('UTF-8', 'TIS-620', '0'),'L',0,'R');
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', ''),'R',0,'R');

        $this->SetXY(220,150);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', ''),'LB',0);
        $this->Cell(30,7,iconv('UTF-8', 'TIS-620', ''),'BR',0,'R');

        $this->SetXY(10,157);
        $this->Cell(210,7,iconv('UTF-8', 'TIS-620', 'ยอดสะสม'),'LBR',0,'R');
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', ''),'R',1,'R');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 15);
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', 'รายได้'),'LBR',0,'C');
        $this->Cell(27,7,iconv('UTF-8', 'TIS-620', 'ค่าประกันสังคม'),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', 'ภาษี'),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', 'ขาดงาน'),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', 'ลากิจ'),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', 'ลาป่วย'),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', 'ลาอื่นๆ'),'BR',0,'C');
        $this->Cell(27,7,iconv('UTF-8', 'TIS-620', 'รายได้อื่นๆรวม'),'BR',0,'C');
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', '..........................................................'),'R',1,'C');

        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', '6,652'),'LBR',0,'C');
        $this->Cell(27,7,iconv('UTF-8', 'TIS-620', '0'),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(26,7,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(27,7,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(60,7,iconv('UTF-8', 'TIS-620', 'ผู้ตรวจสอบ'),'BR',1,'C');
    }
}

$pdf = new PDF( 'L' , 'mm' , 'A4' );
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->SetFont('angsa', '', 14);
for($s=1;$s<=$num_e;$s++) {
    $row_e = mssql_fetch_array($query_e);
    $name = iconv('TIS-620', 'UTF-8', $row_e['FristName']).' '.iconv('TIS-620', 'UTF-8', $row_e['LastName']);
    $name = iconv('UTF-8', 'TIS-620', $name);
    $group = iconv('TIS-620', 'UTF-8', $row_e['GroupName']);
    $group = iconv('UTF-8', 'TIS-620', $group);
    $position = iconv('TIS-620', 'UTF-8', $row_e['Position']);
    $position = iconv('UTF-8', 'TIS-620', $position);
    $site = iconv('TIS-620', 'UTF-8', $row_e['Site']);
    $site = iconv('UTF-8', 'TIS-620', $site);
    $Eid = $row_e['ID'];

    $sql = "SELECT
        TB1.Date_ AS LogTime,
        TB2_1.Total AS Total,
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
                E.Em_FristName,
                E.Em_LastName,
                D.Date_
        FROM
                dbo.Datetable AS D CROSS JOIN dbo.Employee AS E
        WHERE
                (D.Date_ BETWEEN CONVERT(DATETIME, '2016-05-16', 102) AND CONVERT(DATETIME, '2016-05-31', 102))
        GROUP BY
                E.Em_ID,
                E.Em_FristName,
                E.Em_LastName,
                D.Date_) AS TB1 ON TB2_1.Em_ID = TB1.Em_ID AND TB2_1.LogTime = TB1.Date_
    WHERE (TB1.Em_ID = '". $Eid ."')
    GROUP BY
        TB1.Date_,
        TB1.Em_ID,
        TB1.Em_FristName,
        TB1.Em_LastName,
        TB2_1.LogTime,
        TB2_1.Total,
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
        $dataTime = $dataTime->format('Y-m-d');
        $Total = $row['Total'];
        $OT1 = array('','','','','','','','','','','','','','','','');
        $OT15 = $row['OT15'];
        $OT12 = $row['OT2'];
        array_push($data1,$dataTime);
        array_push($data2,$Total);
        array_push($data3,$OT1);
        array_push($data4,$OT15);
        array_push($data5,$OT12);
    }
    $pdf->AddPage();
    /*Header*/
    $pdf->Image('../img/Thaipolycons.jpg',15,10,30);
    $pdf->Cell(270,10,iconv( 'UTF-8','TIS-620','บริษัท ไทยโพลิคอนส์ จำกัด (มหาชน)'),'LTR',1,'C');
    $pdf->Cell(90,6,iconv('UTF-8', 'TIS-620', 'คุณ : ').$name,'L',0,'R');
    $pdf->Cell(90,6,iconv( 'UTF-8','TIS-620','รหัส : ').$Eid,0,0,'C');
    $pdf->Cell(90,6,iconv( 'UTF-8','TIS-620','รหัสบัตรประจำตัวประชาชน: ').$row_e['ID_TH'],'R',1,'C');
    $pdf->Cell(90,6,iconv( 'UTF-8','TIS-620','ประจำไซต์งาน : ').$group,'L',0,'R');
    $pdf->Cell(90,6,iconv('UTF-8', 'TIS-620', 'ตำแหน่ง : ').$position,0,0,'C');
    $pdf->Cell(90,6,iconv('UTF-8', 'TIS-620', 'ชุด : ').$site,'R',1,'C');
    $pdf->Cell(90,6,iconv( 'UTF-8','TIS-620','ค่าแรง : 305.00'),'L',0,'R');
    $pdf->Cell(90,6,iconv( 'UTF-8','TIS-620','งวดที่ : 22'),0,0,'C');
    $pdf->Cell(90,6,iconv( 'UTF-8','TIS-620','วันที่: 2015-11-16 ถึง 2015-11-30'),'R',1,'C');

    $pdf->Cell(270,7,iconv('UTF-8', 'TIS-620', 'เวลาทำงาน'),'LTR',1,'R');
    $pdf->BasicTable($data1);
    $pdf->BasicTable2($data2);
    $pdf->BasicTable3($data3);
    $pdf->BasicTable4($data4);
    $pdf->BasicTable5($data5);
    $pdf->Cell(270,7,iconv('UTF-8', 'TIS-620', 'ยอดรายได้ และ การหักค่าใช้จ่าย'),'LBR',1,'R');
    $pdf->Testsss();
}
$pdf->Output();
?>

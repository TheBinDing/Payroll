<?php
require('../inc/connect.php');
require('../fpdf.php');
require('../func/PDF03Search.php');

class PDF extends FPDF{
    protected $col = 0; // Current column
    protected $y0;      // Ordinate of column start

    function SetCol($col)
    {
        // Set position at a given column
        $this->col = $col;
        $x = 10+$col*95;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak()
    {
        // Method accepting or not automatic page break
        if($this->col<2)
        {
            // Go to next column
            $this->SetCol($this->col+1);
            // Set ordinate to top
            $this->SetY(10);
            // Keep on page
            return false;
        }
        else
        {
            // Go back to first column
            $this->SetCol(0);
            // Page break
            return true;
        }
    }

    function BasicTable($header,$data,$num)
    {
        //Header
        $w=array(18,18,18,18,18);
        //Header
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C');
        $this->Ln();
        //Data
        foreach ($data as $eachResult)
        {
            $Time = new datetime($eachResult["LogTime"]);
            $Time = $Time->format('d-m-Y');

            $this->Cell(18,4,$Time,'LTR',0,'C');
            $this->Cell(18,4,$eachResult["CK_in"],1,0,'C');
            $this->Cell(18,4,$eachResult["CK_in2"],1,0,'C');
            $this->Cell(18,4,$eachResult["CKOT_in1"],1,0,'C');
            $this->Cell(18,4,$eachResult["CKOT_in2"],1,1,'C');
            $this->Cell(18,4,'','LBR',0,'C');
            $this->Cell(18,4,$eachResult["Ck_Out1"],1,0,'C');
            $this->Cell(18,4,$eachResult["Ck_Out2"],1,0,'C');
            $this->Cell(18,4,$eachResult["CKOT_Out1"],1,0,'C');
            $this->Cell(18,4,$eachResult["CKOT_Out2"],1,0,'C');
            $this->Ln();
        }
        for($z=1;$z<=$num;$z++) {
            $this->Cell(18,4, '','LTR',0,'C');
            $this->Cell(18,4, '',1,0,'C');
            $this->Cell(18,4, '',1,0,'C');
            $this->Cell(18,4, '',1,0,'C');
            $this->Cell(18,4, '',1,1,'C');
            $this->Cell(18,4, '','LBR',0,'C');
            $this->Cell(18,4, '',1,0,'C');
            $this->Cell(18,4, '',1,0,'C');
            $this->Cell(18,4, '',1,0,'C');
            $this->Cell(18,4, '',1,0,'C');
            $this->Ln();
        }
    }
}

$pdf=new PDF( 'L' , 'mm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->SetFont('angsa','', 14);
$pdf->AddPage();
$title = 'Check the accuracy';
$pdf->SetTitle($title);
$header = array(iconv('UTF-8', 'TIS-620', 'วันที่'),iconv('UTF-8', 'TIS-620', 'เช้า'),iconv('UTF-8', 'TIS-620', 'บ่าย'),'OT','OT2');

for($s=1;$s<=$num_e;$s++) {
    $row_e = mssql_fetch_array($query_e);
	if($row_e['Titel'] == 'Mr') {
		$Titel = 'นาย ';
	}
	if($row_e['Titel'] == 'Ms') {
		$Titel = 'นางสาว ';
	}
	if($row_e['Titel'] == 'Mrs') {
		$Titel = 'นาง ';
	}
    $name = $Titel.' '.iconv('TIS-620', 'UTF-8', $row_e['Fullname']).' '.iconv('TIS-620', 'UTF-8', $row_e['Lastname']);
    $name = iconv('UTF-8', 'TIS-620', $name);
    $group = iconv('TIS-620', 'UTF-8', $row_e['GroupName']);
    $group = iconv('UTF-8', 'TIS-620', $group);
    $position = iconv('TIS-620', 'UTF-8', $row_e['Position']);
    $position = iconv('UTF-8', 'TIS-620', $position);
    $site = iconv('TIS-620', 'UTF-8', $row_e['Site']);
    $site = iconv('UTF-8', 'TIS-620', $site);
    $id = $row_e['ID'];

    $sql = "SELECT
            TB1.Date_ AS LogTime,
            TB2_1.CK_in AS CK_in,
            TB2_1.Ck_Out1 AS Ck_Out1,
            TB2_1.CK_in2 AS CK_in2,
            TB2_1.Ck_Out2 AS Ck_Out2,
            TB2_1.CKOT_in1 AS CKOT_in1,
            TB2_1.CKOT_Out1 AS CKOT_Out1,
            TB2_1.CKOT_in2 AS CKOT_in2,
            TB2_1.CKOT_Out2 AS CKOT_Out2
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
                    (D.Date_ BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102))
            GROUP BY
                    E.Em_ID,
                    E.Em_Fullname,
                    D.Date_) AS TB1 ON TB2_1.Em_ID = TB1.Em_ID AND TB2_1.LogTime = TB1.Date_
        WHERE (TB1.Em_ID = '". $id ."')
        GROUP BY
            TB1.Date_,
            TB1.Em_ID,
            TB1.Em_Fullname,
            TB2_1.LogTime,
            TB2_1.CK_in,
            TB2_1.Ck_Out1,
            TB2_1.CK_in2,
            TB2_1.Ck_Out2,
            TB2_1.CKOT_in1,
            TB2_1.CKOT_Out1,
            TB2_1.CKOT_in2,
            TB2_1.CKOT_Out2 ";
    $query = mssql_query($sql);
    $num = mssql_num_rows($query);
    $resultData = array();
    $CheckNum = explode('-', $Period_End);

    if($CheckNum[1] == 2) {
        if($CheckNum[2] == 28) {
            $nums = 3;
        }
        if($CheckNum[2] == 29) {
            $nums = 2;
        }
    }
    for($i=1;$i<=$num;$i++){
        $row = mssql_fetch_array($query);
        array_push($resultData,$row);
    }
    $group = str_replace(iconv('UTF-8', 'TIS-620', 'ชุด'), '', $group);

    $pdf->Cell(60,5, iconv('UTF-8', 'TIS-620', 'คุณ : ').$name,'LT',0);
    $pdf->Cell(30,5, $row_e['ID_TH'],'TR',1);

    $pdf->Cell(90,5, iconv('UTF-8', 'TIS-620', 'โครงการ : ').$site,'LR',1);

    $pdf->Cell(60,5, iconv('UTF-8', 'TIS-620', 'ตำแหน่ง : ').$position,'L',0);
    $pdf->Cell(30,5, iconv('UTF-8', 'TIS-620', 'รหัส : ').$id,'R',1);

    $pdf->Cell(90,5, iconv('UTF-8', 'TIS-620', 'ชุด : ').$group,'LR',1);

    $pdf->Cell(60,5, iconv('UTF-8', 'TIS-620', 'วันที่ : ').$Periods['StartDate'].' - '.$Periods['EndDate'],'L',0);
    $pdf->Cell(30,5, iconv('UTF-8', 'TIS-620', 'เลขที่เอกสาร..............'),'R',1);

    $pdf->BasicTable($header,$resultData,$nums);

    $pdf->MultiCell(90,5, iconv('UTF-8', 'TIS-620', 'ตรวจสอบแล้วถูกต้อง'),'LR','C');
    $pdf->MultiCell(90,5, '','LR','C');

    $pdf->MultiCell(90,5, iconv('UTF-8', 'TIS-620', '......................................................................................'),'LRB','C');
    // $pdf->SetCol(0);
    $pdf->Ln(20);
}
$pdf->Output();
?>

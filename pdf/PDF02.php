<?php
require('../inc/connect.php');
require('../fpdf.php');
require('../func/PDF02Search.php');
// ini_set('max_execution_time', 90);

class PDF extends FPDF
{
    function CountTotal($id, $period)
    {
        $sql_item = "SELECT List_Price as Price, I.Item_Status AS Status ";
        $sql_item .= " FROM [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID ";
        $sql_item .= " WHERE L.Em_ID = '".$id."' AND L.Per_ID = '".$period."' ";

        $q = mssql_query($sql_item);
        $n = mssql_num_rows($q);
        $P0 = 0;$P1 = 0;

        for($w=1;$w<=$n;$w++) {
            $r = mssql_fetch_array($q);

            if($r['Status'] == 1) {
                $Price1 = $r['Price'];
                $P1 = $P1 + $Price1;
            }
            elseif($r['Status'] == 0) {
                $Price0 = $r['Price'];
                $P0 = $P0 + $Price0;
            }
        }
        $a = array($P1,$P0);
        return $a;
    }

    function BasicTable($data1, $data2, $data3, $data4, $data5, $id, $period, $money, $name, $group, $position, $site, $code, $Period_Start, $Period_End, $s, $Periods)
    {
        $sql_social = "SELECT MT_Totals AS Totals, MT_TotalOT1 AS TotalOT1, MT_TotalOT15 AS TotalOT15, MT_TotalOT2 AS TotalOT2, MT_SumTotals as mTotals , MT_Socail as Socials, MT_Mny_1 AS M1, MT_Mny_2 AS M2, MT_Mny_3 AS M3, MT_Mny_4 AS M4, MT_Mny_5 AS M5 FROM [HRP].[dbo].[MoneyTotal] where Em_ID = '".$id."' and MT_Period = '".$period."' ";
        $query_social = mssql_query($sql_social);
        $row_social = mssql_fetch_array($query_social);

        $TotalM = $row_social['M1'] + $row_social['M2'] + $row_social['M3'] + $row_social['M4'] + $row_social['M5'];

        $PriceUD = $this->CountTotal($id,$period);
        if(count($data1) < 16) {
            $run = 16;
        } else {
            $run = count($data1);
        }

        $sql_o = "SELECT
                    SUM(L.List_Price) as price
                FROM
                    [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
                WHERE
                    L.Em_ID = '". $id ."'
                    AND L.List_Period = '". $period ."'
                    AND I.Item_Status = '1' ";

        $query_o = mssql_query($sql_o);
        $num_o = mssql_num_rows($query_o);
        $row_o = mssql_fetch_assoc($query_o);

        if($row_o['price'] == '') {
            $row_o['price'] = 0;
        }

        $sql_item2 = "SELECT L.List_Num AS Qty, L.List_Num, L.List_Price as Price, I.Item_Name as Item_Name, I.Item_Status as Status ";
        $sql_item2 .= " FROM [HRP].[dbo].[Item_List] L left join [HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID ";
        $sql_item2 .= " WHERE L.Em_ID = '".$id."' AND L.List_Period = '".$period."' AND I.Item_Status = '0' ";

        $q_item2 = mssql_query($sql_item2);
        $n_item2 = mssql_num_rows($q_item2);

        $resultData1 = array();
        $resultData2 = array();
        $resultData3 = array();
        $resultData4 = array();
        $resultData5 = array();
        $resultData6 = array();
        for($x=1;$x<=8;$x++) {
            $r_item2 = mssql_fetch_array($q_item2);
            $Item_Name = iconv('TIS-620', 'UTF-8', $r_item2['Item_Name']);
            $Item_Names = iconv('UTF-8', 'TIS-620', $Item_Name);

            if($Item_Name != '') {
                $Item_Names = $Item_Names;
                $QTY = $r_item2['Qty'];
                $Prices = $r_item2['Price'];
                $p = $period;
                $re = 0;
                $rs = 0;
            } else {
                $Item_Names = '';
                $QTY = '';
                $Prices = '';
                $p = '';
                $re = '';
                $rs = '';
            }

            $P0 = $P0 + $Prices;

            array_push($resultData1,$Item_Names);
            array_push($resultData2,$QTY);
            array_push($resultData3,$Prices);
            array_push($resultData4,$p);
            array_push($resultData5,$re);
            array_push($resultData6,$rs);
        }

        $P1 = $ap + $bp + $cp + $dp;

        $sql_item_up = "SELECT
						L.List_Num,
						L.List_Price as Price,
						I.Item_Name as Item_Name,
						I.Item_Status as Status,
						L.List_Status AS List_Status
                    FROM
						[HRP].[dbo].[Item_List] L left join
						[HRP].[dbo].[Items] I on L.Item_ID = I.Item_ID
                    WHERE
						L.Em_ID = '".$id."'
						AND L.List_Status = '1'
						AND L.List_Period = '".$period."' ";
        $q_item_up = mssql_query($sql_item_up);
        $n_item_up = mssql_num_rows($q_item_up);
        $Gl_1 = 0;$Gl_2 = 0;$Gl_3 = 0;$Gl_4 = 0;
        for($j=1;$j<=$n_item_up;$j++) {
            $r_item_up = mssql_fetch_array($q_item_up);
            if($r_item_up['Item_Name'] == iconv('UTF-8', 'TIS-620', 'รายรับอื่นๆ')) {
                $Gl_1 = $Gl_1 + $r_item_up['Price'];
            }
            if($r_item_up['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าแรงตกงวดก่อน')) {
                $Gl_2 = $Gl_2 + $r_item_up['Price'];
            }
            if($r_item_up['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลาพิเศษ')) {
                $Gl_3 = $Gl_3 + $r_item_up['Price'];
            }
            if($r_item_up['Item_Name'] == iconv('UTF-8', 'TIS-620', 'ค่าครองชีพ')) {
                $Gl_4 = $Gl_4 + $r_item_up['Price'];
            }
        }

        $mTotals = $row_social['Totals'] + $row_social['TotalOT15'] + $row_social['TotalOT1'] + $row_social['TotalOT2'];
        $sumTotalGl = $TotalM + $Gl_1 + $Gl_2 + $Gl_3 + $Gl_4;
        $sumTotals = $mTotals + $sumTotalGl - $row_social['Socials'] - $P0;
		$other = $Gl_1 + $Gl_2 + $Gl_3 + $Gl_4;

        $image1 = '../img/Thaipolycons.jpg';


        // $this->Cell( 25, 20, $this->Image($image1, $this->GetX(), $this->GetY(), 25), 'LT', 0, 'C' );

        if($s % 2 == 0) {
            $this->Cell( 25, 20, $this->Image($image1, 13, 148, 20), 'LT', 0, 'C' );
        } else {
            $this->Cell( 25, 20, $this->Image($image1, 13, 13, 20), 'LT', 0, 'C' );
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 17);
        $this->Cell( 25, 20, $this->Image($image1, 13, 13, 20), 'T', 0, 'C' );
        $this->Cell(140,10,iconv( 'UTF-8','TIS-620','บริษัท ไทยโพลิคอนส์ จำกัด (มหาชน)'),'TR',1,'C');
        $this->Cell(30,5, '','L',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(19,5,iconv('UTF-8', 'TIS-620', 'คุณ : '),0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->Cell(47,5,$name,0,0,'L');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(15,5,iconv( 'UTF-8','TIS-620','รหัส : '),0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->Cell(21,5,$id,0,0);
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(16,5,iconv( 'UTF-8','TIS-620','รหัสบัตร : '),0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->Cell(42,5,$code,'R',1);

        $this->Cell(30,5, '','L',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(19,5,iconv( 'UTF-8','TIS-620','ไซต์งาน : '),0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->Cell(47,5,$site,0,0);
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(15,5,iconv('UTF-8', 'TIS-620', 'ตำแหน่ง : '),0,0);
        $this->Cell(21,5,$position,0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(16,5,iconv('UTF-8', 'TIS-620', 'ชุด : '),0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->Cell(42,5,$group,'R',1);

        $this->Cell(30,5, '','L',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(19,5,iconv( 'UTF-8','TIS-620','ค่าแรง : '),0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->Cell(47,5,$money,0,0);
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(15,5,iconv( 'UTF-8','TIS-620','งวดที่ : '),0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->Cell(21,5,$Periods,0,0);
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(16,5,iconv( 'UTF-8','TIS-620','วันที่: '),0,0);
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 16);
        $this->Cell(42,5,$Period_Start.iconv('UTF-8', 'TIS-620', ' ถึง ').$Period_End,'R',1);

        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(190,5,iconv('UTF-8', 'TIS-620', 'เวลาทำงาน'),'LTR',1,'R');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(15,5, iconv('UTF-8', 'TIS-620', 'วันที่'),1,0,'C');
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 8);
        for($i=0;$i<$run;$i++)
            $this->Cell(10,5,$data1[$i],1,0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(15,5, iconv('UTF-8', 'TIS-620', 'รวม'),1,1,'C');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(15,5, iconv('UTF-8', 'TIS-620', 'เวลาปกติ'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(10,5,$data2[$i],1,0,'C');
            $sum = $sum + $data2[$i];
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(15,5, $sum,1,1,'C');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(15,5, iconv('UTF-8', 'TIS-620', 'OT 1'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(10,5,$data3[$i],1,0,'C');
            $sam = $sam + $data3[$i];
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(15,5, $sam,1,1,'C');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(15,5, iconv('UTF-8', 'TIS-620', 'OT 1.5'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(10,5,$data4[$i],1,0,'C');
            $sun = $sun + $data4[$i];
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(15,5, $sun,1,1,'C');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(15,5, iconv('UTF-8', 'TIS-620', 'OT 2'),1,0,'C');
        for($i=0;$i<$run;$i++){
            $this->Cell(10,5,$data5[$i],1,0,'C');
            $sums = $sums + $data5[$i];
        }
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(15,5, $sums,1,1,'C');
        $this->Cell(190,5,iconv('UTF-8', 'TIS-620', 'ยอดรายได้ และ การหักค่าใช้จ่าย'),'LBR',1,'R');

        $this->Cell(65,5,iconv('UTF-8', 'TIS-620', 'ค่าแรง'),'LBR',0,'R');
        $this->Cell(80,5,iconv('UTF-8', 'TIS-620', 'รายการหักค่าใช้จ่าย'),'LBR',0,'R');
        $this->Cell(45,5,iconv('UTF-8', 'TIS-620', 'รายได้'),'BR',1,'R');


        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'รายได้ปกติ'),'LBR',0);
        $this->Cell(40,5, number_format($row_social['Totals']).iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',0,'R');
        $this->Cell(40,5, iconv('UTF-8', 'TIS-620', 'รายการ'),'LBR',0,'C');
        $this->Cell(8,5, iconv('UTF-8', 'TIS-620', 'Qty.'),'BR',0,'C');
        $this->Cell(8,5, iconv('UTF-8', 'TIS-620', 'ราคา'),'BR',0,'C');
        $this->Cell(8,5, iconv('UTF-8', 'TIS-620', 'งวดที่'),'BR',0,'C');
        $this->Cell(8,5,iconv('UTF-8', 'TIS-620', 'งวดละ'),'BR',0,'C');
        $this->Cell(8,5,iconv('UTF-8', 'TIS-620', 'คงเหลือ'),'BR',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'ค่าแรง'),'LBR',0,'R');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(20,5, number_format($mTotals).iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',1,'R');

        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลา 1'),'LBR',0);
        $this->Cell(40,5, number_format($row_social['TotalOT1']).iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',0,'R');
        $this->Cell(40,5, $resultData1[0],'LBR',0,'C');
        $this->Cell(8,5, $resultData2[0],'BR',0,'C');
        $this->Cell(8,5, number_format($resultData3[0]),'BR',0,'C');
        $this->Cell(8,5, $resultData4[0],'BR',0,'C');
        $this->Cell(8,5, $resultData5[0],'BR',0,'C');
        $this->Cell(8,5, $resultData6[0],'BR',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'ค่าประกันสังคม'),'LBR',0,'R');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(20,5, $row_social['Socials'].iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',1,'R');

        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลา 1.5'),'LBR',0);
        $this->Cell(40,5, number_format($row_social['TotalOT15']).iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',0,'R');
        $this->Cell(40,5, $resultData1[1],'LBR',0,'C');
        $this->Cell(8,5, $resultData2[1],'BR',0,'C');
        $this->Cell(8,5, number_format($resultData3[1]),'BR',0,'C');
        $this->Cell(8,5, $resultData4[1],'BR',0,'C');
        $this->Cell(8,5, $resultData5[1],'BR',0,'C');
        $this->Cell(8,5, $resultData6[1],'BR',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'ค่าภาษี'),'LBR',0,'R');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(20,5,iconv('UTF-8', 'TIS-620', '0 บาท'),'LBR',1,'R');

        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลา 2'),'LBR',0);
        $this->Cell(40,5, number_format($row_social['TotalOT2']).iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',0,'R');
        $this->Cell(40,5, $resultData1[2],'LBR',0,'C');
        $this->Cell(8,5, $resultData2[2],'BR',0,'C');
        $this->Cell(8,5, number_format($resultData3[2]),'BR',0,'C');
        $this->Cell(8,5, $resultData4[2],'BR',0,'C');
        $this->Cell(8,5, $resultData5[2],'BR',0,'C');
        $this->Cell(8,5, $resultData6[2],'BR',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'รายได้อื่นๆ'),'LBR',0,'R');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(20,5, $sumTotalGl.iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',1,'R');

        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(65,5,iconv('UTF-8', 'TIS-620', 'รายได้อื่นๆ'),'LBR',0,'R');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(40,5, $resultData1[3],'LBR',0,'C');
        $this->Cell(8,5, $resultData2[3],'BR',0,'C');
        $this->Cell(8,5, number_format($resultData3[3]),'BR',0,'C');
        $this->Cell(8,5, $resultData4[3],'BR',0,'C');
        $this->Cell(8,5, $resultData5[3],'BR',0,'C');
        $this->Cell(8,5, $resultData6[3],'BR',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(25,5,iconv('UTF-8', 'TIS-620', 'รายจ่าย'),'LBR',0,'R');

        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(20,5, $P0.iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',1,'R');

        $this->Cell(25,5, iconv('UTF-8', 'TIS-620', 'ค่าเบี้ยเลี้ยง'),'LBR',0);
        $this->Cell(40,5, !empty($TotalM)?  number_format($TotalM).iconv('UTF-8', 'TIS-620', ' บาท') : iconv('UTF-8', 'TIS-620', '0 บาท'),'LBR',0,'R');
        $this->Cell(40,5, $resultData1[4],'LBR',0,'C');
        $this->Cell(8,5, $resultData2[4],'BR',0,'C');
        $this->Cell(8,5, number_format($resultData3[4]),'BR',0,'C');
        $this->Cell(8,5, $resultData4[4],'BR',0,'C');
        $this->Cell(8,5, $resultData5[4],'BR',0,'C');
        $this->Cell(8,5, $resultData6[4],'BR',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(45,5,iconv('UTF-8', 'TIS-620', 'ยอดคงเหลือ'),'R',1,'C');
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);

        
        $this->Cell(25,5, iconv('UTF-8', 'TIS-620', 'ค่าแรงตกงวดก่อน'),'LBR',0);
        $this->Cell(40,5, number_format($Gl_2).iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',0,'R');
        $this->Cell(40,5, $resultData1[5],'LBR',0,'C');
        $this->Cell(8,5, $resultData2[5],'BR',0,'C');
        $this->Cell(8,5, number_format($resultData3[5]),'BR',0,'C');
        $this->Cell(8,5, $resultData4[5],'BR',0,'C');
        $this->Cell(8,5, $resultData5[5],'BR',0,'C');
        $this->Cell(8,5, $resultData6[5],'BR',0,'C');
        $this->Cell(45,5,iconv('UTF-8', 'TIS-620', ''),'BR',1,'C');

        $this->Cell(25,5, iconv('UTF-8', 'TIS-620', 'ค่าล่วงเวลาพิเศษ'),'LBR',0);
        $this->Cell(40,5, !empty($Gl_3) ? number_format($Gl_3).iconv('UTF-8', 'TIS-620', ' บาท') : iconv('UTF-8', 'TIS-620', '0 บาท'),'LBR',0,'R');
        $this->Cell(40,5, $resultData1[6],'LBR',0,'C');
        $this->Cell(8,5, $resultData2[6],'BR',0,'C');
        $this->Cell(8,5, number_format($resultData3[6]),'BR',0,'C');
        $this->Cell(8,5, $resultData4[6],'BR',0,'C');
        $this->Cell(8,5, $resultData5[6],'BR',0,'C');
        $this->Cell(8,5, $resultData6[6],'BR',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(45,5, number_format($sumTotals),'R',1,'C');
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);

        $this->Cell(25,5, iconv('UTF-8', 'TIS-620', 'ค่าอื่นๆ'),'LBR',0);
        $this->Cell(40,5, number_format($other).iconv('UTF-8', 'TIS-620', ' บาท'),'LBR',0,'R');
        $this->Cell(40,5, $resultData1[7],'LBR',0,'C');
        $this->Cell(8,5, $resultData2[7],'BR',0,'C');
        $this->Cell(8,5, number_format($resultData3[7]),'BR',0,'C');
        $this->Cell(8,5, $resultData4[7],'BR',0,'C');
        $this->Cell(8,5, $resultData5[7],'BR',0,'C');
        $this->Cell(8,5, $resultData6[7],'BR',0,'C');
        $this->Cell(45,5,iconv('UTF-8', 'TIS-620', ''),'BR',1,'C');

        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(145,5,iconv('UTF-8', 'TIS-620', 'ยอดสะสม'),'LBR',0,'R');
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);
        $this->Cell(45,5,iconv('UTF-8', 'TIS-620', ''),'R',1,'R');


        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', 'รายได้'),'LBR',0,'C');
        $this->Cell(19,5,iconv('UTF-8', 'TIS-620', 'ค่าประกันสังคม'),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', 'ภาษี'),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', 'ขาดงาน'),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', 'ลากิจ'),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', 'ลาป่วย'),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', 'ลาอื่นๆ'),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', 'รายได้อื่นๆรวม'),'BR',0,'C');
        $this->Cell(45,5,iconv('UTF-8', 'TIS-620', '..........................................................'),'R',1,'C');

        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', ''),'LBR',0,'C');
        $this->Cell(19,5,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->Cell(18,5,iconv('UTF-8', 'TIS-620', ''),'BR',0,'C');
        $this->AddFont('Tahoma','B','Tahoma.php');
        $this->SetFont('Tahoma','B', 10);
        $this->Cell(45,5,iconv('UTF-8', 'TIS-620', 'ผู้ตรวจสอบ'),'BR',1,'C');
        $this->AddFont('angsa','','angsa.php');
        $this->SetFont('angsa','', 12);

        $this->Cell(190,5,iconv('UTF-8', 'TIS-620', '2,4 ซอยประเสริฐมนูกิจ 29 แยก 8 ถนนประเสริฐมนูกิจ, แขวงจรเข้บัว, เขตลาดพร้าว, กรุงเทพมหานคร 10230 โทร 02-9426491-6 แฟกซ์ 02-9426497-8'),0,1,'C');
        $this->Ln(5);
    }
}

$pdf = new PDF( 'P' , 'mm' , array( 300,210 ) );
$pdf->AddPage();
$title = 'Slip';
$pdf->SetTitle($title);
for($s=1;$s<=$num_e;$s++) {
    $row_e = mssql_fetch_array($query_e);
    $Eid = $row_e['ID'];

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
                E.Em_Lastname,
                D.Date_
        FROM
                dbo.Datetable AS D CROSS JOIN dbo.Employees AS E
        WHERE
                (D.Date_ BETWEEN CONVERT(DATETIME, '". $Period_Start ."', 102) AND CONVERT(DATETIME, '". $Period_End ."', 102))
        GROUP BY
                E.Em_ID,
                E.Em_Fullname,
                E.Em_Lastname,
                D.Date_) AS TB1 ON TB2_1.Em_ID = TB1.Em_ID AND TB2_1.LogTime = TB1.Date_
    WHERE (TB1.Em_ID = '". $Eid ."')
    GROUP BY
        TB1.Date_,
        TB1.Em_ID,
        TB1.Em_Fullname,
		TB1.Em_Lastname,
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
        $dataTime = $dataTime->format('Y-m-d');
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
    $money = $row_e['Money'];
    $code = $row_e['ID_TH'];

    // $a = $money / 9;$b = $money / 8;

    // $total = $row_e['Total'];
    // $total1 = $row_e['OTN'];
    // $total15 = $row_e['total15'] + $row_e['OTE'];
    // $total2 = $row_e['total2'];

    // // $P_total = $t

    // $P_total = $total * $a;
    // $P_total1 = $b * $total1;
    // $P_total15 = $b * 1.5 * $total15;
    // $P_total2 = $b * 2 * $total2;

    // $IISJ = $P_total + $P_total15 + $P_total2;

    $pdf->AddFont('angsa', '', 'angsa.php');
    $pdf->SetFont('angsa', '', 14);
    $pdf->BasicTable($data1, $data2, $data3, $data4, $data5, $Eid, $Period, $money, $name, $group, $position, $site, $code, $Period_Start, $Period_End, $s, $Period_Week);
}
$pdf->Output();
?>
<?php
@session_start();
require("../inc/connect.php");
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    1.8.0, 2014-03-02
 */

// echo 'C:\Users\'.$_ENV["COMPUTERNAME"].'\Desktop'.'<br>';
// echo 'C:\Users'.DIRECTORY_SEPARATOR.$_ENV["COMPUTERNAME"].DIRECTORY_SEPARATOR.'Desktop';

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';


// Create new PHPExcel object
// echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
// echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("PHPExcel Test Document")
                             ->setSubject("PHPExcel Test Document")
                             ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                             ->setKeywords("office PHPExcel php")
                             ->setCategory("Test result file");


// Add some data
// echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'รหัสบัตรประชาชน')
            ->setCellValue('B1', 'รหัสพนักงาน')
            ->setCellValue('C1', 'ชื่อ-นามสกุล')
            ->setCellValue('D1', 'ค่าแรง')
            ->setCellValue('E1', 'เพศ')
            ->setCellValue('F1', 'ตำแหน่ง')
            ->setCellValue('G1', 'ชุด')
            ->setCellValue('H1', 'โครงการ')
            ->setCellValue('I1', 'วันเกิด')
            ->setCellValue('J1', 'กรุ๊ปเลือด')
            ->setCellValue('K1', 'ที่อยู่')
            ->setCellValue('L1', 'เบอร์โทร')
            ->setCellValue('M1', 'เริ่มทำงาน')
            ->setCellValue('N1', 'วันที่ออกจากงาน')
            ->setCellValue('O1', 'รายละเอียด')
            ->setCellValue('P1', 'ธนาคาร')
            ->setCellValue('Q1', 'ชื่อธนาคาร')
            ->setCellValue('R1', 'เลขบัญชี')
            ->setCellValue('S1', 'เบี้ยเลี้ยง');

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
            AND E.Bank_ID = Ba.Bank_ID
            AND E.Site_ID = '".$_SESSION['SuperSite']."' ";

$query = mssql_query($sql);
$num = mssql_num_rows($query);

$Name = array();

for($i=1;$i<=$num;$i++) {
    $rows = mssql_fetch_array($query);

    array_push($Name, $rows);
}
$baseRow = 3;
foreach($Name as $r => $dataRow) {
    $row = $baseRow + $r;
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $dataRow['Card'])
                                  ->setCellValue('B'.$row, $dataRow['Em_ID'])
                                  ->setCellValue('E'.$row, $dataRow['Sex'])
                                  ->setCellValue('C'.$row, iconv('TIS-620','UTF-8', $dataRow['Fullname']).' '.iconv('TIS-620','UTF-8', $dataRow['Lastname']))
                                  ->setCellValue('D'.$row, $dataRow['Moneies'])
                                  ->setCellValue('F'.$row, iconv('TIS-620','UTF-8', $dataRow['Pos_Name']))
                                  ->setCellValue('G'.$row, iconv('TIS-620','UTF-8', $dataRow['Group_Name']))
                                  ->setCellValue('H'.$row, iconv('TIS-620','UTF-8', $dataRow['Site_Name']))
                                  ->setCellValue('I'.$row, $dataRow['BrithDay'])
                                  ->setCellValue('J'.$row, iconv('TIS-620','UTF-8', $dataRow['Blood']))
                                  ->setCellValue('K'.$row, iconv('TIS-620','UTF-8', $dataRow['Address']))
                                  ->setCellValue('L'.$row, $dataRow['Phone'])
                                  ->setCellValue('M'.$row, $dataRow['OpenWork'])
                                  ->setCellValue('N'.$row, $dataRow['OutWork'])
                                  ->setCellValue('O'.$row, iconv('TIS-620','UTF-8', $dataRow['Remark']))
                                  ->setCellValue('P'.$row, iconv('TIS-620','UTF-8', $dataRow['Bank']))
                                  ->setCellValue('Q'.$row, iconv('TIS-620','UTF-8', $dataRow['BankName']))
                                  ->setCellValue('R'.$row, $dataRow['BankNum'])
                                  ->setCellValue('S'.$row, $dataRow['LivingExpenses']);
}
$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

// Rename worksheet
// echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
// echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$sql_sites = "SELECT Site_ID, CAST(Site_Name as text) as Site_Name FROM [HRP].[dbo].[Sites] where Site_ID = '".$_SESSION['SuperSite']."' ";
$q_sites = mssql_query($sql_sites);
$r_sites = mssql_fetch_assoc($q_sites);

$todays = date('d-m-Y');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', $r_sites['Site_ID'].'_'.$todays.'.php'));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

$name_excel = $r_sites['Site_ID'].'_'.$todays.'.xlsx';
$searchEx = "SELECT * FROM [HRP].[dbo].[Excel] WHERE Excel_Name = '".$name_excel."' ";
$queryEx = mssql_query($searchEx);
$numEx = mssql_num_rows($queryEx);

if($numEx == '0') {
    $insert_excel = "INSERT INTO [HRP].[dbo].[Excel] (Excel_Name) values ('$name_excel')";
    mssql_query($insert_excel);

    exit("<script>window.location='../Employee.php';</script>");
} else {
    exit("<script>window.location='../Employee.php';</script>");
}
?>
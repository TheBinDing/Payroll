<?php
    @session_start();
    require("inc/connect.php");
    require("inc/function.php");
    checklogin($_SESSION['user_name']);
    $HeadCheck = 'EmployeeTransfer';
    // if($_SESSION['user_name'] == "")
    // {
    //     echo "Please Login!";
    //     exit("<script>alert('Please Login');window.location='login.php';</script>");
    // }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="css/plugins/switchery/switchery.css" rel="stylesheet">
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body onload="test();">
    <div class="row">
        <?php
            require("Head2.php");
        ?>
        <div id="page-wrapper" class="gray-bg">
        <?php require("MenuSite.php"); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
                <h1>
                    <strong> บุคคลากร </strong>
                </h1>
                <?php
                    $Format = new DateTime();
                    $Format = $Format->format('d-m-Y');

                    if(isset($_GET['Em_ID'])){
                        $sql = "SELECT
                                    E.Em_ID AS ID,
                                    CAST(E.Em_Card AS Text) AS Card,
                                    CAST(E.Em_People AS Text) AS People,
                                    CAST(E.Em_Fullname AS Text) AS Fullname,
                                    CAST(E.Em_NickName AS Text) AS NickName,
									/*E.Socie AS Soice,*/
                                    E.Em_DateOpen AS DateOpen,
                                    E.Em_DateBirthDay AS DateBirthDay,
                                    CAST(E.Em_Pic AS Text) AS Pic,
                                    E.Em_Age AS Age,
                                    CAST(E.Em_DayCost AS Text) AS DayCost,
                                    CAST(E.Em_ChoiceBank AS Text) AS ChoiceBank,
                                    CAST(E.Em_BankBranch AS Text) AS BankBranch,
                                    E.Em_AccountNumber AS AccountNumber,
                                    E.Em_LivingExpenses AS LivingExpenses,
                                    E.Em_Allowance AS Allowance,
                                    E.Em_AllowanceDisaster AS AllowanceDisaster,
                                    E.Em_AllowanceSafety AS AllowanceSafety,
                                    E.Em_SpecialAllowance AS SpecialAllowance,
                                    E.Em_Width AS Width,
                                    E.Em_Height AS Height,
                                    CAST(E.Em_Address AS Text) AS Address,
                                    E.Em_Tel AS Tel,
                                    E.Em_Mobile AS Mobile,
                                    CAST(E.Em_Titel AS Text) AS Titel,
                                    CAST(E.Em_Status AS Text) AS Status,
                                    CAST(E.Em_Status_Reason AS Text) AS Blacklist,
                                    S.Site_ID AS Site_ID,
                                    CAST(S.Site_Name AS Text) AS Site_Name,
                                    P.Pos_ID AS Pos_ID,
                                    CAST(P.Pos_Name AS Text) AS Pos_Name,
                                    G.Group_ID AS Group_ID,
                                    CAST(G.Group_Name AS Text) AS Group_Name,
                                    Gb.Blood_ID AS Blood_ID,
                                    CAST(Gb.Blood_Name AS Text) AS Blood_Name,
                                    R.Re_ID AS Re_ID,
                                    CAST(R.Re_Name AS Text) AS Re_Name,
                                    B.Bank_ID AS Bank_ID,
                                    CAST(B.Bank_Name AS Text) AS Bank_Name,
                                    E.Em_Money AS Money,
                                    E.Em_Email AS Email,
                                    CAST(E.Em_Work_Date AS Text) AS Work_Date
                                FROM
                                    [HRP].[dbo].[Employees] AS E,
                                    [HRP].[dbo].[Sites] AS S,
                                    [HRP].[dbo].[Group] AS G,
                                    [HRP].[dbo].[Position] AS P,
                                    [HRP].[dbo].[GroupBlood] AS Gb,
                                    [HRP].[dbo].[Religion] AS R,
                                    [HRP].[dbo].[Banks] AS B
                                WHERE
                                    E.Site_ID = S.Site_ID
                                    AND E.Group_ID = G.Group_ID
                                    AND E.Pos_ID = P.Pos_ID
                                    AND E.Blood_ID = Gb.Blood_ID
                                    AND E.Re_ID = R.Re_ID
                                    AND E.Bank_ID = B.Bank_ID
                                    AND E.Em_ID = '". $_GET['Em_ID'] ."' ";
                        $query = mssql_query($sql);
                        $row = mssql_fetch_array($query);

                        $DateOpen = new DateTime($row['DateOpen']);
                        $DateOpen = $DateOpen->format('d-m-Y');
                        $DateBirthDay = new DateTime($row['DateBirthDay']);
                        $DateBirthDay = $DateBirthDay->format('d-m-Y');
                        $DateBirthBlacklist = new DateTime($row['DateBirthBlacklist']);
                        $DateBirthBlacklist = $DateBirthBlacklist->format('d-m-Y');

                        $WorkDays = $row['Work_Date'];
                        $WorkDays = explode('-', $WorkDays);
                    }
                ?>
                <!-- <form action="func/EmployeeSave.php" method="POST" enctype="multipart/form-data"> -->
                <form action="func/EmployeeTransferSave.php" method="POST" enctype="multipart/form-data" target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div class="ibox-content">
                        <div class="form-group">
                            <input type="hidden" id="Rule" value="<?php echo $_SESSION['Rule'];?>">
                            <input type="hidden" id="FormatDate" value="<?php echo $Format;?>">
                            <div class="radio-inline">
                                <?php if($row['Pic'] == '') { ?>
                                <a href="#">
                                    <img alt="" src="img/Login.png" data-holder-rendered="true" style="height: 150px; width: 150px; display: block;">
                                </a>
                                <?php } else { ?>
                                <a href="#">
                                    <img alt="" src="func/EmployeePicture/<?php echo iconv('TIS-620','UTF-8',$row['Pic']); ?>" data-holder-rendered="true" style="height: 150px; width: 150px; display: block;">
                                </a>
                                <?php } ?>
                                <fieldset class="form-group">
                                    <label for="exampleInputFile">ภาพประจำตัว</label>
                                    <input type="file" name="filUpload"><br>
                                    <small class="text-muted"></small>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio radio-info radio-inline">
                                <div class="radio radio-info radio-inline">
                                    <input type="radio" name="People" id="People1" value="TH" <?php
                                        if(iconv('TIS-620','UTF-8',$row['People']) == 'TH')
                                            echo 'checked';
                                        if(iconv('TIS-620','UTF-8',$row['People']) == '')
                                            echo 'checked';
                                    ?>>
                                    <label for="inlineRadio1"> คนไทย </label>
                                </div>
                                <div class="radio radio-info radio-inline">
                                    <input type="radio" name="People" id="People2" value="NTH" <?php if(iconv('TIS-620','UTF-8',$row['People']) == 'NTH') echo 'checked';?>>
                                    <label for="inlineRadio1"> คนต่างด้าว </label>
                                </div>
                            </div>
                            <?php if(iconv('TIS-620','UTF-8',$row['Card']) != '') { $cards = '#ddd'; } ?>
                            <label class="radio-inline width-text2" id="PeopleCard"> เลขบัตรประชาชน </label>
                            <input name="dataCard" style="width: 13%;height: 30px;text-align: center;background-color:<?=$cards?>;" type="text" id="dataCard" value="<?php echo iconv('TIS-620','UTF-8',$row['Card']); ?>" <?php if(iconv('TIS-620','UTF-8',$row['Card']) != '') echo 'readonly'; ?> data-mask="9-9999-99999-99-9" placeholder="" onchange="CheckNumberEmployee(this);" required>

                            <!-- <label class="radio-inline width-text2" id="PeoplePass" style="display: none;"> เลขบัตรประชาชน </label>
                            <input name="dataPass" type="text" id="dataPass" style="width: 13%;height: 30px;text-align: center;display: none;" value="<?php echo iconv('TIS-620','UTF-8',$row['Passport']); ?>" <?php if(iconv('TIS-620','UTF-8',$row['Passport']) != '') echo 'readonly'; ?> data-mask="9-9999-99999-99-9"> -->

                            <?php if($row['People'] == 'NTH' || $row['People'] == '') { ?>
                            <span id="check" class="width-text2">
                                <label class="radio-inline width-text2" id="PeopleSocie"> ประกันสังคม </label>
                                <input type="checkbox" class="js-switch" id="Society" name="Society" value="1" <?php if($row['Soice'] == '1') echo 'checked'; ?>/>
                            </span>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline"> คำนำหน้า </label>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Titel" id="Titel1" value="Mr" <?php if(iconv('TIS-620','UTF-8',$row['Titel']) == 'Mr') echo 'checked'; if(iconv('TIS-620','UTF-8',$row['Titel']) == '') echo 'checked'; ?> >
                                <label for="inlineRadio1"> นาย </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Titel" id="Titel2" value="Ms" <?php if(iconv('TIS-620','UTF-8',$row['Titel']) == 'Ms') echo 'checked';?> >
                                <label for="inlineRadio1"> นางสาว </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Titel" id="Titel3" value="Mrs" <?php if(iconv('TIS-620','UTF-8',$row['Titel']) == 'Mrs') echo 'checked';?> >
                                <label for="inlineRadio1"> นาง </label>
                            </div>

                            <label class="radio-inline width-text2"> ชื่อ-นามสกุล </label>
                            <input type="text" style="text-align: center;height: 30px;width: 200px;" class="form-control-card" name="Fullname" id="Fullname" required value="<?php echo iconv('TIS-620','UTF-8',$row['Fullname']); ?>">

                            <label class="radio-inline width-text1"> ชื่อเล่น </label>
                            <input type="text" style="text-align: center;height: 30px;" class="form-control-small" name="NickName" id="NickName" value="<?php echo iconv('TIS-620','UTF-8',$row['NickName']); ?>">
                        </div>
                        <div class="form-group" style="height: 50px;">
                            <div class="col-lg-2" id="data_2">
                                <label class="radio-inline" style="height: 18px;"> วันที่เริ่มงาน </label>
                                <div class="input-group date" data-date="<?php if($DateOpen != '') echo $DateOpen; else echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" style="padding-left: 20px;" id="data_2">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="DateOpen" id="DateOpen" class="form-control" value="<?php if($DateOpen != '') echo $DateOpen; else echo date('d-m-Y'); ?>" style="width: 100px;height: 30px;" readonly>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <br>
                                <input type="text" style="height: 30px;width: 50px;text-align: center;background-color: <?=$cards;?>" class="form-control-small" name="AgeWork-Y" id="AgeWork-Y" required value="" readonly>
                                <label class="width-YMD" style="height: 30px;width: 20px;"> ปี </label>

                                <input type="text" style="height: 30px;width: 50px;text-align: center;background-color: <?=$cards;?>" class="form-control-small" name="AgeWork-M" id="AgeWork-M" required value="" readonly>
                                <label class="width-YMD" style="height: 30px;width: 40px;"> เดือน </label>

                                <input type="text" style="height: 30px;width: 50px;text-align: center;background-color: <?=$cards;?>" class="form-control-small" name="AgeWork-D" id="AgeWork-D" required value="" readonly>
                                <label class="width-YMD" style="height: 30px;width: 30px;"> วัน </label>
                            </div>
                        </div>
                        <div class="form-group">
							<?php
								$sql_site = "SELECT Site_ID, CAST(Site_Name AS Text) AS Site_Name FROM [HRP].[dbo].[Sites] WHERE Site_ID != '". $site ."' ORDER BY Site_ID DESC ";
								$query_site = mssql_query($sql_site);
								$num_site = mssql_num_rows($query_site);
							?>
							<label class="radio-inline width-text1">โครงการ</label>
							<select class="form-control-normal" name="Site" id="Site" style="width: 240px;height: 30px;" onchange="SelectGroup()" required>
								<?php if($row['Site_ID'] != '') {?>
									<option value="<?php echo $row['Site_ID']; ?>"><?php echo iconv('TIS-620','UTF-8',$row['Site_Name']); ?></option>
								<?php } else { ?>
									<option value=""> โปรดเลือกโครงการ </option>
								<?php } ?>
								<?php
								for($i=1;$i<=$num_site;$i++)
								{
									$row_site = mssql_fetch_array($query_site);
								?>
									<option value="<?php echo $row_site['Site_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_site['Site_Name']);?></option>
								<?php } ?>
							</select>

                            <?php
                                $sql_pos = "SELECT Pos_ID, CAST(Pos_Name AS Text) AS Pos_Name FROM [HRP].[dbo].[Position] WHERE Pos_ID != '".$row['Pos_ID']."' ORDER BY Pos_ID DESC ";
                                $query_pos = mssql_query($sql_pos);
                                $num_pos = mssql_num_rows($query_pos);
                            ?>
                            <label class="radio-inline width-text1"> ตำแหน่ง </label>
                            <select class="form-control-normal" name="Position" id="Position" style="width: 150px;height: 30px;" required>
                                <?php if($row['Pos_ID'] != '') {?>
                                    <option value="<?php echo $row['Pos_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row['Pos_Name']);?></option>
                                <?php } else { ?>
                                    <option value=""> โปรดเลือกตำแหน่ง </option>
                                <?php } ?>
                                <?php
                                for($i=1;$i<=$num_pos;$i++)
                                {
                                    $row_pos = mssql_fetch_array($query_pos);
                                ?>
                                    <option value="<?php echo $row_pos['Pos_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_pos['Pos_Name']);?></option>
                                <?php } ?>
                            </select>

                            <?php
                                $sql_group = "SELECT Group_ID, CAST(Group_Name AS Text) AS Group_Name FROM [HRP].[dbo].[Group] WHERE Group_ID != '".$row['Group_ID']."' AND Site_ID = '". $_SESSION['SuperSite'] ."' ORDER BY Group_ID DESC ";
                                $query_group = mssql_query($sql_group);
                                $num_group = mssql_num_rows($query_group);
                            ?>
                            <label class="radio-inline width-text1"> ชุด/สังกัด </label>
                            <select class="form-control-normal" name="Groups" id="Groups" style="width: 150px;height: 30px;" required>
                                <?php if($row['Group_ID'] != '') {?>
                                    <option value="<?php echo $row['Group_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row['Group_Name']);?></option>
                                <?php } else { ?>
                                    <option value=""> โปรดเลือกชุด </option>
                                <?php } ?>
                                <?php
                                for($i=1;$i<=$num_group;$i++)
                                {
                                    $row_group = mssql_fetch_array($query_group);
                                ?>
                                    <option value="<?php echo $row_group['Group_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_group['Group_Name']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline">ค่าแรง</label>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="DayCost" id="DayCost1" value="Day" <?php if(iconv('TIS-620','UTF-8',$row['DayCost']) == 'Day') echo 'checked'; if(iconv('TIS-620','UTF-8',$row['DayCost']) == '') echo 'checked';?> >
                                <label for="radio-inline width-text2"> รายวัน </label>
                            </div>

                            <?php if($_SESSION['Rule'] != '2' && iconv('TIS-620','UTF-8',$row['Money'])) { $color = '#ddd';} ?>
                            <input type="number" style="width: 100px;height: 30px;text-align: center;background-color:<?=$color?>;" class="form-control-small" name="Money" id="Money" value="<?php if(iconv('TIS-620','UTF-8',$row['Money']) != '') echo iconv('TIS-620','UTF-8',$row['Money']); else echo '0'; ?>"<?php if($_SESSION['Rule'] != '2' && iconv('TIS-620','UTF-8',$row['Money']) != '') echo 'readonly';?>>
                            <label class="radio-inline"><span>บาท</span> </label>
                        </div>
                        <div class="form-group">
							<label class="radio-inline width-text1"> เบี้ยเลี้ยง </label>
                            <input type="number" style="width: 100px;height: 30px;text-align: center;background-color:<?=$color?>;" class="form-control-small" name="LivingExpenses" id="LivingExpenses"  value="<?php if(iconv('TIS-620','UTF-8',$row['LivingExpenses']) != '') echo iconv('TIS-620','UTF-8',$row['LivingExpenses']); else echo '0'; ?>"<?php if($_SESSION['Rule'] != '2' && iconv('TIS-620','UTF-8',$row['LivingExpenses']) != '') echo 'readonly';?>>

                            <label class="radio-inline width-text1"> เบี้ยเลี้ยง2 </label>
                            <input type="number" style="width: 100px;height: 30px;text-align: center;background-color:<?=$color?>;" class="form-control-small" name="Allowance" id="Allowance" value="<?php if(iconv('TIS-620','UTF-8',$row['Allowance']) != '') echo iconv('TIS-620','UTF-8',$row['Allowance']); else echo '0'; ?>"<?php if($_SESSION['Rule'] != '2' && iconv('TIS-620','UTF-8',$row['Allowance']) != '') echo 'readonly';?>>

                            <label class="radio-inline width-text1"> ค่าเลี้ยงภัย </label>
                            <input type="number" style="width: 100px;height: 30px;text-align: center;background-color:<?=$color?>;" class="form-control-small" name="AllowanceDisaster" id="AllowanceDisaster" value="<?php if(iconv('TIS-620','UTF-8',$row['AllowanceDisaster']) != '') echo iconv('TIS-620','UTF-8',$row['AllowanceDisaster']); else echo '0'; ?>"<?php if($_SESSION['Rule'] != '2' && iconv('TIS-620','UTF-8',$row['AllowanceDisaster']) != '') echo 'readonly';?>>

                            <label class="radio-inline width-text2"> เบี้ยเลี้ยงเซตตี้ </label>
                            <input type="number" style="width: 100px;height: 30px;text-align: center;background-color:<?=$color?>;" class="form-control-small" name="AllowanceSafety" id="AllowanceSafety" value="<?php if(iconv('TIS-620','UTF-8',$row['AllowanceSafety']) != '') echo iconv('TIS-620','UTF-8',$row['AllowanceSafety']); else echo '0'; ?>"<?php if($_SESSION['Rule'] != '2' && iconv('TIS-620','UTF-8',$row['AllowanceSafety']) != '') echo 'readonly';?>>

                            <label class="radio-inline width-text2"> เบี้ยเลี้ยงพิเศษ </label>
                            <input type="number" style="width: 100px;height: 30px;text-align: center;background-color:<?=$color?>;" class="form-control-small" name="SpecialAllowance" id="SpecialAllowance" value="<?php if(iconv('TIS-620','UTF-8',$row['SpecialAllowance']) != '') echo iconv('TIS-620','UTF-8',$row['AllowanceSafety']); else echo '0'; ?>"<?php if($_SESSION['Rule'] != '2' && iconv('TIS-620','UTF-8',$row['SpecialAllowance']) != '') echo 'readonly';?>>
							<label class="radio-inline"><span style="color: red;">* หน่วยต่อบาท</span> </label>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group" style="height: 50px;">
                            <div class="col-lg-2" id="data_1">
                            <label class="radio-inline"> วันเกิด </label>
                            <div class="input-group date" data-date="<?php if($DateBirthDay != '') echo $DateBirthDay; else echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" style="padding-left: 20px;">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="DateBirthDay" id="DateBirthDay" class="form-control" value="<?php if($DateBirthDay != '') echo $DateBirthDay; else echo date('d-m-Y'); ?>" style="width: 100px;height: 30px;" readonly>
                            </div>
                            </div>
                            <div class="col-lg-10">
                                <br>
                                <label class="radio-inline" style="width: 50px;"> อายุ </label>
                                <input type="text" style="height: 30px;text-align: center;width: 70px;background-color:<?=$cards?>;" class="form-control-small" name="Age" id="Age" value="<?php if($row['Age'] != '') echo $row['Age']; else echo '0'; ?>" readonly required>

                                <label class="radio-inline width-text1"> น้ำหนัก </label>
                                <input type="number" style="height: 30px;text-align: center;width: 70px;" class="form-control-small" name="Width" id="Width" value="<?php if($row['Height'] != '') echo $row['Width']; else echo '0'; ?>">

                                <label class="radio-inline width-text1"> ส่วนสูง </label>
                                <input type="number" style="height: 30px;text-align: center;width: 70px;" class="form-control-small" name="Height" id="Height" value="<?php if($row['Height'] != '') echo $row['Height']; else echo '0'; ?>">

                                <?php
                                    $sql_blood = "SELECT Blood_ID, CAST(Blood_Name AS Text) AS Blood_Name FROM [HRP].[dbo].[GroupBlood] WHERE Blood_ID != '".$row['Blood_ID']."' ";
                                    $query_blood = mssql_query($sql_blood);
                                    $num_blood = mssql_num_rows($query_blood);
                                ?>
                                <label class="radio-inline width-text1" style="padding-left: 10px;width: 60px;"> กรุ๊ปเลือด </label>
                                <select class="form-control-narmal" name="Blood" id="Blood" style="height: 30px;">
                                    <?php if($row['Blood_ID'] != '') {?>
                                        <option value="<?php echo $row['Blood_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row['Blood_Name']);?></option>
                                    <?php } else { ?>
                                        <option value="6"> -Select- </option>
                                    <?php } ?>
                                    <?php
                                    for($i=1;$i<=$num_blood;$i++)
                                    {
                                        $row_blood = mssql_fetch_array($query_blood);
                                    ?>
                                        <option value="<?php echo $row_blood['Blood_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_blood['Blood_Name']);?></option>
                                    <?php } ?>
                                </select>

                                <?php
                                    if($row['Re_ID'] != '') {
                                        $sql_re = "SELECT Re_ID, CAST(Re_Name AS Text) AS Re_Name FROM [HRP].[dbo].[Religion] WHERE Re_ID != '".$row['Re_ID']."' ";
                                    } else {
                                        $sql_re = "SELECT Re_ID, CAST(Re_Name AS Text) AS Re_Name FROM [HRP].[dbo].[Religion] WHERE Re_ID != '1' ";
                                    }
                                    $query_re = mssql_query($sql_re);
                                    $num_re = mssql_num_rows($query_re);
                                ?>
                                <label class="radio-inline width-text1" style="padding-left: 10px;width: 60px;"> เชื้อชาติ </label>
                                <select class="form-control-narmal" name="Religion" id="Religion"  style="height: 30px;">
                                    <?php if($row['Re_ID'] != '') {?>
                                        <option value="<?php echo $row['Re_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row['Re_Name']);?></option>
                                    <?php } else { ?>
                                        <option value="1"> ไทย </option>
                                    <?php } ?>
                                    <?php
                                    for($i=1;$i<=$num_re;$i++)
                                    {
                                        $row_re = mssql_fetch_array($query_re);
                                    ?>
                                        <option value="<?php echo $row_re['Re_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_re['Re_Name']);?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline" style="height: 18px;margin-bottom: -5px;margin-left: 15px;"> ที่อยู่ตามทะเบียนบ้าน </label>
                        </div>
                        <div class="form-group" style="padding-left: 20px;">
                            <textarea class="form-control-textarea" style="width: 740px;height: auto;" name="Address" id="Address" maxlength="200" cols="45" rows="5"><?php echo iconv('TIS-620','UTF-8',$row['Address']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline width-text1"> โทรศัพท์ </label>
                            <input type="text" style="text-align: center;height: 30px;width: 10%;" data-mask="99-999-9999" placeholder="02-xxx-xxxx" class="form-control-normal" name="Tel" id="Tel" value="<?php echo iconv('TIS-620','UTF-8',$row['Tel']); ?>">

                            <label class="radio-inline width-text2"> โทรศัพท์มือถือ </label>
                            <input type="text" style="text-align: center;height: 30px;width: 10%;" data-mask="999-999-9999" placeholder="08x-xxx-xxxx" class="form-control-normal" name="Mobile" id="Mobile" value="<?php echo iconv('TIS-620','UTF-8',$row['Mobile']); ?>">

                            <label class="radio-inline width-text1"> อีเมล์ </label>
                            <input type="email" style="text-align: center;height: 30px;width: 250px;" placeholder="Thaipolycons@thaipolocons.co.th" class="form-control-normal" name="Email" id="Email" value="<?php echo iconv('TIS-620','UTF-8',$row['Email']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="radio-inline width-text1"> สถานะ </label>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Status" id="Status1" value="W" <?php if(iconv('TIS-620','UTF-8',$row['Status']) == 'W') echo 'checked'; if(iconv('TIS-620','UTF-8',$row['Status']) == '') echo 'checked';?> >
                                <label for="inlineRadio1"> ทำงาน </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Status" id="Status3" value="O" <?php if(iconv('TIS-620','UTF-8',$row['Status']) == 'O') echo 'checked';?> >
                                <label for="inlineRadio1"> ออก </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="Status" id="Status2" value="B" <?php if(iconv('TIS-620','UTF-8',$row['Status']) == 'B') echo 'checked';?> >
                                <label for="inlineRadio1"> ติด Blacklist </label>
                            </div>
                        </div>
                        <div class="form-group" id="dataBlacklist" style="display: none;">
                            <label class="radio-inline width-text1"> เหตุผล </label>
                            <input type="text" class="form-control-normal" style="height: 30px;" name="Blacklist" id="Blacklist" value="<?php echo iconv('TIS-620','UTF-8',$row['Blacklist']); ?>">

                            <div class="input-append date " id="birthday" data-date="<?php echo $DateBirthBlacklist; ?>" data-date-format="dd-mm-yyyy">
                                <label class="radio-inline width-text1" style="height: 30px;"> วันที่ </label>
                                <input class="span2" name="DateBirthBlacklist" id="DateBirthBlacklist" type="text" value="<?php if($DateBirthBlacklist != '') echo $DateBirthBlacklist; else echo date('d-m-Y'); ?>" style="text-align: center;height: 30px;" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="radio-inline"> การรับเงิน </label>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="ChoiceBank" id="Bank1" value="C" <?php if(iconv('TIS-620','UTF-8',$row['ChoiceBank']) == 'C') echo 'checked'; if(iconv('TIS-620','UTF-8',$row['ChoiceBank']) == '') echo 'checked';?>>
                                <label for="inlineRadio1"> รับเงินสด </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="ChoiceBank" id="Bank2" value="B" <?php if(iconv('TIS-620','UTF-8',$row['ChoiceBank']) == 'B') echo 'checked';?>>
                                <label for="inlineRadio1"> โอนเข้าธนาคาร </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline width-text1"> ธนาคาร </label>
                            <?php
                                if($row['Bank_ID'] != '') {
                                    $sql_b = "SELECT Bank_ID, CAST(Bank_Name AS Text) AS Bank_Name FROM [HRP].[dbo].[Banks] WHERE Bank_ID != '". $row['Bank_ID'] ."' ";
                                } else {
                                    $sql_b = "SELECT Bank_ID, CAST(Bank_Name AS Text) AS Bank_Name FROM [HRP].[dbo].[Banks] WHERE Bank_ID != '1' ";
                                }
                                $query_b = mssql_query($sql_b);
                                $num_b = mssql_num_rows($query_b);
                            ?>
                            <select class="form-control-small" name="Bank" id="Bank" style="width : 200px;height: 30px;" <?php if(iconv('TIS-620','UTF-8',$row['ChoiceBank']) == 'C' || iconv('TIS-620','UTF-8',$row['ChoiceBank']) == '') echo 'readonly';?>>
                                <?php if($row['Bank_ID'] != '') {?>
                                    <option value="<?php echo $row['Bank_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row['Bank_Name']);?></option>
                                <?php } else { ?>
                                    <option value="1"> ธนาคารกสิกร </option>
                                <?php } ?>
                                <?php
                                for($b=1;$b<=$num_b;$b++)
                                {
                                    $row_b = mssql_fetch_array($query_b);
                                ?>
                                    <option value="<?php echo $row_b['Bank_ID'];?>"><?php echo iconv('TIS-620','UTF-8',$row_b['Bank_Name']);?></option>
                                <?php } ?>
                            </select>

                            <label class="radio-inline width-text1"> สาขา </label>
                            <input type="text" style="height: 30px;text-align: center;" class="form-control-normal" name="BankBranch" id="BankBranch" value="<?php echo iconv('TIS-620','UTF-8',$row['BankBranch']); ?>" <?php if(iconv('TIS-620','UTF-8',$row['ChoiceBank']) == 'C' || iconv('TIS-620','UTF-8',$row['ChoiceBank']) == '') echo 'disabled';?>>

                            <label class="radio-inline width-text1"> เลขบัญชี </label>
                            <input type="text" style="text-align: center;height: 30px" class="form-control-normal" name="AccountNumber" id="AccountNumber" data-mask="999-9-99999-9" value="<?php echo iconv('TIS-620','UTF-8',$row['AccountNumber']); ?>" 
                            <?php 
                                if(iconv('TIS-620','UTF-8',$row['ChoiceBank']) == 'C' || iconv('TIS-620','UTF-8',$row['ChoiceBank']) == '') { 
                                    echo 'disabled';
                                }
                                if($_SESSION['Rule'] != '2' && iconv('TIS-620','UTF-8',$row['AccountNumber']) != '') {
                                    echo 'readonly';
                                }
                            ?> >
                        </div>
                    </div>
                    <div class="ibox-content">
                        <center>
                            <div class="form-group required " style="padding:20px 15px;">
                                <input type="hidden" name="Em_ID" id="Em_ID" value="<?php echo $row['ID']; ?>" />
                                <button type="submit" class="btn btn-success demo1">เพิ่มข้อมูล</button>
                                <a href="Employee.php" class="btn btn-danger" role="button">กลับ</a>
                            </div>
                        </center>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/plugins/datapicker/bootstrap-datepicker-thai.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="js/moment-with-locales.min.js"></script>
<script src="js/plugins/switchery/switchery.js"></script>
<script src="js/pace.js"></script>
<script>

    function load(time){
      var x = new XMLHttpRequest();
      // x.open('GET', "http://localhost:5646/walter/" + time, true);
      // x.send();
    };

    paceOptions = {
      elements: true
    };

    load(20);
    load(100);
    load(500);
    load(2000);
    load(3000);

    setTimeout(function(){
      Pace.ignore(function(){
        load(3100);
      });
    }, 4000);

    Pace.on('hide', function(){
      console.log('done');
    });

    // range.addEventListener('input', function(){
    //     document.querySelector('.pace').classList.remove('pace-inactive');
    //     document.querySelector('.pace').classList.add('pace-active');

    //     document.querySelector('.pace-progress').setAttribute('data-progress-text', range.value + '%');
    //     document.querySelector('.pace-progress').setAttribute('style', '-webkit-transform: translate3d(' + range.value + '%, 0px, 0px)');
    // });
</script>
<script type="text/javascript">
    (function ( $ ) {
        $('.demo1').click(function(){
            if( $('#DateOpen').val() == $('#FormatDate').val() ) {
                // alert('โปรดระบุวันเข้างาน');
                swal("โปรดระบุวันเข้างาน!")
            }
            else if( $('#DateBirthDay').val() == $('#FormatDate').val() ) {
                // alert('โปรดระบุวันเกิด');
                swal("โปรดระบุวันเกิด!")
            }
            else if(
                $('#dataCard').val() != '' 
                && $('#Fullname').val() != '' 
                && $('#Site').val() != '' 
                && $('#Position').val() != '' 
                && $('#Groups').val() != '' 
                && (($('#DateBirthDay').val() != $('#FormatDate').val()) && ($('#DateOpen').val() != $('#FormatDate').val()))
            ) {
                swal({
                    title: "โปรดรอซักครู่!",
                    text: "กำลังบันทึกข้อมูล",
                    timer: 2000,
                    showConfirmButton: false
                },function(){
                    window.location='Employee.php';
                });
            }
        });

        $('.Soc').click(function(){
            swal({
                title: "โปรดรอซักครู่!",
                text: "กำลังบันทึกข้อมูล",
                timer: 2000,
                showConfirmButton: false
            },function(){
                swal("บันทึกข้อมูลเรียบร้อย")
            });
        });

        if (top.location != location) {
            top.location.href = document.location.href ;
        }

        $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $('#data_2 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $('#DateOpen').change(function(){
            var s = $('#DateOpen').val();
            var res = s.split("-");
            var d = res[2] + '/' + res[1] + '/' + res[0];
            var c = age(new Date(d));
            var c = c.toString();
            var f = c.split("-");
            $('#AgeWork-Y').val(f[0]);
            $('#AgeWork-M').val(f[1]);
            $('#AgeWork-D').val(f[2]);

            // $('#AgeWork').val(age(new Date(d)));
        })

        $('#DateBirthDay').change(function(){
            var dayBirth=$(this).val();
            var getdayBirth=dayBirth.split("-");
            var YB=getdayBirth[2];
            var MB=getdayBirth[1];
            var DB=getdayBirth[0];
                
            var setdayBirth=moment(YB+"-"+MB+"-"+DB);
            var setNowDate=moment();
            var yearData=setNowDate.diff(setdayBirth, 'years', true); // ข้อมูลปีแบบทศนิยม    
            var yearFinal=Math.round(setNowDate.diff(setdayBirth, 'years', true),0); // ปีเต็ม    
            var yearReal=setNowDate.diff(setdayBirth, 'years'); // ปีจริง    
            var monthDiff=Math.floor((yearData-yearReal)*12); // เดือน    
            var str_year_month=yearReal; // ต่อวันเดือนปี    
            $("#Age").val(str_year_month);
        })

        $("#Bank1").click(function(){
            $('#Bank').prop('readonly',true);
            $('#BankBranch').prop('disabled',true);
            $('#AccountNumber').prop('disabled',true);
        });
        $("#Bank2").click(function(){
            $('#Bank').prop('readonly',false);
            $('#BankBranch').prop('disabled',false);
            $('#AccountNumber').prop('disabled',false);
        });
        $('#People1').click(function(){
            $('#check').css('display', 'none');
            // $('#PeopleSocie').css('display', 'none');
            // $('#Society').css('display', 'none');
        });
        $('#People2').click(function(){
            $('#check').css('display', '');
            // $('#PeopleSocie').css('display', '');
            // $('#Society').css('display', '');
        });
        $('#Status2').click(function(){
            $('#dataBlacklist').css('display', '');
            $('#DateBirthBlacklist').attr('disabled', false);
            $('#DateBirthBlacklist').attr('readonly', true);
        });
        $('#Status3').click(function(){
            $('#dataBlacklist').css('display', '');
            $('#DateBirthBlacklist').attr('disabled', false);
            $('#DateBirthBlacklist').attr('readonly', true);
        });
        $('#Status1').click(function(){
            $('#dataBlacklist').css('display', 'none');
            $('#DateBirthBlacklist').attr('disabled', true);
            $('#DateBirthBlacklist').attr('readonly', false);
        });
    } (jQuery));
</script>
<script type="text/javascript">
    jQuery(function( $ ) {
        travflex.compulsory.Criteria = {};

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
    });

    var travflex = {
        compulsory: new Object()
    };

    function CheckNumberEmployee() {
        travflex.compulsory.Criteria['mode'] = 'load_employee_list';
        travflex.compulsory.Criteria['Card'] = $('#dataCard').val();
        var ajax_config = {
            url: "func/loadTest.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            console.log(response);
            EmployeeList = response;
            setEmployee(0);
        });
    }

	function SelectGroup() {
		travflex.compulsory.Criteria['mode'] = 'load_group_list';
        travflex.compulsory.Criteria['Site'] = $('#Site').val();
        var ajax_config = {
            url: "func/loadTest.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            GroupList = response;
            setGroup();
        });
	}
	
	function setGroup() {
		result = GroupList;
		div = document.getElementById('Groups');
		div.innerHTML = '';
		div.add(new Option('โปรดเลือกชุด', ''));
		for(i in result){
			div.add(new Option(result[i]['LongName'], result[i]['Code']));
		}
	}

    function setEmployee(key) {
        result = EmployeeList;

        for(sKey in result[key]){
            $('#'+sKey).val(result[key][sKey]);
        }

        var a = result[key]['DateOpen'];
        spTodayA = a.split(' ');
        todaya = spTodayA[0] + ' ' + spTodayA[1] + ' ' + spTodayA[2];
        dateTodayA = formatDate(todaya);
        var b = result[key]['DateBirthDay'];
        spTodayB = a.split(' ');
        todayb = spTodayB[0] + ' ' + spTodayB[1] + ' ' + spTodayB[2];
        dateTodayB = formatDate(todayb);

        $('#DateOpen').val(dateTodayA);
        $('#DateBirthDay').val(dateTodayB);


        dWork = formatDateSeach(todaya);
        var res = dWork.split("-");
        var d = res[0] + '/' + res[1] + '/' + res[2];
        var c = age(new Date(d));
        var c = c.toString();
        var f = c.split("-");
        $('#AgeWork-Y').val(f[0]);
        $('#AgeWork-M').val(f[1]);
        $('#AgeWork-D').val(f[2]);
        // $('#AgeWork').val(age(new Date(dWork)));

        Rules = $('#Rule').val();

        if(Rules != '1') {
            $('#Money').attr('readonly', true);
            $('#LivingExpenses').attr('readonly', true);
            $('#Allowance').attr('readonly', true);
            $('#AllowanceDisaster').attr('readonly', true);
            $('#AllowanceSafety').attr('readonly', true);
            $('#SpecialAllowance').attr('readonly', true);
        }

        if(result[key]['People'] == 'NTH'){
            document.getElementById("People2").checked = true;
        }
        if(result[key]['Titel'] == 'Ms'){
            document.getElementById("Titel2").checked = true;
        }
        if(result[key]['Titel'] == 'Mrs'){
            document.getElementById("Titel3").checked = true;
        }
        if(result[key]['Status'] == 'B'){
            document.getElementById("Status2").checked = true;
        }
        if(result[key]['Status'] == 'O'){
            document.getElementById("Status3").checked = true;
        }
        if(result[key]['DayCost'] == 'Month'){
            document.getElementById("DayCost2").checked = true;
        }
        if(result[key]['ChoiceBank'] == 'B'){
            document.getElementById("Bank2").checked = true;
        }
        if(result[key]['Socie'] == '1'){
            document.getElementById("Society").checked = true;
        }
        if(result[key]['ChoiceBank'] == 'C'){
            document.getElementById("Bank1").checked = true;
            $('#BankBranch').val('');
            $('#AccountNumber').val('');
        }
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('-');
    }

    function formatDateSeach(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    function age(dob, today) { 
        var today = today || new Date(), 
            result = { 
              years: 0, 
              months: 0, 
              days: 0, 
              toString: function() { 
                return (this.years ? this.years + '-' : 0 + '-') 
                  + (this.months ? this.months + '-' : 0 + '-') 
                  + (this.days ? this.days : 0);
              }
            };
        result.months = 
          ((today.getFullYear() * 12) + (today.getMonth() + 1))
          - ((dob.getFullYear() * 12) + (dob.getMonth() + 1));
        if (0 > (result.days = today.getDate() - dob.getDate())) {
            var y = today.getFullYear(), m = today.getMonth();
            m = (--m < 0) ? 11 : m;
            result.days += 
              [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m] 
                + (((1 == m) && ((y % 4) == 0) && (((y % 100) > 0) || ((y % 400) == 0))) 
                    ? 1 : 0);
            --result.months;
        }
        result.years = (result.months - (result.months % 12)) / 12;
        result.months = (result.months % 12);
        return result;
    }

    function test() {
        $('#DateBirthBlacklist').attr('disabled', true);
        if($('#Status2').attr('checked') == 'checked') {
            $('#dataBlacklist').css('display', '');
        }
        if($('#Status3').attr('checked') == 'checked') {
            $('#dataBlacklist').css('display', '');
        }

        var s = $('#DateOpen').val();
        var res = s.split("-");
        var d = res[2] + '/' + res[1] + '/' + res[0];
        var c = age(new Date(d));
        var c = c.toString();
        var f = c.split("-");
        $('#AgeWork-Y').val(f[0]);
        $('#AgeWork-M').val(f[1]);
        $('#AgeWork-D').val(f[2]);

        var dayBirth=$('#DateBirthDay').val();
        var getdayBirth=dayBirth.split("-");
        var YB=getdayBirth[2];
        var MB=getdayBirth[1];
        var DB=getdayBirth[0];

        var setdayBirth=moment(YB+"-"+MB+"-"+DB);
        var setNowDate=moment();
        var yearData=setNowDate.diff(setdayBirth, 'years', true); // ข้อมูลปีแบบทศนิยม    
        var yearFinal=Math.round(setNowDate.diff(setdayBirth, 'years', true),0); // ปีเต็ม    
        var yearReal=setNowDate.diff(setdayBirth, 'years'); // ปีจริง    
        var monthDiff=Math.floor((yearData-yearReal)*12); // เดือน    
        var str_year_month=yearReal; // ต่อวันเดือนปี
        $("#Age").val(str_year_month);
    }
</script>

<html>
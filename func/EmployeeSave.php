<?php
    @session_start();
    include("../inc/connect.php");

    $People = iconv('UTF-8','TIS-620', $_POST['People']);
    $Titel = iconv('UTF-8','TIS-620', $_POST['Titel']);
    $Fullname = iconv('UTF-8','TIS-620', $_POST['Fullname']);
    $Lastname = iconv('UTF-8','TIS-620', $_POST['Lastname']);
    $NickName = iconv('UTF-8','TIS-620', $_POST['NickName']);
    $DayCost = iconv('UTF-8','TIS-620', $_POST['DayCost']);
    $Religion = iconv('UTF-8','TIS-620', $_POST['Religion']);
    $Address = iconv('UTF-8','TIS-620', $_POST['Address']);
    $Finance = iconv('UTF-8','TIS-620', $_POST['Finance']);
    $Finance = iconv('UTF-8','TIS-620', $_POST['Finance']);
    $ChoiceBank = iconv('UTF-8','TIS-620', $_POST['ChoiceBank']);
    $BankBranch = iconv('UTF-8','TIS-620', $_POST['BankBranch']);
    $Status = iconv('UTF-8','TIS-620', $_POST['Status']);
    $Blacklist = iconv('UTF-8','TIS-620', $_POST['Blacklist']);
    $DateOpen = new DateTime($DateOpen);
    $DateOpen = $DateOpen->format('Y-m-d');
    $DateBirthDay = new DateTime($_POST['DateBirthDay']);
    $DateBirthDay = $DateBirthDay->format('Y-m-d');
    if(!empty($_POST['DateBirthBlacklist'])) {
        $DateBlacklist = new DateTime($_POST['DateBirthBlacklist']);
        $DateBlacklist = $DateBlacklist->format('Y-m-d');
    }
    $Card = $_POST['dataCard'];
    $PassPort = $_POST['dataPass'];
    $Site = $_POST['Site'];
    $Position = $_POST['Position'];
    $Groups = $_POST['Groups'];
    $LivingExpenses = $_POST['LivingExpenses'];
    $Money = $_POST['Money'];
    if($Money == '00') {
        $Money = '0';
    }
    $Allowance = $_POST['Allowance'];
    $AllowanceDisaster = $_POST['AllowanceDisaster'];
    $AllowanceSafety = $_POST['AllowanceSafety'];
    $SpecialAllowance = $_POST['SpecialAllowance'];
    $Y = $_POST['AgeWork-Y'];
    $M = $_POST['AgeWork-M'];
    $D = $_POST['AgeWork-D'];
    $Age = iconv('UTF-8','TIS-620', $_POST['Age']);
    $Width = $_POST['Width'];
    $Height = $_POST['Height'];
    $Blood = $_POST['Blood'];
    $Bank = $_POST['Bank'];
    $Religion = $_POST['Religion'];
    $Tel = $_POST['Tel'];
    $Mobile = $_POST['Mobile'];
    $AccountNumber = $_POST['AccountNumber'];
    $CashCard = $_POST['CashCard'];
    $Pic = iconv('UTF-8','TIS-620', $_FILES['filUpload']["name"]);
    $Email = $_POST['Email'];
    $Society = $_POST['Society'];
    $Hos_id = $_POST['Hos_id'];
    $Inform = iconv('UTF-8','TIS-620', $_POST['Inform']);
    $Notice = iconv('UTF-8','TIS-620', $_POST['Notice']);
    if($Society == '') {
        $Society = '0';
    }
    if($Hos_id == '') {
        $Hos_id = '1';
    }

    if($_POST['Em_ID'] == '') {
        $sql_id = " SELECT Em_ID FROM [HRP].[dbo].[Employees] where Em_Card = '". $Card ."' ";
        $query_id = mssql_query($sql_id);
        $row_id = mssql_fetch_array($query_id);

        $Em_ID = $row_id['Em_ID'];
    } else {
        $Em_ID = $_POST['Em_ID'];
    }

    if($Y == '') {
        $Y = 0;
    }
    if($M == '') {
        $M = 0;
    }
    if($D == '') {
        $D = 0;
    }
    $work_dates = $Y.'-'.$M.'-'.$D;
    
    $day = new DateTime();
    $explodeDay = $day->format('Y-m-d');

    $sql_max = "SELECT MAX(Em_ID) AS Max FROM [HRP].[dbo].[Employees]";
    $query_max = mssql_query($sql_max);
    $row_max = mssql_fetch_array($query_max);
    $Code = $row_max['Max'] + 1;
    // echo $sql_max;

    $sql_click = "SELECT Em_ID FROM [HRP].[dbo].[Employees] WHERE Em_ID = '". $Em_ID ."' ";

    $query = mssql_query($sql_click);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    $_FILES["filUpload"]["name"] = iconv('UTF-8','TIS-620', $_FILES["filUpload"]["name"]);
    $destination_path = getcwd().DIRECTORY_SEPARATOR.'EmployeePicture'.DIRECTORY_SEPARATOR;
    $target_path = $destination_path . basename($_FILES["filUpload"]["name"]);
    $ext = strtolower(pathinfo($_FILES["filUpload"]["name"], PATHINFO_EXTENSION));
    $extension = array('jpg','jpeg','png');

    if($num != 0) {
        if($Pic == ''){
                $sql_edit = "UPDATE 
                                [HRP].[dbo].[Employees]
                            SET
                                Em_Card = '". $Card ."',
                                Em_People = '". $People ."',
                                Em_Fullname = '". $Fullname ."',
                                Em_Lastname = '". $Lastname ."',
                                Em_NickName = '". $NickName ."',
                                Em_DateOpen = '". $DateOpen ."',
                                Em_DateBirthDay = '". $DateBirthDay ."',
                                Em_Age = '". $Age ."',
                                Em_DayCost = '". $DayCost ."',
                                Em_ChoiceBank = '". $ChoiceBank ."',
                                Bank_ID = '". $Bank ."',
                                Em_BankBranch = '". $BankBranch ."',
                                Em_AccountNumber = '". $AccountNumber ."',
                                Em_CashCard = '". $CashCard ."',
                                Em_Money = '". $Money ."',
                                Em_LivingExpenses = '". $LivingExpenses ."',
                                Em_Allowance = '". $Allowance ."',
                                Em_AllowanceDisaster = '". $AllowanceDisaster ."',
                                Em_AllowanceSafety = '". $AllowanceSafety ."',
                                Em_SpecialAllowance = '". $SpecialAllowance ."',
                                Em_Width = '". $Width ."',
                                Em_Height = '". $Height ."',
                                Em_Address = '". $Address ."',
                                Em_Tel = '". $Tel ."',
                                Em_Mobile = '". $Mobile ."',
                                Em_Email = '". $Email ."',
                                Em_Titel = '". $Titel ."',
                                Em_Status = '". $Status ."',
                                Em_Status_Reason = '". $Blacklist ."',
                                Em_DateBlacklist = '". $DateBlacklist ."',
                                Site_ID = '". $Site ."',
                                Group_ID = '". $Groups ."',
                                Pos_ID = '". $Position ."',
                                Blood_ID = '". $Blood ."',
                                Re_ID = '". $Religion ."',
                                Socie = '". $Society ."',
                                Em_Work_Date = '". $work_dates ."',
                                hos_id = '". $Hos_id ."',
                                Em_Inform = '". $Inform ."',
                                Em_Notice = '". $Notice ."'
                            WHERE
                                Em_ID = '". $Em_ID ."' ";

                mssql_query($sql_edit);
                // echo $sql_edit;
                // exit("<script>window.location='../Employee.php';</script>");
        } else {
            if($_FILES["filUpload"]["name"] == in_array($ext, $extension)){
                // echo $_FILES["filUpload"]["name"];
                if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],$target_path)) {
                    $sql_edit = "UPDATE
                                    [HRP].[dbo].[Employees]
                                SET
                                    Em_Card = '". $Card ."',
                                    Em_People = '". $People ."',
                                    Em_Fullname = '". $Fullname ."',
                                    Em_Lastname = '". $Lastname ."',
                                    Em_NickName = '". $NickName ."',
                                    Em_DateOpen = '". $DateOpen ."',
                                    Em_DateBirthDay = '". $DateBirthDay ."',
                                    Em_Pic = '". $Pic ."',
                                    Em_Age = '". $Age ."',
                                    Em_DayCost = '". $DayCost ."',
                                    Em_ChoiceBank = '". $ChoiceBank ."',
                                    Bank_ID = '". $Bank ."',
                                    Em_BankBranch = '". $BankBranch ."',
                                    Em_AccountNumber = '". $AccountNumber ."',
                                    Em_CashCard = '". $CashCard ."',
                                    Em_Money = '". $Money ."',
                                    Em_LivingExpenses = '". $LivingExpenses ."',
                                    Em_Allowance = '". $Allowance ."',
                                    Em_AllowanceDisaster = '". $AllowanceDisaster ."',
                                    Em_AllowanceSafety = '". $AllowanceSafety ."',
                                    Em_SpecialAllowance = '". $SpecialAllowance ."',
                                    Em_Width = '". $Width ."',
                                    Em_Height = '". $Height ."',
                                    Em_Address = '". $Address ."',
                                    Em_Tel = '". $Tel ."',
                                    Em_Mobile = '". $Mobile ."',
                                    Em_Email = '". $Email ."',
                                    Em_Titel = '". $Titel ."',
                                    Em_Status = '". $Status ."',
                                    Em_Status_Reason = '". $Blacklist ."',
                                    Em_DateBlacklist = '". $DateBlacklist ."',
                                    Site_ID = '". $Site ."',
                                    Group_ID = '". $Groups ."',
                                    Pos_ID = '". $Position ."',
                                    Blood_ID = '". $Blood ."',
                                    Re_ID = '". $Religion ."',
                                    Socie = '". $Society ."',
                                    Em_Work_Date = '". $work_dates ."',
                                    hos_id = '". $Hos_id ."',
                                    Em_Inform = '". $Inform ."',
                                    Em_Notice = '". $Notice ."'
                                WHERE
                                    Em_ID = '". $Em_ID. "' ";

                    mssql_query($sql_edit);
                    // echo $sql_edit;
                    // exit("<script>window.location='../Employee.php';</script>");
                }
            }
        }

        $sql_check_update = " SELECT * FROM [HRP].[dbo].[MoneyEmployeeLog] WHERE Em_ID = '". $Em_ID ."' AND Year = '".$explodeDay."' ";
        $query_check_update = mssql_query($sql_check_update);
        $num_check_update = mssql_num_rows($query_check_update);

        if($num_check_update != '0') {
            $sql_log_update = "UPDATE [HRP].[dbo].[MoneyEmployeeLog] SET
                                    Moneies = '".$Money."', Year = '".$explodeDay."'
                                WHERE
                                    Em_ID = '". $Em_ID. "' ";
            mssql_query($sql_log_update);
            // echo $sql_log_update;
        } else {
            $sql_log_update = "INSERT INTO [HRP].[dbo].[MoneyEmployeeLog] (Em_ID, Moneies, Year) VALUES ('$Em_ID', '$Money' , '$explodeDay') ";
            mssql_query($sql_log_update);
            // echo $sql_log_update;
        }
    } else {
        if($Pic == '') {
            $sql_insert = "INSERT INTO [HRP].[dbo].[Employees] 
                            (Em_Card,Em_People,Em_Fullname,Em_Lastname,Em_NickName,Em_DateOpen,Em_DateBirthDay,Em_Age,Em_DayCost,Em_ChoiceBank,Bank_ID,Em_BankBranch,Em_AccountNumber,Em_Money,Em_LivingExpenses,Em_Allowance,Em_AllowanceDisaster,Em_AllowanceSafety,Em_SpecialAllowance,Em_Width,Em_Height,Em_Address,Em_Tel,Em_Mobile,Em_Email,Em_Titel,Em_Status,Em_Status_Reason,Em_DateBlacklist,Site_ID,Group_ID,Pos_ID,Blood_ID,Re_ID,Em_Work_Date,TimePlan_ID,Socie,Em_CashCard,hos_id,Em_Inform,Em_Notice)
                            VALUES
                            ('$Card','$People','$Fullname','$Lastname','$NickName','$DateOpen','$DateBirthDay','$Age','$DayCost','$ChoiceBank','$Bank','$BankBranch','$AccountNumber','$Money','$LivingExpenses','$Allowance','$AllowanceDisaster','$AllowanceSafety','$SpecialAllowance','$Width','$Height','$Address','$Tel','$Mobile','$Email','$Titel','$Status','$Blacklist','$DateBlacklist','$Site','$Groups','$Position','$Blood','$Religion','$work_dates','1','$Society','$CashCard','$Hos_id','$Inform','$Notice')";

            mssql_query($sql_insert);
            // echo $sql_insert;
        } else {
            if($_FILES["filUpload"]["name"] == in_array($ext, $extension)){
                if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],$target_path)) {
                    $sql_insert = "INSERT INTO [HRP].[dbo].[Employees] 
                                (Em_Card,Em_People,Em_Fullname,Em_Lastname,Em_NickName,Em_DateOpen,Em_DateBirthDay,Em_Pic,Em_Age,Em_DayCost,Em_ChoiceBank,Bank_ID,Em_BankBranch,Em_AccountNumber,Em_Money,Em_LivingExpenses,Em_Allowance,Em_AllowanceDisaster,Em_AllowanceSafety,Em_SpecialAllowance,Em_Width,Em_Height,Em_Address,Em_Tel,Em_Mobile,Em_Email,Em_Titel,Em_Status,Em_Status_Reason,Em_DateBlacklist,Site_ID,Group_ID,Pos_ID,Blood_ID,Re_ID,Em_Work_Date,TimePlan_ID,Em_CashCard,hos_id,Em_Inform,Em_Notice)
                                VALUES
                                ('$Card','$People','$Fullname','$Lastname','$NickName','$DateOpen','$DateBirthDay','$Pic','$Age','$DayCost','$ChoiceBank','$Bank','$BankBranch','$AccountNumber','$Money','$LivingExpenses','$Allowance','$AllowanceDisaster','$AllowanceSafety','$SpecialAllowance','$Width','$Height','$Address','$Tel','$Mobile','$Email','$Titel','$Status','$Blacklist','$DateBlacklist','$Site','$Groups','$Position','$Blood','$Religion','$work_dates','1','$CashCard','$Hos_id','$Inform','$Notice')";

                    mssql_query($sql_insert);
                    // echo $sql_insert;
                }
            }
        }

        $sql_log = "INSERT INTO [HRP].[dbo].[MoneyEmployeeLog] (Em_ID, Moneies, Year) VALUES ('$Code', '$Money' , '$explodeDay') ";
        mssql_query($sql_log);
    }
?>
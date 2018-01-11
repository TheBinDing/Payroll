<?php
	@session_start();
    include("../inc/connect.php");
    $FingerID = $_POST['FingerID'];
    $FingerCode = iconv('UTF-8','TIS-620', $_POST['FingerCode']);
    $FingerName = iconv('UTF-8','TIS-620', $_POST['FingerName']);
    $Band = iconv('UTF-8','TIS-620', $_POST['Band']);
    $Model = iconv('UTF-8','TIS-620', $_POST['Model']);
    $Discription = iconv('UTF-8','TIS-620', $_POST['Discription']);
    $Site_ID = $_POST['Site'];
    $Status = $_POST['Status'];
    $Pic = $_FILES['filUpload']["name"];

    echo $Pic;

    $sql_click = "SELECT FingerID FROM [HRP].[dbo].[FingerScanner] WHERE FingerID = '". $FingerID ."' ";
    $query = mssql_query($sql_click);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    $destination_path = getcwd().DIRECTORY_SEPARATOR.'FingerPicture'.DIRECTORY_SEPARATOR;
    $target_path = $destination_path . basename($_FILES["filUpload"]["name"]);
    $ext = strtolower(pathinfo($_FILES["filUpload"]["name"], PATHINFO_EXTENSION));
    $extension = array('jpg','jpeg','png');

    if($num != 0) {
        if($Pic == ''){
                $sql_edit = "UPDATE
                                [HRP].[dbo].[FingerScanner]
                            SET
                                FingerCode = '". $FingerCode ."',
                                FingerName = '". $FingerName ."',
                                Band = '". $Band ."',
                                Model = '". $Model ."',
                                Discription = '". $Discription ."',
                                Site_ID = '". $Site_ID ."',
                                Status_ID = '".$Status."'
                            WHERE
                                FingerID = '". $FingerID ."' ";

                mssql_query($sql_edit);
                    exit("<script>window.location='../scan.php';</script>");
        } else {
            if($_FILES["filUpload"]["name"] == in_array($ext, $extension)){
                if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],$target_path)) {
                    $sql_edit = "UPDATE
                                    [HRP].[dbo].[FingerScanner]
                                SET
                                    FingerCode = '". $FingerCode ."',
                                    FingerName = '". $FingerName ."',
                                    Band = '". $Band ."',
                                    Model = '". $Model ."',
                                    Discription = '". $Discription ."',
                                    Site_ID = '". $Site_ID ."',
                                    Finger_Pic = '". $Pic ."',
                                    Status_ID = '".$Status."'
                                WHERE
                                    FingerID = '". $FingerID ."' ";

                    mssql_query($sql_edit);
                    exit("<script>window.location='../scan.php';</script>");
                }
            }
        }
    } else {
        if($Pic == '') {
            $sql_insert = "INSERT INTO [HRP].[dbo].[FingerScanner] (FingerCode, FingerName, Band, Model, Discription, Site_ID, Status_ID) 
            VALUES ('".$FingerCode."', '".$FingerName."', '".$Band."', '".$Model."', '".$Discription."', '".$Site_ID."', '".$Status."')";

            mssql_query($sql_insert);
            exit("<script>window.location='../scan.php';</script>");
        } else {
            if($_FILES["filUpload"]["name"] == in_array($ext, $extension)){
                if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],$target_path)) {
                    $sql_insert = "INSERT INTO [HRP].[dbo].[FingerScanner] (FingerCode, FingerName, Band, Model, Discription, Site_ID, Finger_Pic, Status_ID) 
                    VALUES ('".$FingerCode."', '".$FingerName."', '".$Band."', '".$Model."', '".$Discription."', '".$Site_ID."', '".$Pic."', '".$Status."')";

                    mssql_query($sql_insert);
                    exit("<script>window.location='../scan.php';</script>");
                }
            }
        }   
    }
?>
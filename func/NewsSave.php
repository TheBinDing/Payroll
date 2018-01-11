<?php
    @session_start();
    require("../inc/connect.php");

    $name = iconv('UTF-8','TIS-620', $_POST['name']);
    $file = iconv('UTF-8','TIS-620', $_FILES['filUpload']['name']);
    $fileD = iconv('UTF-8','TIS-620', $_POST['fileD']);
    $size = $_FILES['filUpload']['size'];
    $present = $_SESSION['SuperName'];
    $date = new datetime();
    $date = $date->format('d-m-Y');

    $n_ids = $_POST['n_id'];

    if($size > 5242880) {
        exit("<script>alert('File size not over 5 MB');history.back()</script>");
    }

    $newsCheck = "SELECT
                        n_id
                    FROM
                        [HRP].[dbo].[News]
                    WHERE
                        n_id = '". $n_ids ."' ";
    $queryCheck = mssql_query($newsCheck);
    $numCheck = mssql_num_rows($queryCheck);

	$row = mssql_fetch_assoc($queryCheck);

    $destination_path = pathinfo(getcwd(), 3).DIRECTORY_SEPARATOR.'File'.DIRECTORY_SEPARATOR.'News'.DIRECTORY_SEPARATOR;
    $target_path = $destination_path . basename($file);
    $target_path_delete = $destination_path . basename($fileD);
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if($numCheck != 0) {
        if(empty($file)) {
            $newsUpdate = "UPDATE
                                [HRP].[dbo].[News]
                            SET
                                n_name = '". $name ."',
                                n_present = '". $present ."',
                                n_update = '". $date ."'
							WHERE
								n_id = '". $row['n_id'] ."' ";

            mssql_query($newsUpdate);
            // echo $newsUpdate;
        } else {
            @unlink($target_path_delete);
            move_uploaded_file($_FILES["filUpload"]["tmp_name"],$target_path);

            $newsUpdate = "UPDATE
                                [HRP].[dbo].[News]
                            SET
                                n_name = '". $name ."',
                                n_file = '".  $file ."',
                                n_present = '". $present ."',
                                n_update = '". $date ."'
							WHERE
								n_id = '". $row['n_id'] ."' ";

            mssql_query($newsUpdate);
            // echo $newsUpdate;
        }
    } else {
        move_uploaded_file($_FILES["filUpload"]["tmp_name"],$target_path);

        $newsInsert = "INSERT INTO [HRP].[dbo].[News]
                        (n_name, n_file, n_present, n_create, n_update)
                        VALUES
                        ('". $name ."', '". $file ."', '". $present ."', '". $date ."', '". $date ."') ";

        mssql_query($newsInsert);
        // echo $newsInsert;
    }
    exit("<script>window.location='../News.php';</script>");
?>
<?php
    include("../inc/connect.php");
    $pass = $_POST['password'];
    $confirm = $_POST['confirm'];
    $email = $_POST['mail'];
    $name = iconv('UTF-8','TIS-620', $_POST['name']);
    $Pic = iconv('UTF-8','TIS-620', $_FILES['filUpload']["name"]);

	// echo $pass.'-'.$confirm.'<br>';

	if(!empty($pass)) {
		if($pass<>$confirm) {
			// exit("<script>alert('Password not match');history.back()</script>");
		} else {
			$pass = base64_encode($pass);
		}
	} else if(empty($pass)) {
		$sql_pass = "SELECT m_pass FROM [HRP].[dbo].[Users] WHERE m_user = '". $name ."' ";
		$query_pass = mssql_query($sql_pass);
		$row_pass = mssql_fetch_assoc($query_pass);

		$pass = $row_pass['m_pass'];
	}

    $_FILES["filUpload"]["name"] = iconv('UTF-8','TIS-620', $_FILES["filUpload"]["name"]);
    $destination_path = getcwd().DIRECTORY_SEPARATOR.'EmployeePicture'.DIRECTORY_SEPARATOR;

    $destination_path = pathinfo(getcwd(), 3).DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;
    $target_path = $destination_path . basename($_FILES["filUpload"]["name"]);
    $ext = strtolower(pathinfo($_FILES["filUpload"]["name"], PATHINFO_EXTENSION));
    $extension = array('jpg','jpeg','png');

    if($Pic == ''){
        $sql = "UPDATE
                    [HRP].[dbo].[Users]
                SET
                    m_pass = '". $pass ."',
                    m_email = '". $email ."'
                WHERE
                    m_user = '". $name ."' ";

        mssql_query($sql);
        // echo $sql;
    } else {
        if($_FILES["filUpload"]["name"] == in_array($ext, $extension)){
            if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],$target_path)) {
                $sql = "UPDATE
                            [HRP].[dbo].[Users]
                        SET ";
				if($pass != '') {
					$sql .= " m_pass = '". $pass ."', ";
				}
				if($email != '') {
					$sql .= " m_email = '". $email ."', ";
				}
                $sql .= " m_pic = '". $Pic ."'
                        WHERE
                            m_user = '". $name ."' ";

                mssql_query($sql);
                // echo $sql;
            }
        }
    }
?>
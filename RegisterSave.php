<?php
    include("inc/connect.php");

    $user = $_POST['username'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm'];
    $name = iconv('UTF-8', 'TIS-620', $_POST['name']);
    $email = $_POST['email'];
    $choise = $_POST['choise'];
    $status = $_POST['status'];

    $mids = $_POST['mids'];

    if($choise == 'Admin') {
        $rule = '1';
        $_POST['Site'] = '1';
        $site = '1';
    }
    if($choise == 'HR') {
        $rule = '2';
        $_POST['Site'] = '1';
        $site = '1';
    }
    if($choise == 'Personal') {
        $rule = '3';
    }
    if($choise == 'Report') {
        $rule = '4';
        $_POST['Site'] = '0';
        $site = '0';
    }

    if(empty($mids)) {
        if($pass<>$confirm) {
            exit("<script>alert('Password not match');history.back()</script>");
        }
    } else {
        if(!empty($pass)) {
            if($pass<>$confirm) {
                exit("<script>alert('Password not match');history.back()</script>");
            } else {
                $pass = base64_encode($pass);
            }
        }
        if(empty($pass)) {
            $passLoad = "SELECT
                            CAST(m_pass as Text) AS m_pass
                        FROM
                            [HRP].[dbo].[Users]
                        WHERE
                            m_id = '". $mids ."' ";

            $queryLoadp = mssql_query($passLoad);
            $rowLoadp = mssql_fetch_assoc($queryLoadp);

            $pass = $rowLoadp['m_pass'];
        }
    }

    $sqlc = "SELECT CAST(m_user as Text) AS m_user FROM [HRP].[dbo].[Users] WHERE m_id = '". $mids ."' ";

    $queryc = mssql_query($sqlc);
    $numc = mssql_num_rows($queryc);

    $sqlm = "SELECT MAX(m_id) AS Num FROM [HRP].[dbo].[Users] ";
    $querym = mssql_query($sqlm);
    $rowm = mssql_fetch_array($querym);
    $Number = $rowm['Num']+1;

    $aa = is_array($_POST['Site']);

    if($aa) {
        foreach ($_POST['Site'] as $key => $value) {
            if($key == 0) {
                $s = $value;
            } else {
                $s = $s.','.$value;
            }
        }
    } else {
        $s = $_POST['Site'];
    }

    if($status == 0) {
        $s = '';
    }

    if($numc==0) {
        $pass = base64_encode($pass);
        $sql = "INSERT INTO
                    [HRP].[dbo].[Users]
                (m_id, m_user, m_pass, m_rule, P_ID, m_name, m_email, m_site, m_status)
                VALUES
                ('$Number', '$user', '$pass', '$rule', '1', '$name', '$email', '$s', '1') ";

        mssql_query($sql);
        // echo $sql;                
		exit("<script>window.location='user.php';</script>");
    } else {
        $userUpdate = "UPDATE
                            [HRP].[dbo].[Users]
                        SET
                            m_user = '". $user ."',
                            m_pass = '". $pass ."',
                            m_rule = '". $rule ."',
                            m_name = '". $name ."',
                            m_email = '". $email ."',
                            m_site = '". $s ."',
                            m_status = '". $status ."'
                        WHERE
                            m_id = '". $mids ."' ";

        mssql_query($userUpdate);
        // echo $userUpdate;
        exit("<script>window.location='user.php';</script>");
    }
?>
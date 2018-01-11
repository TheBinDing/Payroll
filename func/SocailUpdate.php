<?php
    require("../inc/connect.php");
    $val = $_POST['So'];

    $update = "UPDATE
                [HRP].[dbo].[SocialSecurity]
            SET
                Social_Number = '". $val ."'
            WHERE
                Social_ID = '1' ";

    mssql_query($update);
?>
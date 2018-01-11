<?php
    $pro = "SELECT
                m_id,
                CAST(m_user as text) as users,
                CAST(m_name as text) as name,
                m_email as mails,
                m_pic as pic
            FROM
                [HRP].[dbo].[Users]
            WHERE
                m_id = '". $_SESSION['user_id'] ."' ";
    $query = mssql_query($pro);
    $row = mssql_fetch_assoc($query);
?>
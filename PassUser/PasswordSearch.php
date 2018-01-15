<?php
      $sql = "SELECT
                  m_id,
                  CAST(m_user AS Text) AS users,
                  CAST(m_pass AS Text) AS pass,
                  CAST(m_name AS Text) AS name,
                  m_email as mails
            FROM
                  [HRP].[dbo].[Users]
            WHERE
                  m_status = '1'
            ORDER BY
                  m_id ";

      $query = mssql_query($sql);
      $num = mssql_num_rows($query);
?>
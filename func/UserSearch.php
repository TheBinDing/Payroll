<?php
    $sql_Search = " SELECT
                        m_id AS id,
                        CAST(m_name as text) AS name,
                        CAST(m_user as text) AS users,
                        m_rule AS rules,
                        CAST(m_email as text) AS email,
                        CAST(m_pic as text) AS pic,
                        m_status as status,
                        CAST(m_site as text) as m_site
                    FROM
                        [HRP].[dbo].[Users]
                    WHERE
                        m_id != '1'
                        AND m_id != '2'
                        AND m_id != '3'
					ORDER BY
						m_id ASC";

    $query_search = mssql_query($sql_Search);
    $num_search = mssql_num_rows($query_search);
?>
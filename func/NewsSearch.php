<?php
    $News = "SELECT
                n_id,
                CAST(n_name as Text) as name,
                CAST(n_file as Text) as files,
                CAST(n_present as Text) as present,
                CAST(n_create as Text) as creates
            FROM
                [HRP].[dbo].[News]
            ORDER BY
                n_id DESC ";

    $queryN = mssql_query($News);
    $numN = mssql_num_rows($queryN);
?>
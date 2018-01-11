<?php
    $getPeriod = $_GET['Period'];

    $date = new datetime();
    $date = $date->format('d-m-Y');
    $date_year = new datetime();
    $date_year = $date_year->format('Y');

    $daies = explode('-', $date);
    if('1'<=$daies[0] && $daies[0]<='15') {
        $sa = '01-'.$daies[1].'-'.$daies[2];
        $ea = '15-'.$daies[1].'-'.$daies[2];
    } elseif ('16'<=$daies[0] && $daies[0]<= '31') {
        $sa = '16-'.$daies[1].'-'.$daies[2];
        if(($daies[1] == '04') || ($daies[1] == '06') || ($daies[1] == '09') || ($daies[1] == '11')){
              $ea = '30-'.$daies[1].'-'.$daies[2];
        } elseif($daies[1] == '02') {
              $ea = '28-'.$daies[1].'-'.$daies[2];
        } else {
              $ea = '31-'.$daies[1].'-'.$daies[2];
        }
    }

    $period_search = "SELECT
                        Per_ID,
                        Per_StartDate,
                        Per_EndDate
                    FROM
                        [HRP].[dbo].[Periods]
                    WHERE ";
    if($getPeriod != '') {
        $period_search .= " Per_ID = '". $getPeriod ."' ";
    } else {
        $period_search .= " Per_StartDate = '". $sa ."' AND Per_EndDate = '". $ea ."' ";
    }

    $query_search = mssql_query($period_search);
    $row_search = mssql_fetch_array($query_search);

    $ss = $row_search['Per_StartDate'];
    $ee = $row_search['Per_EndDate'];

    $s = new datetime($ss);
    $s = $s->format('Y-m-d');
    $e = new datetime($ee);
    $e = $e->format('Y-m-d');

    $sql_per = "SELECT
                    Per_ID
                FROM
                    [HRP].[dbo].[Periods]
                WHERE
                    Per_StartDate = '". $ss ."'
                    AND Per_EndDate = '". $ee ."' ";

    $query_per = mssql_query($sql_per);
    $row_per = mssql_fetch_assoc($query_per);
    $per_id = $row_per['Per_ID'];
    $per_idm = $row_per['Per_ID'] - 1;

    $sql_period = "SELECT
                        Per_ID,
                        Per_StartDate,
                        Per_EndDate,
                        Per_Week
                    FROM
                        [HRP].[dbo].[Periods]
                    WHERE ";
    if($getPeriod != '') {
        $getPeriods = $getPeriod - 1;
        $sql_period .= " Per_ID >= '". $getPeriods ."' AND Per_ID != '". $getPeriod ."' ";
    } else {
        $sql_period .= " Per_ID >= '". $row_search['Per_ID'] ."' ";
    }

    $query_period = mssql_query($sql_period);
    $num_period = mssql_num_rows($query_period);

    $sql_per_id = "SELECT
                        Per_ID,
                        Per_StartDate,
                        Per_EndDate,
                        Per_Week
                    FROM
                        [HRP].[dbo].[Periods]
                    WHERE
                        Per_ID = '". $getPeriod ."' ";

    $query_per_id = mssql_query($sql_per_id);
    $num_per_id = mssql_num_rows($query_per_id);
    $row_Per_id = mssql_fetch_assoc($query_per_id);

    $preple = " SELECT
                    m_id,
                    CAST(m_user as Text) as m_user,
                    CAST(m_pass as Text) as m_pass,
                    m_rule,
                    P_ID,
                    CAST(m_name as Text) as m_name,
                    m_email,
                    CAST(m_pic as Text) as m_pic,
                    CAST(m_site as Text) as m_site,
                    m_status
                FROM
                    [HRP].[dbo].[Users]
                WHERE
                    m_status = '1'
                    AND (m_id != '1' AND m_id != '2' AND m_id != '3')
                    AND m_rule = '3'
                ORDER BY
                    m_id ASC ";

    $query_p = mssql_query($preple);
    $num_p = mssql_num_rows($query_p);

    $Time = "SELECT
                Date_ as DateTimes
            FROM
                [HRP].[dbo].[Datetable]
            WHERE
                Date_ BETWEEN '". $s ."' AND '". $e ."' ";

    $query_t = mssql_query($Time);
    $num_t = mssql_num_rows($query_t);
?>
<?php
	$id = $_GET['Em_ID'];
	$loadSite = "SELECT
					m_id,
					CAST(m_user as Text) as m_user,
					m_pass,
					m_rule,
					CAST(m_name as Text) as m_name,
					CAST(m_email as Text) as m_email,
					CAST(m_site as Text) as m_site,
					CAST(m_status as Text) as m_status
				FROM
					[HRP].[dbo].[Users]
				WHERE
					m_id = '". $id ."' ";

	$queryLoad = mssql_query($loadSite);
	$rowLoad = mssql_fetch_assoc($queryLoad);

	$ss = explode(',', $rowLoad['m_site']);

    foreach ($ss as $key => $value) {
        if($key == 0) {
            $wSite = " AND Site_ID != '". $value ."' ";
        } else {
            $wSite .= " AND Site_ID != '". $value ."' ";
        }
        if($key == 0) {
            $lSite = " Site_ID = '". $value ."' ";
        } else {
            $lSite .= " OR Site_ID = '". $value ."' ";
        }
    }
?>
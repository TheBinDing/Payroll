<?php
	@session_start();
    require("../inc/connect.php");
    $Name = iconv('UTF-8','TIS-620', $_POST['Group_Name']);
    $Site_ID = $_POST['Site_ID'];
    $Group_ID = $_POST['Group_ID'];

    // echo $Name.'-'.$Site_ID.'-'.$Group_ID;
    $sql_site = "SELECT
                    CAST(m_site as Text) as m_site
                FROM
                    [HRP].[dbo].[Users]
                where
                    m_name = '". $_SESSION['SuperName'] ."' ";

    $query_site = mssql_query($sql_site);
	$row_site = mssql_fetch_array($query_site);

    $Sites = explode(',', $row_site['m_site']);

    $sql_click = "SELECT Group_ID FROM [HRP].[dbo].[Group] WHERE Group_ID = '".$Group_ID."' ";
    // echo $sql_click;
    $query = mssql_query($sql_click);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

	if($_SESSION['Rule'] == '2') {
		if($num != 0) {
			$Site_Admin = $_SESSION['SuperSite'];
			$sql_edit = "UPDATE
							[HRP].[dbo].[Group]
						SET
							Group_Name = '". $Name ."',
							Site_ID = '". $Site_Admin ."'
						WHERE
							Group_ID = '". $Group_ID ."' ";

			mssql_query($sql_edit);
			// echo $sql_edit;
		} else {
			$Site_Admin = $_SESSION['SuperSite'];
			$sql_click_site = "SELECT Group_ID FROM [HRP].[dbo].[Group] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' AND Group_Name = '". $Name ."' ";
			$query_click_site = mssql_query($sql_click_site);
			$num_click_site = mssql_num_rows($query_click_site);

			if($num_click_site == 0) {
				$sql_insert = "insert into [HRP].[dbo].[Group] (Group_Name, Site_ID) VALUES('$Name', '$Site_Admin')";

				mssql_query($sql_insert);
				// echo $sql_insert.'<br>';
			}
		}
	} else {
		if($num != 0) {
			$sql_edit = "UPDATE [HRP].[dbo].[Group] SET
						Group_Name = '". $Name ."',
						Site_ID = '". $Site_ID ."'
						WHERE Group_ID = '". $Group_ID ."' ";
		
			mssql_query($sql_edit);
			// echo $sql_edit;
			foreach ($Sites as $key => $value) {
				$sql_click_site = "SELECT Group_ID FROM [HRP].[dbo].[Group] WHERE Site_ID = '".$value."' AND Group_Name = '". $Name ."' ";
				$query_click_site = mssql_query($sql_click_site);
				$num_click_site = mssql_num_rows($query_click_site);

				if($num_click_site == 0) {
					$sql_insert = "insert into [HRP].[dbo].[Group] (Group_Name, Site_ID) VALUES('$Name', '$value')";

					mssql_query($sql_insert);
					// echo $sql_insert.'<br>';
				}
			}
		} else {
			foreach ($Sites as $key => $value) {
				$sql_click_site = "SELECT Group_ID FROM [HRP].[dbo].[Group] WHERE Site_ID = '".$value."' AND Group_Name = '". $Name ."' ";
				$query_click_site = mssql_query($sql_click_site);
				$num_click_site = mssql_num_rows($query_click_site);

				if($num_click_site == 0) {
					$sql_insert = "insert into [HRP].[dbo].[Group] (Group_Name, Site_ID) VALUES('$Name', '$value')";

					mssql_query($sql_insert);
					// echo $sql_insert.'<br>';
				}
			}
		}
	}
?>
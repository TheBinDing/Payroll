<?php
	@session_start();
    include("../inc/connect.php");
	
	$sql = "SELECT
				CAST(p.Pos_Name as Text) AS LongName
			FROM
				[HRP].[dbo].[Position] p inner join
				[HRP].[dbo].[Employees] e on p.Pos_ID = e.Pos_ID
			WHERE
				e.Em_ID = '20' ";

	$query = mssql_query($sql);
	$row = mssql_fetch_assoc($query);
	echo $row['LongName'];
?>
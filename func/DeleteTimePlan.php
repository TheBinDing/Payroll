<?php
	@session_start();
    require("../inc/connect.php");

	$id = $_GET['Em_ID'];
	$Plan = $_GET['Plan'];

	$sql = "UPDATE [HRP].[dbo].[Employees] SET TimePlan_ID = '1' WHERE Em_ID = '". $id ."' ";
	mssql_query($sql);

	exit("<script>window.location='../PlanPeople.php?Check=2&Plan=$Plan';</script>");
?>
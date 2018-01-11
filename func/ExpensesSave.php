<?php
	@session_start();
    require("../inc/connect.php");

    if(!empty($_POST['Price1'])) {
        $item = '1';
        $price = $_POST['Price1'];

        $name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
        $site = $_POST['Site'];
        $period = $_POST['Period'];
        $num = '1';
        $status = '0';

        $date_now = new datetime();
        $Year = $date_now->format('Y');
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_insert_list = "INSERT INTO
                            [HRP].[dbo].[Item_List]
                        (List_Num, List_Price, List_Status, Em_ID, Item_ID, Per_ID, List_Date, List_Period, Site_ID, List_Create, List_Year)
                        VALUES
                        ('". $num ."', '". $price ."', '". $status ."', '". $name ."', '". $item ."', '". $period ."', '". $date_now ."', '', '".$site."', '". $date_now ."', '". $Year ."') ";

        mssql_query($sql_insert_list);
        // echo $sql_insert_list.'<br>';
    }
    if(!empty($_POST['Price2'])) {
        $item = '2';
        $price = $_POST['Price2'];

        $name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
        $site = $_POST['Site'];
        $period = $_POST['Period'];
        $num = '1';
        $status = '0';

        $date_now = new datetime();
        $Year = $date_now->format('Y');
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_insert_list = "INSERT INTO
                            [HRP].[dbo].[Item_List]
                        (List_Num, List_Price, List_Status, Em_ID, Item_ID, Per_ID, List_Date, List_Period, Site_ID, List_Create, List_Year)
                        VALUES
                        ('". $num ."', '". $price ."', '". $status ."', '". $name ."', '". $item ."', '". $period ."', '". $date_now ."', '', '".$site."', '". $date_now ."', '". $Year ."') ";

        mssql_query($sql_insert_list);
        // echo $sql_insert_list.'<br>';
    }
    if(!empty($_POST['Price3'])) {
        $item = '3';
        $price = $_POST['Price3'];

        $name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
        $site = $_POST['Site'];
        $period = $_POST['Period'];
        $num = '1';
        $status = '0';

        $date_now = new datetime();
        $Year = $date_now->format('Y');
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_insert_list = "INSERT INTO
                            [HRP].[dbo].[Item_List]
                        (List_Num, List_Price, List_Status, Em_ID, Item_ID, Per_ID, List_Date, List_Period, Site_ID, List_Create, List_Year)
                        VALUES
                        ('". $num ."', '". $price ."', '". $status ."', '". $name ."', '". $item ."', '". $period ."', '". $date_now ."', '', '".$site."', '". $date_now ."', '". $Year ."') ";

        mssql_query($sql_insert_list);
        // echo $sql_insert_list.'<br>';
    }
    if(!empty($_POST['Price4'])) {
        $item = '4';
        $price = $_POST['Price4'];

        $name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
        $site = $_POST['Site'];
        $period = $_POST['Period'];
        $num = '1';
        $status = '0';

        $date_now = new datetime();
        $Year = $date_now->format('Y');
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_insert_list = "INSERT INTO
                            [HRP].[dbo].[Item_List]
                        (List_Num, List_Price, List_Status, Em_ID, Item_ID, Per_ID, List_Date, List_Period, Site_ID, List_Create, List_Year)
                        VALUES
                        ('". $num ."', '". $price ."', '". $status ."', '". $name ."', '". $item ."', '". $period ."', '". $date_now ."', '', '".$site."', '". $date_now ."', '". $Year ."') ";

        mssql_query($sql_insert_list);
        // echo $site.'-'.$sql_insert_list.'<br>';
    }
    if(!empty($_POST['Price5'])) {
        $item = '5';
        $price = $_POST['Price5'];

        $name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
        $site = $_POST['Site'];
        $period = $_POST['Period'];
        $num = '1';
        $status = '0';

        $date_now = new datetime();
        $Year = $date_now->format('Y');
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_insert_list = "INSERT INTO
                            [HRP].[dbo].[Item_List]
                        (List_Num, List_Price, List_Status, Em_ID, Item_ID, Per_ID, List_Date, List_Period, Site_ID, List_Create, List_Year)
                        VALUES
                        ('". $num ."', '". $price ."', '". $status ."', '". $name ."', '". $item ."', '". $period ."', '". $date_now ."', '', '".$site."', '". $date_now ."', '". $Year ."') ";

        mssql_query($sql_insert_list);
        // echo $sql_insert_list.'<br>';
    }
    if(!empty($_POST['Price6'])) {
        $item = '6';
        $price = $_POST['Price6'];

        $name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
        $site = $_POST['Site'];
        $period = $_POST['Period'];
        $num = '1';
        $status = '0';

        $date_now = new datetime();
        $Year = $date_now->format('Y');
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_insert_list = "INSERT INTO
                            [HRP].[dbo].[Item_List]
                        (List_Num, List_Price, List_Status, Em_ID, Item_ID, Per_ID, List_Date, List_Period, Site_ID, List_Create, List_Year)
                        VALUES
                        ('". $num ."', '". $price ."', '". $status ."', '". $name ."', '". $item ."', '". $period ."', '". $date_now ."', '', '".$site."', '". $date_now ."', '". $Year ."') ";

        mssql_query($sql_insert_list);
    }
    if(!empty($_POST['Price7'])) {
        $item = '7';
        $price = $_POST['Price7'];

        $name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
        $site = $_POST['Site'];
        $period = $_POST['Period'];
        $num = '1';
        $status = '0';

        $date_now = new datetime();
        $Year = $date_now->format('Y');
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_insert_list = "INSERT INTO
                            [HRP].[dbo].[Item_List]
                        (List_Num, List_Price, List_Status, Em_ID, Item_ID, Per_ID, List_Date, List_Period, Site_ID, List_Create, List_Year)
                        VALUES
                        ('". $num ."', '". $price ."', '". $status ."', '". $name ."', '". $item ."', '". $period ."', '". $date_now ."', '', '".$site."', '". $date_now ."', '". $Year ."') ";

        mssql_query($sql_insert_list);
        // echo $sql_insert_list.'<br>';
    }
    if(!empty($_POST['Price8'])) {
        $item = '8';
        $price = $_POST['Price8'];
        $remark = $_POST['Remark8'];

        $name = iconv('UTF-8', 'TIS-620', $_POST['Name']);
        $site = $_POST['Site'];
        $period = $_POST['Period'];
        $num = '1';
        $status = '0';

        $date_now = new datetime();
        $Year = $date_now->format('Y');
        $date_now = $date_now->format('Y-m-d H:i:s');

        $sql_insert_list = "INSERT INTO
                            [HRP].[dbo].[Item_List]
                        (List_Num, List_Price, List_Status, Em_ID, Item_ID, Per_ID, Remark, List_Date, List_Period, Site_ID, List_Create, List_Year)
                        VALUES
                        ('". $num ."', '". $price ."', '". $status ."', '". $name ."', '". $item ."', '". $period ."', '". $remark ."', '". $date_now ."', '', '".$site."', '". $date_now ."', '". $Year ."') ";

        mssql_query($sql_insert_list);
		// echo $sql_insert_list;
    }
    // exit("<script>window.location='../Expenses.php';</script>");
?>
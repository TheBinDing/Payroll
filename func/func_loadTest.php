<?php
    function load_employee_list($arr)
    {
        $sql="SELECT
				Em_ID AS Em_ID,
                Em_Fullname AS Fullname,
                Em_DateOpen AS DateOpen,
                Em_DateBirthDay AS DateBirthDay,
                Em_People AS People,
                Em_Titel AS Titel,
                Em_Status AS Status,
                Em_DayCost AS DayCost,
                Em_ChoiceBank AS ChoiceBank,
                CAST(Em_BankBranch AS Text) AS BankBranch,
                Em_Age AS Age,
                /*CAST(Em_Work_Date AS Text) AS AgeWork,*/
                Em_Money AS Money,
                Em_LivingExpenses AS LivingExpenses,
                Em_Allowance AS Allowance,
                Em_AllowanceDisaster AS AllowanceDisaster,
                Em_AllowanceSafety AS AllowanceSafety,
                Em_SpecialAllowance AS SpecialAllowance,
                Em_Width AS Width,
                Em_Height AS Height,
                CAST(Em_Address AS Text) AS Address,
                Em_Tel AS Tel,
                Em_Mobile AS Mobile,
                Em_Email AS Email,
                Em_AccountNumber AS AccountNumber,
                Site_ID AS Site,
                Pos_ID AS Position,
                Group_ID AS Groups,
                Bank_ID AS Bank,
                Blood_ID AS Blood,
                Re_ID AS Religion,
                Socie AS Socie
            FROM
                [HRP].[dbo].[Employees]
            WHERE
                Em_Card = '". $arr['Card'] ."' ";

        $query = mssql_query($sql);
        $response = array();
        while ($row = mssql_fetch_array($query))
        {
            $response[] = $row;
        }

        return js_thai_encode($response);
    }

	function load_group_list($arr) {
        $sql = "SELECT
				Group_ID AS Code,
				CAST(Group_Name AS Text) AS LongName,
				Site_ID
			FROM
				[HRP].[dbo].[Group]
			WHERE
				Site_ID = '". $arr['Site'] ."' ";

        $query = mssql_query($sql);
        $response = array();
        while ($row = mssql_fetch_array($query))
        {
            $response[] = $row;
        }

        return js_thai_encode($response);
	}

    function insert_subject($arr) {
        $Date = new DateTime();
        $Date = $Date->format('Y-m-d H:i:s');
        $Subject = iconv('UTF-8','TIS-620', $arr['Subject']);
        $Detail = iconv('UTF-8','TIS-620', $arr['Detail']);

        $sql = "INSERT INTO [HRP].[dbo].[News]
                    (N_Subject, N_Description, N_Date, N_Status) VALUES
                    ('". $Subject ."', '". $Detail ."', '". $Date ."', '1') ";
        mssql_query($sql);
    }

    function js_thai_encode($data)
    {   // fix all thai elements
        if (is_array($data))
        {
            foreach($data as $a => $b)
            {
                if (is_array($data[$a]))
                {
                    $data[$a] = js_thai_encode($data[$a]);
                }
                else
                {
                    $data[$a] = iconv("tis-620","utf-8",$b);
                }
            }
        }
        else
        {
            $data =iconv("tis-620","utf-8",$data);
        }
        return $data;
    }
?>
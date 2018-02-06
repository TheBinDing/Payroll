<?php
    function sendAnnounce($arr) {
        $Site = $arr['Site'];
        $Period = $arr['Period'];

        $s = "SELECT
                CAST(Site_Name as text) as name_s,
                CAST(Site_Code as text) as code_s
            FROM
                [HRP].[dbo].[Sites]
            WHERE
                Site_ID = '". $Site ."' ";

        $q_s = mssql_query($s);
        $r_s = mssql_fetch_assoc($q_s);

        $p = "SELECT
                    Per_StartDate as Stars,
                    Per_EndDate as Ends
                FROM
                    [HRP].[dbo].[Periods]
                WHERE
                    Per_ID = '". $Period ."' ";

        $q_p = mssql_query($p);
        $r_p = mssql_fetch_assoc($q_p);

        $PS = new datetime($r_p['Stars']);
        $PS = $PS->format('d-m-Y');
        $PN = new datetime($r_p['Ends']);
        $PN = $PN->format('d-m-Y');

        $detail = 'เรียนทีม HR/ADMIN <br><br>'; // in
        $detail .= 'ช่วยตัดวีค <br>';
        $detail .= 'โครงการ : '. iconv('TIS-620','UTF-8', $r_s['name_s']) .'('. $r_s['code_s'] .') <br>'; // in
        $detail .= 'งวดวันที่ : '. $PS .' ถึง '. $PN . '<br><br><br>';
        $detail .= 'ด้วยความเคารพ <br>';
        $detail .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arr['name']; // in
        $subject = 'แจ้งการตัดวีค โครงการ : '. iconv('TIS-620','UTF-8', $r_s['name_s']) .'('. $r_s['code_s'] .')'; // out

        $mail = new PHPMailer();
        $mail->Body = $detail;
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();// Set mailer to use SMTP
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = "mail.csloxinfo.com"; // SMTP server
        $mail->Username = $arr['from']; // SMTP username
        $mail->Password = $arr['pass']; // SMTP password
        //from
        $mail->SetFrom($arr['from'], $arr['name']);   
        $mail->IsHTML(true);
        //send mail
        if($arr['send'] == 1){
            $mail->AddAddress("phiphop.po@thaipolycons.co.th");
            $mail->AddAddress("netnapit@thaipolycons.co.th");
            $mail->AddCC("aekkachon@thaipolycons.co.th");
            $mail->AddCC("katanyakit.su@thaipolycons.co.th");
        }else{
            $mail->AddAddress($arr['send']);
        }
        
        //$mail->AddReplyTo("email@yourdomain.com", "yourname");
        $mail->Subject = $subject;  
        
        if(!$mail->send()){
            // $msg = $mail->ErrorInfo;
            $msg = 0;
        }else{
            $msg = 1;
        }
        return $msg;
        // return $arr['detail'].'-'.$arr['subject'].'-'.$arr['from'].'-'.$arr['send'];
    }

    function sendCAnnounce($arr) {
        $Site = $arr['Site'];
        $Period = $arr['Period'];

        $s = "SELECT
                CAST(Site_Name as text) as name_s,
                CAST(Site_Code as text) as code_s
            FROM
                [HRP].[dbo].[Sites]
            WHERE
                Site_ID = '". $Site ."' ";

        $q_s = mssql_query($s);
        $r_s = mssql_fetch_assoc($q_s);

        $p = "SELECT
                    Per_StartDate as Stars,
                    Per_EndDate as Ends
                FROM
                    [HRP].[dbo].[Periods]
                WHERE
                    Per_ID = '". $Period ."' ";

        $q_p = mssql_query($p);
        $r_p = mssql_fetch_assoc($q_p);

        $PS = new datetime($r_p['Stars']);
        $PS = $PS->format('d-m-Y');
        $PN = new datetime($r_p['Ends']);
        $PN = $PN->format('d-m-Y');

        $detail = 'เรียนทีม HR/ADMIN <br><br>'; // in
        $detail .= 'ช่วยคืนสถานะการตัดตัดวีค <br>';
        $detail .= 'โครงการ : '. iconv('TIS-620','UTF-8', $r_s['name_s']) .'('. $r_s['code_s'] .') <br>'; // in
        $detail .= 'งวดวันที่ : '. $PS .' ถึง '. $PN . '<br><br><br>';
        $detail .= 'ด้วยความเคารพ <br>';
        $detail .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arr['name']; // in
        $subject = 'แจ้งการตัดวีค โครงการ : '. iconv('TIS-620','UTF-8', $r_s['name_s']) .'('. $r_s['code_s'] .')'; // out

        $mail = new PHPMailer();
        $mail->Body = $detail;
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();// Set mailer to use SMTP
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = "mail.csloxinfo.com"; // SMTP server
        $mail->Username = $arr['from']; // SMTP username
        $mail->Password = $arr['pass']; // SMTP password
        //from
        $mail->SetFrom($arr['from'], $arr['name']);   
        $mail->IsHTML(true);
        //send mail
        if($arr['send'] == 1){
            $mail->AddAddress("phiphop.po@thaipolycons.co.th");
            $mail->AddAddress("netnapit@thaipolycons.co.th");
            $mail->AddCC("aekkachon@thaipolycons.co.th");
            $mail->AddCC("katanyakit.su@thaipolycons.co.th");
        }else{
            $mail->AddAddress($arr['send']);
        }
        
        //$mail->AddReplyTo("email@yourdomain.com", "yourname");
        $mail->Subject = $subject;  
        
        if(!$mail->send()){
            // $msg = $mail->ErrorInfo;
            $msg = 0;
        }else{
            $msg = 1;
        }
        return $msg;
        // return $arr['detail'].'-'.$arr['subject'].'-'.$arr['from'].'-'.$arr['send'];
    }

    function load_employee_list($arr) {
        $sql="SELECT
				Em_ID AS Em_ID,
                Em_Fullname AS Fullname,
                Em_Lastname AS Lastname,
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

	function load_position_list($arr) {
		$sql = "SELECT
					CAST(p.Pos_Name as Text) AS LongName
				FROM
					[HRP].[dbo].[Position] p inner join
					[HRP].[dbo].[Employees] e on p.Pos_ID = e.Pos_ID
				WHERE
					e.Em_ID = '".$arr['Code']."' ";

		$query = mssql_query($sql);
		$row = mssql_fetch_assoc($query);

        return js_thai_encode($row);
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

    function load_year_list($arr) {
        $sql = "SELECT
                    MT_Period AS LongName,
                    MT_Period AS Code
                FROM
                    [HRP].[dbo].[MoneyTotal]
                WHERE
                    MT_Year = '". $arr['Year'] ."'
                    AND Site_ID = '". $arr['Site'] ."'
                GROUP BY
                    MT_Period ";

        $query = mssql_query($sql);
        $response = array();
        while ($row = mssql_fetch_array($query))
        {
            $response[] = $row;
        }

        return $response;
    }

    function load_news_list($arr) {
        $sql = "SELECT
                    n_id as code,
                    CAST(n_name as Text) as name,
                    CAST(n_file as Text) as files
                FROM
                    [HRP].[dbo].[News]
                WHERE
                    n_id = '". $arr['code'] ."' ";

        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        $response = $row;

        return js_thai_encode($response);
    }

    function delete_news_list($arr) {
        $sql = "SELECT
                    CAST(n_file as Text) as files
                FROM
                    [HRP].[dbo].[News]
                WHERE
                    n_id = '". $arr['code'] ."' ";

        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);

        $fileDe = js_thai_encode($row['files']);

        $destination_path = pathinfo(getcwd(), 3).DIRECTORY_SEPARATOR.'File'.DIRECTORY_SEPARATOR.'News'.DIRECTORY_SEPARATOR;
        $target_path_delete = $destination_path . basename($fileDe);

        @unlink($target_path_delete);

        $delete = "DELETE FROM [HRP].[dbo].[News] WHERE n_id = '". $arr['code'] ."' ";

        mssql_query($delete);
    }

    function load_grap_list($arr) {
        $Months = $arr['month'];
        $Year = $arr['year'];
        if(!empty($Months)) {
            $YY = new datetime();
            $Year = $YY->format('Y');
            if($Months == 1) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 2) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '28-0'.$Months.'-'.$Year;
            }
            if($Months == 3) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 4) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '30-0'.$Months.'-'.$Year;
            }
            if($Months == 5) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 6) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '30-0'.$Months.'-'.$Year;
            }
            if($Months == 7) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 8) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 9) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '30-0'.$Months.'-'.$Year;
            }
            if($Months == 10) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 11) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '30-0'.$Months.'-'.$Year;
            }
            if($Months == 12) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
        }

        $p = "SELECT Per_ID FROM [HRP].[dbo].[Periods] WHERE Per_StartDate = '". $Period_Start ."' OR Per_EndDate = '". $Period_End ."' ";
        $q = mssql_query($p);
        $n = mssql_num_rows($q);

        for($i=1;$i<=$n;$i++) {
            $r = mssql_fetch_array($q);
            if($i == 1) {
                $ps = $r['Per_ID'];
            } else {
                $pn =  $r['Per_ID'];
            }
        }

        $sql = "  SELECT
                    SUM(CAST(m.MT_TotalOT1 as int)) as OT1,
                    SUM(CAST(m.MT_TotalOT15 as int)) as OT15,
                    SUM(CAST(m.MT_TotalOT2 as int)) as OT2,
                    m.Site_ID,
                    CAST(s.Site_Name as text) as Site_Name
                FROM
                    [HRP].[dbo].[MoneyTotal] m inner join
                    [HRP].[dbo].[Sites] s on m.Site_ID = s.Site_ID
                WHERE
                    MT_Period between '". $ps ."' and '". $pn ."' ";
        if($arr['site'] != 1) {
            $sql .= " AND m.Site_ID = '". $arr['site'] ."' ";
        }
        $sql .= "GROUP BY
                    m.Site_ID,
                    s.Site_Name
                ORDER BY
                    s.Site_Name ";

        $query = mssql_query($sql);
        $response = array();
        $maxRecord = array();
        $maxRecord2 = array();
        $maxRecord3 = array();
        $maxRecord4 = array();
        while ($row = mssql_fetch_object($query))
        {
            // $response[] = js_thai_encode($row->Site_Name);
            $maxRecord[] = js_thai_encode($row->Site_Name);
            $maxRecord2[] = js_thai_encode($row->OT1);
            $maxRecord3[] = js_thai_encode($row->OT15);
            $maxRecord4[] = js_thai_encode($row->OT2);
        }
        $asss = array('One' => $maxRecord, 'Two' => $maxRecord2, 'Three' => $maxRecord3, 'Four' => $maxRecord4);
        $response[] = $asss;

        return $response;
        // return $sql;
    }

    function load_grap_price_list($arr) {
        $Months = $arr['month'];
        $Year = $arr['year'];
        if(!empty($Months)) {
            $YY = new datetime();
            $Year = $YY->format('Y');
            if($Months == 1) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 2) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '28-0'.$Months.'-'.$Year;
            }
            if($Months == 3) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 4) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '30-0'.$Months.'-'.$Year;
            }
            if($Months == 5) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 6) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '30-0'.$Months.'-'.$Year;
            }
            if($Months == 7) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 8) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 9) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '30-0'.$Months.'-'.$Year;
            }
            if($Months == 10) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
            if($Months == 11) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '30-0'.$Months.'-'.$Year;
            }
            if($Months == 12) {
                $Period_Start = '01-0'.$Months.'-'.$Year;
                $Period_End = '31-0'.$Months.'-'.$Year;
            }
        }

        $p = "SELECT Per_ID FROM [HRP].[dbo].[Periods] WHERE Per_StartDate = '". $Period_Start ."' OR Per_EndDate = '". $Period_End ."' ";
        $q = mssql_query($p);
        $n = mssql_num_rows($q);

        for($i=1;$i<=$n;$i++) {
            $r = mssql_fetch_array($q);
            if($i == 1) {
                $ps = $r['Per_ID'];
            } else {
                $pn =  $r['Per_ID'];
            }
        }

        if($arr['site'] != 1) {
            $sqlOne = "SELECT
                        SUM(CAST(l.List_Price as int)) as Price,
                        CAST(s.Site_Name as text) as Site_Name
                    FROM
                        [HRP].[dbo].[Item_List] l inner join
                        [HRP].[dbo].[Items] i on l.Item_ID = i.Item_ID inner join
                        [HRP].[dbo].[Sites] s on l.Site_ID = s.Site_ID
                    WHERE
                        l.Site_ID = '". $arr['site'] ."'
                        AND l.List_Year = '". $Year ."'
                        AND l.Per_ID between '". $ps ."' and '". $pn ."'
                        AND i.Item_Status = '1'
                    GROUP By
                        s.Site_Name
                    ORDER BY
                        s.Site_Name ";

            $queryOne = mssql_query($sqlOne);
            $objOne = mssql_fetch_object($queryOne);

            $sqlTwo = "SELECT
                        SUM(CAST(l.List_Price as int)) as Price
                    FROM
                        [HRP].[dbo].[Item_List] l inner join
                        [HRP].[dbo].[Items] i on l.Item_ID = i.Item_ID inner join
                        [HRP].[dbo].[Sites] s on l.Site_ID = s.Site_ID
                    WHERE
                        l.Site_ID = '". $arr['site'] ."'
                        AND l.List_Year = '". $Year ."'
                        AND l.Per_ID between '". $ps ."' and '". $pn ."'
                        AND i.Item_Status = '0' ";

            $queryTwo = mssql_query($sqlTwo);
            $objTwo = mssql_fetch_object($queryTwo);

            $maxRecord = array('One' => js_thai_encode($objOne->Site_Name), 'Two' => $objOne->Price, 'Three' => $objTwo->Price);
            mssql_free_result($queryOne);
            mssql_free_result($queryTwo);
            $response[] = $maxRecord;

            return $response;
        } else {
            $sqlOne = "SELECT
                        SUM(CAST(l.List_Price as int)) as Price,
                        CAST(s.Site_Name as text) as Site_Name
                    FROM
                        [HRP].[dbo].[Item_List] l inner join
                        [HRP].[dbo].[Items] i on l.Item_ID = i.Item_ID inner join
                        [HRP].[dbo].[Sites] s on l.Site_ID = s.Site_ID
                    WHERE
                        l.List_Year = '". $Year ."'
                        AND l.Per_ID between '". $ps ."' and '". $pn ."'
                        AND i.Item_Status = '1'
                    GROUP By
                        l.Site_ID,
                        s.Site_Name
                    ORDER BY
                        s.Site_Name ";

            $queryOne = mssql_query($sqlOne);
            $response = array();
            $maxRecordOne = array();
            $maxRecordOne2 = array();
            while ($rowOne = mssql_fetch_object($queryOne))
            {
                $maxRecordOne[] = js_thai_encode($rowOne->Site_Name);
                $maxRecordOne2[] = js_thai_encode($rowOne->Price);
            }

            $sqlTwo = "SELECT
                        SUM(CAST(l.List_Price as int)) as Price,
                        CAST(s.Site_Name as text) as Site_Name
                    FROM
                        [HRP].[dbo].[Item_List] l inner join
                        [HRP].[dbo].[Items] i on l.Item_ID = i.Item_ID inner join
                        [HRP].[dbo].[Sites] s on l.Site_ID = s.Site_ID
                    WHERE
                        l.List_Year = '". $Year ."'
                        AND l.Per_ID between '". $ps ."' and '". $pn ."'
                        AND i.Item_Status = '0'
                    GROUP By
                        l.Site_ID,
                        s.Site_Name
                    ORDER BY
                        s.Site_Name ";

            $queryTwo = mssql_query($sqlTwo);
            $maxRecordTwo = array();
            while ($rowTwo = mssql_fetch_object($queryTwo))
            {
                $maxRecordTwo[] = js_thai_encode($rowTwo->Price);
            }

            $asss = array('One' => $maxRecordOne, 'Two' => $maxRecordOne2, 'Three' => $maxRecordTwo);
            $response[] = $asss;

            return $response;
        }
    }

    function load_employee_ae($arr) {
        $sql = "SELECT
                    E.Em_ID AS IDs,
                    CAST(E.Em_Card AS Text) AS Cards,
                    CAST(E.Em_People AS Text) AS People,
                    CAST(E.Em_Fullname AS Text) AS Fullname,
                    CAST(E.Em_Lastname AS Text) AS Lastname,
                    CAST(E.Em_NickName AS Text) AS NickName,
                    E.Socie AS Soice,
                    E.Em_DateOpen AS DateOpen,
                    E.Em_DateBirthDay AS DateBirthDay,
                    E.Em_DateBlacklist AS DateBirthBlacklist,
                    CAST(E.Em_Pic AS Text) AS Pic,
                    E.Em_Age AS Age,
                    CAST(E.Em_DayCost AS Text) AS DayCost,
                    CAST(E.Em_ChoiceBank AS Text) AS ChoiceBank,
                    CAST(E.Em_BankBranch AS Text) AS BankBranch,
                    E.Em_AccountNumber AS AccountNumber,
                    E.Em_CashCard AS CashCard,
                    E.Em_LivingExpenses AS LivingExpenses,
                    E.Em_Allowance AS Allowance,
                    E.Em_AllowanceDisaster AS AllowanceDisaster,
                    E.Em_AllowanceSafety AS AllowanceSafety,
                    E.Em_SpecialAllowance AS SpecialAllowance,
                    E.Em_Width AS Width,
                    E.Em_Height AS Height,
                    CAST(E.Em_Address AS Text) AS Address,
                    E.Em_Tel AS Tel,
                    E.Em_Mobile AS Mobile,
                    CAST(E.Em_Titel AS Text) AS Titel,
                    CAST(E.Em_Status AS Text) AS Status,
                    CAST(E.Em_Status_Reason AS Text) AS Blacklist,
                    S.Site_ID AS Site_ID,
                    CAST(S.Site_Name AS Text) AS Site_Name,
                    P.Pos_ID AS Pos_ID,
                    CAST(P.Pos_Name AS Text) AS Pos_Name,
                    G.Group_ID AS Group_ID,
                    CAST(G.Group_Name AS Text) AS Group_Name,
                    Gb.Blood_ID AS Blood_ID,
                    CAST(Gb.Blood_Name AS Text) AS Blood_Name,
                    R.Re_ID AS Re_ID,
                    CAST(R.Re_Name AS Text) AS Re_Name,
                    B.Bank_ID AS Bank_ID,
                    CAST(B.Bank_Name AS Text) AS Bank_Name,
                    E.Em_Money AS Money,
                    E.Em_Email AS Email,
                    CAST(E.Em_Work_Date AS Text) AS Work_Date,
                    CAST(H.hos_name AS Text) AS Hos_name,
                    CAST(E.Em_Inform AS Text) AS Inform,
                    CAST(E.Em_Notice AS Text) AS Notice
                FROM
                    [HRP].[dbo].[Employees] AS E,
                    [HRP].[dbo].[Sites] AS S,
                    [HRP].[dbo].[Group] AS G,
                    [HRP].[dbo].[Position] AS P,
                    [HRP].[dbo].[GroupBlood] AS Gb,
                    [HRP].[dbo].[Religion] AS R,
                    [HRP].[dbo].[Banks] AS B,
                    [HRP].[dbo].[Hospital] AS H
                WHERE
                    E.Site_ID = S.Site_ID
                    AND E.Group_ID = G.Group_ID
                    AND E.Pos_ID = P.Pos_ID
                    AND E.Blood_ID = Gb.Blood_ID
                    AND E.Re_ID = R.Re_ID
                    AND E.Bank_ID = B.Bank_ID
                    AND E.hos_id = H.hos_id
                    AND E.Em_ID = '". $arr['code'] ."' ";

        $query = mssql_query($sql);
        $response = array();
        while ($row = mssql_fetch_array($query))
        {
            $response[] = $row;
        }

        mssql_free_result($query);
        return js_thai_encode($response);
        // return $sql;
    }

    function load_employee($arr) {
        $limitPage = $arr['page'];
        $limitStart = ($arr['num'] > 1) ? ($arr['num']-1)*($limitPage) : 0 ;
        $limitEnd = ($arr['num'] > 1) ? ($limitPage * $arr['num']) : $limitPage;

        $sql = "SELECT
                    Em_ID,
                    Em_Pic,
                    Em_Titel,
                    Em_Status,
                    Socie,
                    CAST(Em_Fullname AS Text) AS Fullname,
                    CAST(Em_Lastname AS Text) AS Lastname,
                    CAST(Em_Card AS Text) AS Card,
                    CAST(Site_Name AS Text) AS Site_Name,
                    CAST(Group_Name AS Text) AS Group_Name,
                    CAST(Pos_Name AS Text) AS Pos_Name
                FROM
                (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY Em_ID DESC) AS rownum,
                        Em_ID,
                        Em_Pic,
                        Em_Titel,
                        Em_Status,
                        Socie,
                        Em_Fullname,
                        Em_Lastname,
                        Em_Card,
                        Site_Name,
                        Group_Name,
                        Pos_Name
                    FROM
                        [HRP].[dbo].[Employees] AS E,
                        [HRP].[dbo].[Sites] AS S,
                        [HRP].[dbo].[Group] AS G,
                        [HRP].[dbo].[Position] AS P
                    WHERE
                        E.Site_ID = S.Site_ID
                        AND E.Group_ID = G.Group_ID
                        AND E.Pos_ID = P.Pos_ID
                        AND E.Em_Status = '". $arr['status'] ."' ";
                        if($arr['site'] != '' && $arr['site'] != '1') {
                            $sql .= "AND S.Site_ID = '". $arr['site'] ."' ";
                        }
                        if($arr['id'] != '') {
                            $sql .= "AND E.Em_ID = '". $arr['id'] ."' ";
                        }
                        if($arr['name'] != '') {
                            $name = $Fullname = iconv('UTF-8','TIS-620', $arr['name']);
                            $sql .= "AND (E.Em_Fullname like '%". $name ."%' or E.Em_Lastname like '%". $name ."%' or S.Site_Name like '%". $name ."%' or P.Pos_Name like '%". $name ."%' or G.Group_Name like '%". $name ."%') ";
                        }
                $sql .= ") as e
                WHERE
                    rownum >= '". $limitStart ."' AND rownum <= '". $limitEnd ."' ";

        $query = mssql_query($sql);
        $response = array();
        while ($row = mssql_fetch_array($query))
        {
            $response[] = $row;
        }
        mssql_free_result($query);
        return js_thai_encode($response);
        // return $sql;
    }

    function load_num_employee($arr) {
        $sql = "SELECT
                        ROW_NUMBER() OVER (ORDER BY Em_ID DESC) AS rownum,
                        Em_ID,
                        Em_Pic,
                        Em_Titel,
                        Em_Status,
                        Socie,
                        CAST(Em_Fullname AS Text) AS Fullname,
                        CAST(Em_Lastname AS Text) AS Lastname,
                        CAST(Em_Card AS Text) AS Card,
                        CAST(Site_Name AS Text) AS Site_Name,
                        CAST(Group_Name AS Text) AS Group_Name,
                        CAST(Pos_Name AS Text) AS Pos_Name
                    FROM
                        [HRP].[dbo].[Employees] AS E,
                        [HRP].[dbo].[Sites] AS S,
                        [HRP].[dbo].[Group] AS G,
                        [HRP].[dbo].[Position] AS P
                    WHERE
                        E.Site_ID = S.Site_ID
                        AND E.Group_ID = G.Group_ID
                        AND E.Pos_ID = P.Pos_ID
                        AND E.Em_Status = '". $arr['status'] ."' ";
                if($arr['site'] != '' && $arr['site'] != '1') {
                    $sql .= "AND S.Site_ID = '". $arr['site'] ."' ";
                }
                if($arr['id'] != '') {
                    $sql .= "AND E.Em_ID = '". $arr['id'] ."' ";
                }
                if($arr['name'] != '') {
                    $name = $Fullname = iconv('UTF-8','TIS-620', $arr['name']);
                    $sql .= "AND (E.Em_Fullname like '%". $name ."%' or E.Em_Lastname like '%". $name ."%' or S.Site_Name like '%". $name ."%' or P.Pos_Name like '%". $name ."%' or G.Group_Name like '%". $name ."%') ";
                }

        $query = mssql_query($sql);
        $num = mssql_num_rows($query);
        mssql_free_result($query);
        return $num;
        // return $sql;
    }

    function js_thai_encode($data) {   // fix all thai elements
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
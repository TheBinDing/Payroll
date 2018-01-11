<?php
    @session_start();
    include("inc/connect.php");
    $user = $_POST['username'];
    $pass = base64_encode($_POST['password']);

    $sql = "SELECT
                m_id as m_id,
                CAST(m_name as Text) as m_name,
                CAST(m_user as Text) as m_user,
                CAST(m_site as Text) as Site,
                m_email as mails,
                m_rule as rules
            FROM
                [HRP].[dbo].[Users]
            WHERE
                m_user = '".$user."'
                AND m_pass = '".$pass."'
                AND m_status = '1' ";

    $query  = mssql_query($sql);
    $num = mssql_num_rows($query);
    $row = mssql_fetch_array($query);

    $hams = explode(',', $row['Site']);
    $sites = $hams[0];
    $rule = $row['rules'];
    $m_name = $row['m_name'];

    ### CHECK_TIME_PLAN ###
    $day = new datetime();
    $day = $day->format('d-m-Y');
    $day = explode('-', $day);
    $day = mktime(0, 0, 0, $day[0], $day[2], $day[1]);

    $check_plan = "SELECT
                        p.TimePlan_ID AS id,
                        p.TimePlan_EndDate AS EndDate,
                        e.Em_ID AS Code
                    FROM
                        [HRP].[dbo].[PlanTime] p left join
                        [HRP].[dbo].[Sites] s on p.Site_ID = s.Site_ID left join
                        [HRP].[dbo].[Employees] e on p.TimePlan_ID = e.TimePlan_ID
                    WHERE
                        p.TimePlan_ID != '1'
                        AND p.TimePlan_Status = '1' ";
    if($sites == '1') {
        $check_plan .= " AND s.Site_ID != '".$sites."' ";
    } else {
        $check_plan .= " AND s.Site_ID = '".$sites."' ";
    }
    // echo $check_plan;

    $q_plan = mssql_query($check_plan);
    $num_plan = mssql_num_rows($q_plan);
    // echo $num_plan;

    for($s=1;$s<=$num_plan;$s++) {
        $row_plan = mssql_fetch_array($q_plan);

        $Date_Plan = new datetime($row_plan['EndDate']);
        $Date_Plan = $Date_Plan->format('d-m-Y');
        $Date_Plan = explode('-', $Date_Plan);
        $Date_Plan = mktime(0, 0, 0, $Date_Plan[0], $Date_Plan[2], $Date_Plan[1]);

        // echo $day.'-'.$Date_Plan.'<br>';

        if($day > $Date_Plan) {
            $update_plan = "UPDATE
                                [HRP].[dbo].[PlanTime]
                            SET
                                TimePlan_Status = '". iconv('UTF-8', 'TIS-620', 'ปิด') ."'
                            WHERE
                                TimePlan_ID = '".$row_plan['id']."' ";
            mssql_query($update_plan);

            $update_employee = "UPDATE
                                    [HRP].[dbo].[Employees]
                                SET
                                    TimePlan_ID = '1'
                                WHERE
                                    Em_ID = '".$row_plan['Code']."' ";
            mssql_query($update_employee);

            // echo $update_plan.'--'.$update_employee.'<br>';
        }
    }
    #######################

    if($num==0)
    {
        exit("<script>alert('LOGIN FAIL');history.back();</script>");
    } else {
        // echo $user.'-'.$row['m_id'].'-'.$sites.'-'.$rule.'-'.$m_name;
        $_SESSION['user_name'] = $user;
        $_SESSION['user_id'] = $row['m_id'];
        $_SESSION['SuperSite'] = $sites;
        $_SESSION['Rule'] = $rule;
        $_SESSION['SuperName'] = $m_name;
        $_SESSION['SuperMail'] = $row['mails'];
        // exit("<script>window.location='News.php';</script>");

        $date = date("Y-m-d");
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql="INSERT INTO [HRP].[dbo].[Counter] (date_visit,ip_visit,visit,m_id) VALUES ('". $date ."', '". $ip ."', '1', '". $row['m_id'] ."')";
        mssql_query($sql);

        if($_SESSION['Rule'] == '3') {
            $sql_check_audit = "SELECT * FROM [HRP].[dbo].[AuditWorkDay] WHERE m_id = '". $_SESSION['user_id'] ."' AND Check_day = '". $date ."' ";
            $query_check_audit = mssql_query($sql_check_audit);
            $num_check_audit = mssql_num_rows($query_check_audit);

            if($num_check_audit == 0) {
                $sql_insert_audit = "INSERT INTO [HRP].[dbo].[AuditWorkDay] (Check_Name, Check_day, Check_in, Check_out, m_id) VALUES ('". $_SESSION['user_name'] ."','". $date ."', '0', '0', '". $_SESSION['user_id'] ."') ";

                mssql_query($sql_insert_audit);
            }
        }
    }
?>
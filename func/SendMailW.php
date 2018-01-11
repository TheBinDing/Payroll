<?php
    /**
    * Simple example script using PHPMailer with exceptions enabled
    * @package phpmailer
    * @version $Id$
    */

    @session_start();
    date_default_timezone_set('Asia/Bangkok');

    require("../PHPMailer_5.2.4/class.phpmailer.php");
    require("../inc/connect.php");

    $Site = $_GET['Site'];
    $Period = $_GET['Period'];

    $Sites = ','.$Site.',';

    $u = "SELECT
            CAST(m_name as text) as name_u,
            m_email as mail_u,
            CAST(m_site as text) as txt_site
        FROM
            [HRP].[dbo].[Users]
        WHERE
            m_site like '%". $Site ."%'
            AND m_status = '1' ";

    $q_u = mssql_query($u);
    $n_u = mssql_num_rows($q_u);

    for($uu=1;$uu<=$n_u;$uu++) {
        $r_u = mssql_fetch_array($q_u);

        $ss = explode(',', $r_u['txt_site']);

        foreach ($ss as $key => $value) {
            if($value == $Site) {
                if($key == 0) {
                    $nnu = $r_u['name_u'];
                    $mmu = $r_u['mail_u'];
                } else {
                    $nnu = $nnu.', '.$r_u['name_u'];
                    $mmu = $mmu.', '.$r_u['mail_u'];
                }
            }
        }
    }

    $nnu2 = explode(', ', $nnu);

    if($nnu2[0] == '') {
        foreach ($nnu2 as $key => $v2) {
            if($key[0] == '') {
                if($key == 1) {
                    $nnu = $v2;
                }
                if($key > 1) {
                    $nnu = $nnu.', '.$v2;
                }
            }
        }
    }

    $mmu2 = explode(', ', $mmu);

    if($mmu2[0] == '') {
        foreach ($mmu2 as $key => $v3) {
            if($key[0] == '') {
                if($key == 1) {
                    $mmu = $v3;
                }
                if($key > 1) {
                    $mmu = $mmu.', '.$v3;
                }
            }
        }
    }

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

    $detail = 'เรียน '. iconv('TIS-620','UTF-8', $nnu) .'<br><br>'; // in
    $detail .= 'ทาง HR/Admin ได้ทำการตัดวีคให้เรียบร้อยแล้วครับ <br>';
    $detail .= 'โครงการ : '. iconv('TIS-620','UTF-8', $r_s['name_s']) .'('. $r_s['code_s'] .') <br>'; // in
    $detail .= 'งวดวันที่ : '. $PS .' ถึง '. $PN . '<br><br><br>';
    $detail .= 'ด้วยความเคารพ <br>';
    $detail .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['SuperName']; // in
    $subject = 'แจ้งการตัดวีค โครงการ : '. iconv('TIS-620','UTF-8', $r_s['name_s']) .'('. $r_s['code_s'] .')'; // out
    $mail_from = $_SESSION['SuperMail'];
	// echo $detail.'<br>';
	// echo $subject;
    $msg = sendMail($detail,$subject,$mail_from,1,$n_u,$mmu);
    echo $msg;

    function sendMail($detail,$subject,$from,$send,$num,$m){
        $mail = new PHPMailer();
        $mail->Body = $detail;
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();// Set mailer to use SMTP
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        // $mail->Host = "192.168.1.78"; // SMTP server
        $mail->Host = "mail.csloxinfo.com"; // SMTP server
        // $mail->Host = "smtp.gmail.com"; // Gmail
        // $mail->Host = "smtp.live.com"; // hotmail.com
        // $mail->Port = 25; // พอร์ท 25, 465 or 587
        $mail->Username = $from; // SMTP username
        $mail->Password = "tpolypassword"; // SMTP password
        //from
        $mail->SetFrom($from, $_SESSION['SuperName']);
        $mail->IsHTML(true);
        //send mail
         if($send == 1){
            // $mail->AddAddress("apichat.si@thaipolycons.co.th");
            if($num > 1) {
                $ms = explode(', ', $m);
                foreach ($ms as $key => $value) {
                    $mail->AddAddress($value);
                }
            } else {
                $mail->AddAddress($m);
            }
            $mail->AddCC("aekkachon@thaipolycons.co.th");
            $mail->AddCC("katanyakit.su@thaipolycons.co.th");
            $mail->AddCC("phiphop.po@thaipolycons.co.th");
            $mail->AddCC("netnapit@thaipolycons.co.th");
         }else{
            $mail->AddAddress($send);
         }
        
        //$mail->AddReplyTo("email@yourdomain.com", "yourname");
        $mail->Subject = $subject;
        
        if(!$mail->send()){
            $msg = iconv('UTF-8', 'TIS-620', 'ไม่สามารถส่ง mail ได้ค่ะ');
            $msg .= 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            $msg = iconv('UTF-8', 'TIS-620', 'ส่ง mail แจ้งเรียบร้อยแล้วค่ะ');
        }
        return $msg;
    }
	echo "<script>
	    window.onbeforeunload = function(){return false;};
	    setTimeout(function(){window.close();}, 1000);
	</script>";
?>
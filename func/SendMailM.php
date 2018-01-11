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
    $detail .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['SuperName']; // in
    $subject = 'แจ้งการตัดวีค โครงการ : '. iconv('TIS-620','UTF-8', $r_s['name_s']) .'('. $r_s['code_s'] .')'; // out
    $mail_from = $_SESSION['SuperMail'];
    $msg = sendMail($detail,$subject,$mail_from,1);
    echo $msg;

    function sendMail($detail,$subject,$from,$send){
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
            $mail->AddAddress("phiphop.po@thaipolycons.co.th");
            $mail->AddAddress("netnapit@thaipolycons.co.th");
            $mail->AddCC("aekkachon@thaipolycons.co.th");
            $mail->AddCC("katanyakit.su@thaipolycons.co.th");
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
	    setTimeout(function(){window.close();}, 3000);
	</script>";
?>
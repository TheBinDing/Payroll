<?php
session_start();
date_default_timezone_set('Asia/Bangkok');

require("../PHPMailer_5.2.4/class.phpmailer.php");
require("AjaxSave.php");
require("../inc/connect.php");

$response = array();
$mode = $_POST['mode'];
$arr = $_POST;

switch ($mode)
{
    case 'load_employee_list' :
        $response = load_employee_list($arr);
    break;
    case 'load_group_list' :
        $response = load_group_list($arr);
    break;
    case 'insert_subject' :
        $response = insert_subject($arr);
    break;
    case 'load_year_list' :
        $response = load_year_list($arr);
    break;
    case 'load_position_list' :
        $response = load_position_list($arr);
    break;
    case 'load_news_list' :
        $response = load_news_list($arr);
    break;
    case 'delete_news_list' :
        $response = delete_news_list($arr);
    break;
    case 'check_status' :
        $response = check_status($arr);
    break;
    case 'load_grap_list' :
        $response = load_grap_list($arr);
    break;
    case 'load_grap_price_list' :
        $response = load_grap_price_list($arr);
    break;
    case 'load_employee_ae' :
        $response = load_employee_ae($arr);
    break;
    case 'sendAnnounce' :
        $response = sendAnnounce($arr);
    break;
    case 'sendCAnnounce' :
        $response = sendCAnnounce($arr);
    break;
}

echo json_encode($response);

?>
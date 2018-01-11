<?php
session_start();
require("func_loadTest.php");
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
}

echo json_encode($response);

?>
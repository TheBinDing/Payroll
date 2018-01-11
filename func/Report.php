<?php
    $site = $_POST['Site'];
    if($_POST['Position'] == 0){
        $position = '';
    } else {
        $position = $_POST['Position'];
    }
    if($_POST['Group'] == 0){
        $group = '';
    } else {
        $group = $_POST['Group'];
    }
    $period = $_POST['Period'];

    if($_POST['Report'] == 1) {
        exit("<script>window.location='../pdf/PDF02.php?Site=$site&Position=$posotion&Group=$group&Period=$period';</script>");
    }
    if($_POST['Report'] == 2) {
        exit("<script>window.location='../pdf/PDF01.php?Site=$site&Position=$posotion&Group=$group&Period=$period';</script>");
    }
    if($_POST['Report'] == 3) {
        exit("<script>window.location='../pdf/PDF04.php?Site=$site&Position=$posotion&Group=$group&Period=$period';</script>");
    }
?>
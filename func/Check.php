<?php
    @session_start();
    $_SESSION['SuperSite'] = $_GET['Site'];
    $link = '../'.$_SESSION['Link'];

    exit("<script>window.location='$link';</script>");
?>
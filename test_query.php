<?php
    @session_start();
    include("inc/connect.php");
    // include("inc/function.php");
    // checklogin($_SESSION['user_name']);
    $HeadCheck = 'Scan';
    echo base64_decode('V0lQQVdBTiA=');
    // if($_SESSION['user_name'] == "")
    // {
    //     echo "Please Login!";
    //     exit("<script>alert('Please Login');window.location='login.php';</script>");
    // }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery/flexigrid.custom.js"></script>
<script src="js/jquery/alertify.js"></script>
<script type="text/javascript">
    jQuery(function( $ ) {
        travflex.compulsory.Criteria = {};
        travflex.compulsory.tableConfig = <?=json_encode($column_config);?>;
        travflex.compulsory.setCompulsoryGrid();
    });

    var travflex = {
        compulsory: new Object()
    };
    travflex.menu = 'compulsory';

    travflex.compulsory.setCompulsoryGrid = function()
    {
        $("#grid").flexigrid({
            colModel : travflex.compulsory.tableConfig,
            sortname : travflex.compulsory.tableConfig[0]['name'],
            sortorder : "asc",
            dblClickResize : true,
            onDoubleClick : travflex.compulsory.sendToAE,
            buttons : [{
                    name : 'Select All',
                    bclass : 'accept',
                    onpress : travflex.selectAllRecord
                },{
                    separator : true
                },{
                    name : 'Deselect All',
                    bclass : 'delete2',
                    onpress : travflex.deSelectAllRecord
                },{
                    separator : true
                },{
                    name : 'Delete',
                    bclass : 'delete',
                    onpress : travflex.compulsory.deleteRecord
                },{
                    separator : true
                },{
                    name : 'Set Default',
                    bclass : 'refresh',
                    onpress : travflex.compulsory.clearStorage
                },{
                    separator : true
                }
            ],
            usepager : true,
            autoload :false,
            title : 'Compulsory Results',
            useRp : true,
            rp : 15,
            showTableToggleBtn : true,
            width : 959,
            height : 300,
            storageName : travflex.menu
        });
    }

    travflex.compulsory.CompulsorySearch = function()
    {
        travflex.compulsory.Search =
        {
            Card : '103115',
            mode : 'search_compulsory_tariff'
        };

        $("#grid").flexOptions({
            url: "func/loadTest.php",
            dataType : 'json',
            // beforeSend: travflex.loading,
            // afterSend: travflex.closeloading,
            params : travflex.compulsory.Search
        });
        $("#grid").flexReload();
    }

    travflex.loading = function()
    {
         travflex.popup('loading');
    }

    travflex.closeloading = function()
    {
         travflex.popup('close');
    }

    travflex.compulsory.clearStorage = function(com,gridDiv,grid)
    {
        grid.clearStorage();
    }

    travflex.selectAllRecord = function(com,grid)
    {
        targetDiv = $('.bDiv tbody tr',grid);
        recordNum = targetDiv.length;
        if(recordNum > 0){
            $.each(targetDiv,function(key, value){
                $(value).addClass('trSelected');
            });
        }
    }

    travflex.deSelectAllRecord = function(com,grid)
    {
        targetDiv = $('.bDiv tbody tr',grid);
        recordNum = targetDiv.length;
        if(recordNum > 0){
            $.each(targetDiv,function(key, value){
                $(value).removeClass('trSelected');
            });
        }
    }

    travflex.compulsory.sendToAE = function(com,grid,func)
    {
        keyfield = $(com).attr('data-id');
        window.open("pcompulsorysae.php?KeyField="+keyfield+"", "_blank");
    }
</script>

<html>
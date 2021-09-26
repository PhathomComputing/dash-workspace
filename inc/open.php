<?php   
    session_start();
    $ROOT = $_SERVER['DOCUMENT_ROOT']."/dash/" ;
    $PHP_LIB = $_SERVER['DOCUMENT_ROOT']."/dash/inc/lib/" ;
    require("inc/lib/phpHelpers.php");
    require("inc/lib/phathDebug/functions.php");
    require('inc/lib/CRUD.php');
    
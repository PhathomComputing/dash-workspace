<?php 

$db = mysqli_connect('localhost', 'root', '', 'phath_dash');


//DBG_CHECK
if(mysqli_connect_errno()){
    dbg_check( 'Database connection fail with following errors: ' . mysqli_connect_error());
    die();
} 




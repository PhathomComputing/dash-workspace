<?php 

$db = mysqli_connect('localhost', 'root', '', 'phath_dash');
if(mysqli_connect_errno()){
    add_checkpoint( 'Database connection fail with following errors: ' . mysqli_connect_error());
    die();
} else {
    add_checkpoint('Database Connection Success');

}
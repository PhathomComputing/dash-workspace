<?php 

$db = mysqli_connect('localhost', 'root', '', 'phath_dash');


try{ 
    $pdo = new PDO('mysql:host=localhost; dbname=phath_dash','root','');
} catch (PDOException $e){
    print "Error!: " . $e->getMessage() . "<br/>";
    dbg_check( 'PDO Database connection fail with following errors: ' .  $e->getMessage());
    die();
}

//DBG_CHECK
if(mysqli_connect_errno()){
    dbg_check( 'Database connection fail with following errors: ' . mysqli_connect_error());
    die();
}


$count = 0;
foreach($pdo->query("SELECT * from session") as $row){
    $count++;
    dbg_check('Data: '.$row['data']);
}


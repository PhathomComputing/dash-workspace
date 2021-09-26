<?php

$user = $db->query("SELECT * FROM user ");
$userSQL = `
    SELECT * FROM :user
`;
$userPDO = $pdo->prepare($userSQL);
$userPDODATA = $userPDO->execute(array(':user'=>"admin"));
$userData = mysqli_fetch_assoc($user);



function checkUser($userData){
    dbg_check($userData);
    if(!isset($userData['data'])){
        dbg_check("doesnt exist");
    }
    if($userData['data']==''){
        dbg_check("empty");
        $userData['data'] = ['data']; 
    }
}

function logIn($userData){
    $_SESSION['user-data'] = $userData;
}


checkSession();
checkUser($userData);
logIn($userData);

function checkSession(){
    dbg_check("logged in as ".$_SESSION['user-data']['uname']);
}
checkSession();

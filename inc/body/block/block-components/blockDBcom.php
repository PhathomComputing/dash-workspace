<?php
    if(!$_POST['block-data']){
        die('Access Restricted');
    }
    //print_r( $_POST );
    require('./blockFunc.php');


    $db= mysqli_connect('localhost', 'root', '', 'phath_dash');
    if(mysqli_connect_errno()){
        echo 'Database connection fail with following errors: ' . mysqli_connect_error();
        die();
    } else {

    }


    $post = $_POST;
    //$post = [];
    //finish later
    // foreach($_POST as $key => $val){
    //     //filter through objects AND strings to check htmlentities
    //     $post[$key] = htmlentities($val);        
    // }

    if($post['block-data']['mode']=="synch"){
        storeMessages($post['block-data']['log'],$db);
    } elseif ($post['block-data']['mode']=="retrieve"){
        $msgs = retrieveMessages($db);

    }elseif ($post['block-data']['mode']=="func"){
        echo json_encode(whois($post['block-data']['url']));
    }
    
    function storeMessages($data,$db){
        $dataJson = json_encode($data);
        //echo $dataSend;
        $query = <<<QUERY
        UPDATE blocks SET data = '$dataJson' WHERE title = 'chat-box' 
QUERY;
        if($db->query($query)){
            echo "DB Synch Successful";
        } else {
            echo "An error occured with query: </br>";
            echo json_encode(['query' => $query]);
        }
    }

    function retrieveMessages($db){
        
        //echo $dataSend;
        $query = <<<QUERY
        SELECT data FROM blocks WHERE title = 'chat-box' 
QUERY;
        if($result = $db->query($query)){
            $package = json_encode(mysqli_fetch_assoc($result));
            echo json_encode(['ok' => true,'query' => $package]);
        } else {
            echo json_encode(['ok' => false, 'error' => $db->error_list, 'query' => $query]);
        }
    }
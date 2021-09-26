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
    
    //CHAT BLOCK HANDLER

    if($post['block-data']['mode']=="synch")
    {
        syncChat( $post['block-data']['log'] , $db );
    } 
    elseif ($post['block-data']['mode']=="retrieve")
    {
        $msgs = retrieveMessages($db);
    }
    elseif ($post['block-data']['mode']=="whois")
    {
        echo json_encode(whois($post['block-data']['url']));
    }
    elseif ($post['block-data']['mode']=="chat"){}
    
    function syncChat( $data , $db ){
        $query = <<<QUERY
            SELECT data FROM blocks WHERE blocks.id = 1
QUERY;
        $currentChatRoomArrayData = json_decode(mysqli_fetch_assoc($db->query($query))['data']);
        $newChatArrayData = json_decode($data);
        if($currentChatRoomArrayData != null){ array_push($currentChatRoomArrayData,$newChatArrayData);}
        else { $currentChatRoomArrayData = [$newChatArrayData]; }
        $dataJson = json_encode($currentChatRoomArrayData);
        //echo $dataSend;
        $query = <<<QUERY
            UPDATE blocks SET data = '$dataJson' WHERE blocks.id = 1
QUERY;
        if($db->query($query)){
            echo "DB Synch Successful";
            echo json_encode(['query' => $query, 'ok' => 'success', 'dbdata'=> $currentChatRoomArrayData, 'data'=>$newChatArrayData, 'dataJson'=>$dataJson]);

        } else {
            echo "An error occured with query: </br>";
            echo json_encode(['query' => $query]);
        }
    }

    function retrieveMessages($db){
        
        //echo $dataSend;
        $query = <<<QUERY
        SELECT data FROM blocks WHERE block = 'chat-box' 
QUERY;
        if($result = $db->query($query)){
            $package = mysqli_fetch_assoc($result);
            echo json_encode(['ok' => true,'query' => $package]);
        } else {
            echo json_encode(['ok' => false, 'error' => $db->error_list, 'query' => $query]);
        }
    }





    /*
    "[{"user":"bob","msg":"i are bob","date":"2019-02-09 16:14:36"},
      {"user":"bob","msg":"testing bob","date":"2019-02-09 16:14:36"}
    ]"


    */
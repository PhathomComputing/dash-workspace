<?php 

    $params = array("username" => "timezone24",
    "password" => "9t9xRNfyX5vf2C",
    "pid"      => "1",
    "lid"      => "2");

    $headers = array(
        'Content-type: application/json',
        'Authorization: Bearer A21AAJ_ouWJlu1JxL_ayh7IwGFgPbik9fdthNQXiGRjBomMp9dOEkZK2W6GTW8n8AXpwHnMUhdQ5Gd3nJM4JYWZU-IPuu42bg',
    );


    $params = http_build_query($params);
    $data = array('data' => $params);
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v2/invoicing/invoices?total_required=true'); //csv.php for csv file
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HTTPGET , 1);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    

    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    $ce = curl_exec($ch); // $ce contain call response
    curl_close($ch);
    //echo json_encode($ce);w
    echo $ce;
    //file_put_contents("watch-list.json",$ce);   
    
    //$pdo->execute();


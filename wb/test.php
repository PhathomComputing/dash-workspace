<?php 
    $regFile = fopen("lfile.txt",'r');

    $fileText = fread($regFile, filesize("lfile.txt"));
    echo $fileText;
    $json = json_decode($fileText, JSON_FORCE_OBJECT);
    echo "\n=====================================================\n";
    print_r($json);
    echo $json['success'];
    echo $json['data']['validation'];
    echo $json['data']['import'];
    echo $json['response_code'];

?>
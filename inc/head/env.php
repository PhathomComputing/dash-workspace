<?php
    $env = $db->query("SELECT data FROM session WHERE type = 'env'");
    $jsondata = mysqli_fetch_assoc($env);
    

    
    
    if(isset($seshData)){
        dbg_check($seshData);
        dbg_check(is_object($seshData));
        $seshData = json_decode($jsondata);
        if(!isset($seshData['css'])){
            $defaultData = (object)[
                                "css"=>(object)[
                                    "background-color"=>"#999999",
                                    "background-url"=>"assets/img/twirk3d.png"

                                ]
                            ];
                        $encodejs=json_encode($defaultData);
            

            //DBG_CHECK
            if($db->query(`UPDATE session SET data ='`.$encodejs.`'`)){
                dbg_check( "Session Saved Successfully!");
            } else {
                dbg_check( ['ok' => false, 'error' => $db->error_list, 'query' => $query]);

            }
        
        } else {
            echo "<script>";
            echo 'var seshData='.$seshData.';';
            echo "</script>";
        }
    }
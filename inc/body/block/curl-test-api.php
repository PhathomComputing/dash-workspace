<?=mbBlockStart();?>
        <?=setTitle('Curl Test Api');?>
        <?php

$params = array("uid" => "116145",
                "pid" => "1",
                "lid"=> "2",
                "key"=>"VG18i2Im0QpFqO982RNE5i24r7fjF6J7N7haDTOoozauMP5P264n9cgXvEvy1Y4o",
                "api_version"=>"1.0.0",
                "request"=> "get_brands",); 
   
$paramsbuild = http_build_query($params);
$data = array('data' => json_encode($params));
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://dev.dropshippingb2b.com/api/');
curl_setopt($ch, CURLOPT_SSLVERSION , CURL_SSLVERSION_TLSv1_2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$ce = curl_exec($ch); // $ce contain call response
curl_close($ch);
$results = json_decode($ce);
dbg_check($results->num_rows);

print_r($results->rows);
?>  
<?=blockEnd();?>
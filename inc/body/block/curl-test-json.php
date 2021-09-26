<?=mbBlockStart();?>
        <?=setTitle('Curl Test Json');?>
        <?php



$params = array("username" => "timezone24",
                "password" => "9t9xRNfyX5vf2C",
                "pid"      => "1",
                "lid"      => "2");
// LANGUAGE ID Field is optional.
// You can omit or can insert the lid value provided with credentials.
   
/*  PORTAL ID
1    wwt.it
2    b2buhren.de
4    marcaspararevenda.com
6    marcasalmayor.es
7    b2bwatches.co.uk
8    b2bhodinky.cz
9    b2bmontres.fr
10   b2bhorloges.nl
11   emporiorologion.gr
13   atacadodemarcas.com.br
14   b2bsk.sk
15   klockorb2b.se
16   markihurt.pl
*/
$params = http_build_query($params);
$data = array('data' => $params);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://dev.dropshippingb2b.com/export/json.php');
curl_setopt($ch, CURLOPT_SSLVERSION , CURL_SSLVERSION_TLSv1_2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$ce = curl_exec($ch); // $ce contain call response
curl_close($ch);
print_r($data);

?>  
<?=blockEnd();?>
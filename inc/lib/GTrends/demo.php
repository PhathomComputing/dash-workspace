<?php 

require_once './GSession.php';
require_once './GTrends.php';
use app\models\service\GSession;
use app\models\service\GTrends;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

$email='EMAIL';
$password='PASSWORD';


if ($email=='EMAIL' || $password=='PASSWORD') {
    echo 'Please, set the email and password in this script for the demo to work';
    exit(0);
}

//Login with your account to avoid rate limits:
$gs=new GSession($email, $password, dirname(__FILE__).'/authcookie.txt');
$gs->authenticate();

//Create the GTrends object with your language ('es' for spanish for example).
$gt=new GTrends($gs, 'en-US');
$gt->addTerm('android')->addTerm('ios')->setTime('2007-11-01 2017-11-01'); 
$res=$gt->getGraph(GTrends::DATA_JSON); //Get the data in json, array or csv
echo 'Graph json data:<br/>';
echo $res;
echo '<br/><br/>';

//Get the cities where the terms are trending
$gt=new GTrends($gs, 'en-US');
$gt->addTerm('android')->addTerm('ios')->setTime('2007-11-01 2017-11-01');
$res=$gt->getRegions(GTrends::DATA_CSV, 'CITY');
echo 'Regions csv data:<br/>';
echo $res;
echo '<br/><br/>';

//Get the related queries
$gt=new GTrends($gs, 'en-US');
$gt->setTime('2017-04-01 2017-04-18');
$res=$gt->getRelated('samsung', GTrends::DATA_ARRAY);
echo 'Related array data:<br/>';
var_dump($res);
echo '<br/><br/>';

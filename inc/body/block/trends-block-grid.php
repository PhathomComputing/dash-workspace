

<?php
    //requirements
    require_once $PHP_LIB.'GTrends/GSession.php';
    require_once $PHP_LIB.'GTrends/GTrends.php';
    use app\models\service\GSession;
    use app\models\service\GTrends;
?>


<?php 
$template = ``;
$template .= mbBlockStart();
$template .= setTitle('Google Trends');
//code for block
$template .=blockEnd();
$trendsBlock = $template
?>
 



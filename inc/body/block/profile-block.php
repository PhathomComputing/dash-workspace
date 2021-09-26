


<?php 
    $template ='';
    $template .= mbBlockStart();
    $template .= setTitle('User Profile',$alt);
    $template .= imageThumb($imageUrl,$alt);
    $template .= $user;
    $template .= $profession;
    $template .= optionBlock();
    $template .= blockEnd();
    //dbg_check($template);
    $profileBlock = $template;
?>
<?=mbBlockStart();?>
    <?=setTitle('User Profile',$alt);?>
    <?=imageThumb($imageUrl,$alt);?>
    <h1><?=$user;?></h1>
    <h3><?=$profession;?></h3>
    <br>       
    <?=optionBlock();?>
<?=blockEnd();?>
    
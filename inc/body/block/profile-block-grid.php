


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

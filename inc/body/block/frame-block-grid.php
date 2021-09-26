<?php 
    $template ='';
    $template .= mbBlockStart();
    $template .= setTitle('Frame');
    $template .= '<embed style="margin-top:25px;" src="./workbench"
    width="100%" 
    height="100%" />';
    $template .= blockEnd();
    //dbg_check($template);
    $frameBlock = $template;
?>
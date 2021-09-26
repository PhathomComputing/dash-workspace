
<?php 
    $template ='';
    $template .= mbBlockStart();
    $template .= setTitle('Options');
    $template .= optionsBlock('notice');
    $template .= optionsBlock('info');
    $template .= optionsBlock('warning');
    $template .= optionBlock();
    $template .= blockEnd();
    //dbg_check($template);
    $optionsBlock = $template;
?>



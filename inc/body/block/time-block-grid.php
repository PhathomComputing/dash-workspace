
<?php 
    $template = ``;
    $template.=mbBlockStart();
    $template.=setTitle('Local Time');
    $template.='<hr>
                    <div class="clockcenter">
                        
                        <digiclock></digiclock>
                        <div id="utc-clock"></div>

                    
                    </div>';
    $template.=blockEnd();?>
<?php 
$timeBlock = $template;
?>
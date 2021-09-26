
<?php 
$template ='';

$template.=mbBlockStart();
$template.=setTitle('File Browser');
$template.='<hr>';
$template.= modalStart('file-browser-block', ['launch-button'], 'File Browser'); 
$template.= "Here's some stuff
            <div id='elfinder'></div>

            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
            </div>";
$template.= modalEnd();
$template.= blockEnd();
$filesBlock = $template;
?>
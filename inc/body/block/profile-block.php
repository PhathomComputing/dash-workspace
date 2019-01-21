
<?php 
    
    ?>
    
    <?=mbBlockStart();?>
        <?=setTitle('User Profile',$alt);?>
        <?=imageThumb($imageUrl,$alt);?>
        <h1><?=$user;?></h1>
        <h3><?=$profession;?></h3>
        <br>       
        <?=optionBlock();?>
    <?=blockEnd();?>
    
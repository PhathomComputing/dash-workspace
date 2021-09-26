
<div id="block_grid" class="container block-flat">
    <div class="grid-title" style="font-size:36px; left:400px; top:200px;">Other Grid</div>

        <?php require("inc\body\block\block-components\blockConstruct.php");?>
        <?php require("inc\body\block\block-components\blockFunc.php");?>
		
	        <!-- FIRST ROW OF BLOCKS -->     
       
<?php

    require('inc/body/block/profile-block.php');
    require('inc/body/block/revenue-block.php');
    require('inc/body/block/time-block.php');
    require('inc/body/block/file-browser-block.php');

    require('inc/body/block/whois-block.php');
    require('inc/body/block/chat-block.php');
    //require('inc/body/block/template.php');
    //require("inc/body/block/option-block.php");
    require("inc/body/block/qr-block.php");
    //require("inc/body/block/cast-block.php");
    //require("inc/body/block/curl-test.php");

    ?>

</div>
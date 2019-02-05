<body>
	<?php require('inc/body/splash.php');?>
	
		<?php 
            $user = "Christoph";
            $profession="Developer Lead";
			$imageUrl = "assets/img/face80x80.jpg";
			$alt = "Christoph";
        ?>
    <?php require('inc/body/nav.php');?>
      
    <?php require('inc/body/drop-grid.php');?>
	
	<?php if(isset($_GET['grid']) && $_GET['grid']=='home'){require('inc/body/block-grid.php');}
else{?>

	<div id="block_grid" class="container block-flat">
			
			<?php require("inc\body\block\block-components\blockConstruct.php");?>
			<?php require("inc\body\block\block-components\blockFunc.php");?>
			
				<!-- FIRST ROW OF BLOCKS -->     
		
	<?php

		require('inc/body/block/profile-block.php');
		//require('inc/body/block/revenue-block.php');
		require('inc/body/block/time-block.php');
		require('inc/body/block/whois-block.php');
		require('inc/body/block/chat-block.php');
		//require('inc/body/block/template.php');
		require("inc/body/block/option-block.php");
		require("inc/body/block/qr-block.php");
		require("inc/body/block/cast-block.php");


		?>

	</div>
<?php }?>
	<div id="footerwrap">
      	<footer class="clearfix"></footer>
      	<div class="container">
      		<div class="row">
      			<div class="col-sm-12 col-lg-12">
      			<p><img src="assets/img/logo.png" alt=""></p>
      			<p>Blocks Dashboard Theme - Crafted With Love - Copyright 2013</p>
      			</div>

      		</div><!-- /row -->
      	</div><!-- /container -->		
	</div><!-- /footerwrap -->

	<script type="text/javascript" src="assets/js/blocks.js"></script>
    <?php require("lib/phathDebug/display.php"); ?>
</body>
<body>
	<?php //require('inc/body/splash.php');?>
	
	<?php 
		//user stuff
		
		require_once('inc/body/user/users-db.php');
		
	?>

	<?php 
		$user = "Christoph";
		$profession="Developer Lead";
		$imageUrl = "assets/img/face80x80.jpg";
		$alt = "Christoph";
	?>
    <?php require('inc/body/nav.php');?>
    <?php //require('inc/body/drop-grid.php');?>
	<?php require('inc/body/grid.php')?>

	<div id="footerwrap">
      	<footer class="clearfix"></footer>
      	<div class="container">
      		<div class="row">
      			<div class="col-sm-12 col-lg-12">
					<p><img src="assets/img/logo.png" alt=""></p>
					<p>Blocks Dashboard Theme - Crafted With Love - Copyright 2021</p>
      			</div>

      		</div><!-- /row -->
      	</div><!-- /container -->		
	</div><!-- /footerwrap -->

	<script type="text/javascript" src="assets/js/blocks.js"></script>
    <?php require("lib/phathDebug/display.php"); ?>
</body>
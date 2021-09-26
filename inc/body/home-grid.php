

<div id="block_grid" class="container block-flat">
<div class="grid-title" style="font-size:36px; left:400px; top:200px;">Home Grid</div>

		<?php require("inc\body\block\block-components\blockConstruct.php");?>
		<?php require("inc\body\block\block-components\blockFunc.php");?>
		
		<!-- FIRST ROW OF BLOCKS -->     
		<script src="./assets/node_modules/gridstack/dist/gridstack.all.js"></script>
		<link href="./assets/node_modules/gridstack/dist/gridstack.min.css" rel="stylesheet"/>
		<style type="text/css">
			.grid-stack { background: #00000000; }
			.grid-stack-item-content { background-color: #18BC9C; }
		</style>
		
		<div class="grid-stack">
		<?php
			require('inc/body/block/profile-block-grid.php');
			require('inc/body/block/option-block-grid.php');
			require('inc/body/block/time-block-grid.php');
			require('inc/body/block/file-browser-block-grid.php');
			require('inc/body/block/chat-block-grid.php');
			require('inc/body/block/whois-block-grid.php');
			//require('inc/body/block/frame-block-grid.php');
			//require('inc/body/block/trends-block-grid.php');
			//require('inc/body/block/name-block-grid.php');
		?>

		<script>
			
			var profileBlock = `<?=$profileBlock;?>`;
			var timeBlock = `<?=$timeBlock;?>`;
			var filesBlock = `<?=$filesBlock;?>`;
			var chatBlock = `<?=$chatBlock;?>`;
			
		</script>

		</div>
		<script type="text/javascript">
		

		var items = [
			{width: 3,height:4, content: profileBlock}, 
			{width: 3, height:2, content: timeBlock},
			{width: 3, height:2, content: filesBlock},
			{width: 3, height:2, content: chatBlock}
            
		];
		var grid = GridStack.init();
		grid.load(items);
		</script>
		

	</div>
<?=smBlockStart();?>
	      		<dtitle>Total Subscribers</dtitle>
	      		<hr>
	      		<div class="cont">
                    <p><bold>14.744</bold></p>
                    <p>98 Subscribed Today</p>
	      		</div>
			  <?=smBlockMid();?>
			  <?=setTitle("Chat");?>

				<hr>
				<?=modalStart('chatModal', ['launch-button']);?>

									<div class="chat-container">
										<div class="chat-box"></div>
										<div class="chat-input-box"><input class="chat-input"></div>
										<button type="button" id="post-button" onclick="onClick();" class="btn launch-button">Send</button>
									</div>
									
								<?=modalEnd();?>
						<script src="inc/body/block/block-components/js/chat.js"></script>
					
				
<?=blockEnd();?>
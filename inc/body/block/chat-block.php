<?=smBlockStart();?>
	
	<?=setTitle("Chat");?>
	<hr>
	<?=modalStart('chatModal', ['launch-button'],"Chat Block");?>
		<div class="chat-container" style="word-wrap: break-word;">
			<div class="chat-box"></div>
			<div class="chat-input-box"><input class="chat-input"></div>
			<button type="button" id="post-button" onclick="onClick();" class="btn launch-button">Send</button>
		</div>
	<?=modalEnd();
	
	?>
	<?=blockScript("dash/inc/body/block/block-components/js/chat.js"); 
	
	?>
<?=blockEnd();?>

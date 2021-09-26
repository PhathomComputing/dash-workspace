<?php $template = ``;
$template.=smBlockStart();
$template.=setTitle("Chat");
$template.='<hr>';
$template.=``;

$template.=modalStart('chatModal', ['launch-button'],"Chat Block");
$template.='
		<div class="chat-container" style="word-wrap: break-word;">
			<div class="chat-box"></div>
			<div class="chat-input-box"><input class="chat-input"></div>
			<button type="button" id="post-button" onclick="onClick();" class="btn launch-button">Send</button>
		</div>';
$template.=modalEnd();
// $template.=blockScript("inc/body/block/block-components/js/chat.js"); 
$template.=blockEnd();
$chatBlock=$template;
?>
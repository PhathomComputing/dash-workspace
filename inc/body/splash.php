<div id="splash-logo" class="loading"  onclick="removeSplash();" style="text-align:center;background-color:black;z-index:1000;width:100%;height:100%;position:fixed;top:0;left:0;">
        <div class="loading-logo">
            <img style="width:100%;" src="assets/img/twirk3d.png">
        </div>
	</div> 
	<script>
        function hideSplash(){
			$('#splash-logo').animate({'opacity':'0'},3000,function(){
				$('#splash-logo').css({'display':'none'});
			});
        }

        $(document).ready(function(){
			setTimeout(hideSplash(),3000);
        });
        function removeSplash(){
            $('#splash-logo').css({'display':'none'});
        }
		
		
        
    </script>
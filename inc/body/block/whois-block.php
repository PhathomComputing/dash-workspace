<?=mbBlockStart();?>
        <?=setTitle('WhoIs');?>
        <?=whoisBlock();?>
        <?php 
                if(isset($_POST['whois_url'])){
                        $result = whois($_POST['whois_url']);

                        if(empty($result)){
                                echo '
                                        <span class="error-code">No nic servers detected!</span>
                                        '.$result;
                        } else {
                                echo '<div      style="background-color:black;font-size:.5em;"
                                                class="whois-result">'.$result.'</div>';
                        }
                        
                }
        ?>
        
</form>   


<?=blockEnd();?>
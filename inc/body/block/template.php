<?=mbBlockStart();?>

	<?=setTitle('feed');?>

	<article>
            

            <table class="visible">
                <tr>
                    <td style="text-align: right;">
                        <input type="text" id="conference-name" placeholder="Broadcast Name">
                    </td>
                    <td>
                        <button id="start-conferencing">New Broadcast</button>
                    </td>
                </tr>
            </table>
            <table id="rooms-list" class="visible"></table>

            <table class="visible">
                <tr>
                    <td style="text-align: center;">
                        <h2>
                            <strong>Private Broadcast</strong> ?? <a href="" target="_blank" title="Open this link in new tab. Then your broadcasting room will be private!"><code><strong id="unique-token">#123456789</strong></code></a>
                        </h2>
                    </td>
                </tr>
            </table>

            <div id="participants"></div>

            <script src="assets/js/RTC/adapter.js"></script>
            <script src="assets/js/RTC/socket.io.js"> </script>
            <script src="assets/js/RTC/rtcPeerConnection.js"> </script>
            <script src="assets/js/RTC/broadcast.js"> </script>
            <script src="assets/js/RTC/broadcast-ui.js"> </script>
        </article>
<?=blockEnd();?>

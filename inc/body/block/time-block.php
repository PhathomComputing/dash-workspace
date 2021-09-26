
<?=smBlockStart();?>
    <?=setTitle('Local Time');?>
    <hr>
    <div class="clockcenter">
        <script>
            var jun = moment("2014-06-01T12:00:00Z");
            console.log(jun.tz('America/Los_Angeles').format('ha z'));
        </script>
        <digiclock></digiclock>
        <div id="utc-clock"></div>

        <script>
            setInterval(function()=>{
                var hours = getUTCHour();
                var minutes = getUTCMinutes();
                var msec = getUTCMilliseconds();
                console.log(hours+":"+minutes+":"+msec);
            },1000);

        </script>
    </div>
<?=blockEnd();?>
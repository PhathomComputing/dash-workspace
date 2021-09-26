<?php
?>
<div id="debugWindow" class="debug-widget" style="border-radius:10px;padding:15px;position:fixed;top:25%;left:0px;z-index:110; width:600px; height:60%; background-color:rgba(200,150,150,.9);left:-590px" >
  <div style="position:relative;width:100%; height:30px;">
    <span style="position:relative;padding:10px;"><b>Debug Console</b></span>
    <div id="debug-toggle" style="position:relative;"></div>
  </div>
  <div class="log-box" style="">
    <p>
      <?php
        function recString($data){
          if(is_array($data)){
            recString($data);
          }else{
            return $data;
          }
        }

        if(isset($debug ))
        {
          $txt = "";

          foreach ($debug as $key => $value) {
            if(is_array($value)){
              print_r($value);
              echo "\n";
              
             
            } else {
              echo $value;
              $txt .= $value."\n";

            }
            file_put_contents($ROOT.'/inc/lib/phathDebug/logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

            echo "</br>=======================================</br>";
          }
          
        } 
      ?>
    </p>
  </div>
  <div id="debugControl" class="debug-control" style="">
    <b>
      <a><button id="debug-hide" class="debug-toggle glyphicon-minus"></button></a>
      <a><button id="debug-show" class="debug-toggle glyphicon-plus"></button></a>
    </b>
  </div>
</div>

<script type="text/javascript">
  $("#debug-hide").click(function(){
    $("#debugWindow").animate({left:'-590px'});
  });

  $("#debug-show").click(function(){
    $("#debugWindow").animate({left:'0px'});
  });

  function hideDebug(){
    $("#debugWindow").animate({left:'-590px'});
  }
  function showDebug(){
    $("#debugWindow").animate({left:'0px'});
  }
window.onload = function() {
    if (window.jQuery) {  
        // jQuery is loaded  
        console.log("Debug: JQuery Active!");
    } else {
        // jQuery is not loaded
        console.log("Debug: JQuery Not Detected.");
    }
    
}

console.log($('.log-box')[0].innerText);
    if($('.log-box')[0].innerText != ''){
      showDebug();
    }
</script>

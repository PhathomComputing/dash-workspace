<?php
$debug=[];
$count=0;
function add_checkpoint($check){
  global $count;
  global $debug;
  $debug[$count]=$check;
  $count++;
}

function debug_report($check)
{

  echo '
    <script>
      alert("'.$check.';");
    </script>
    ';
}

function clear_debug(){
  $count = 0;
  $debug = [];
}

?>

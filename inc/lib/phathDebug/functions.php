<?php
$debug=[];
$count=0;
function dbg_check($check){
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
//maybe add js debug options
?>

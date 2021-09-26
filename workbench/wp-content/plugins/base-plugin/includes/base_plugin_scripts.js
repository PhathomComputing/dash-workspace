jQuery(document).ready( function() {
   var url = window.location;
   var search = url.href.search('timezone-settings');
   var timeout = 3000;

   if(typeof(search) !== 'undefined'){
               if(search>0){
                    statusCall();
                    setInterval(statusCall,timeout);
               }
   }

   function statusCall(){
      var adata ={action: "query_manager",task:"status-box"};
      jQuery.ajax({
         type : "post",
         // dataType : "json",
         url : 'myAjax.ajaxurl',
         data : adata,
         success: function(response) {
                statusBox(response);
            },
            error:function(response){
                console.log("Issue connecting to action: ");
                console.log("action: ");
                console.log(response);
                console.log(adata);
            }
        });
   }
   
   function statusBox(response){
    str = response.substring(response.length-5, response.length);
    if(str.trim() == "NULL"){
       response = response.substring(0, response.length-5);
       
    }
    
    response = JSON.parse(response);
    if(response.type == "success") { 

        whoRan = {'update':'','processing':'','cron_job':'','processing':''};

        if( statusDisplay = document.getElementById('status-box') ){
            statusUpdate = statusDisplay.querySelector('#update-msg>i').innerText;
            statusProcessing = statusDisplay.querySelector('#processing-msg>i').innerText;
            statusCronJob = statusDisplay.querySelector('#cron-job-msg>i').innerText;
            statusProcesses = statusDisplay.querySelector('#processes-msg>i').innerText;
            // console.log(statusDisplay);
            // console.log(statusUpdate);
        }
        


        $msg = [];
        if(response.response.update == ''){
            $msg['update'] = "Waiting Response...";
        } else {
            $msg['update'] = response.response.update;
            if(statusDisplay && response.response.update != statusUpdate){
                whoRan['update'] = 'style="background-color:rgba(150,255,150,0.5);"';
            }

        }
        if(response.response.processing == ''){
            $msg['processing'] = "Waiting Response...";

        } else {
            $msg['processing'] = response.response.processing;
            if(statusDisplay && response.response.processing != statusProcessing){
                whoRan['processing'] = 'style="background-color:rgba(150,255,150,0.5);"';
            }

        }
        if(response.response.cron_job == ''){
            $msg['cron_job'] = "Waiting Response...";

        } else {
            $msg['cron_job'] = response.response.cron_job;
            if(statusDisplay && response.response.cron_job != statusCronJob){
                whoRan['cron_job'] = 'style="background-color:rgba(150,255,150,0.5);"';
            }

        }
        if(response.response.processes == ''){
            $msg['processes'] = "Waiting Response...";

        } else {
            $msg['processes'] = response.response.processes;
            if(statusDisplay && response.response.processes != statusProcesses){
                whoRan['processes'] = 'style="background-color:rgba(150,255,150,0.5);"';
            }
        }
        //console.log($msg);
        document.getElementById('b2b_status_container').innerHTML = `
        <div id="status-box">
            <br><span id="update-msg" `+whoRan['update']+`><b>Update: </b><i>`+$msg['update']+`</i></span>
            <br><span id="processing-msg" `+whoRan['processing']+`><b>Processing: </b><i>`+$msg['processing']+`</i></span>
            <br><span id="cron-job-msg" `+whoRan['cron_job']+`><b>Schedule: </b><i>`+$msg['cron_job']+`</i></span>
            <br><span id="processes-msg" `+whoRan['processes']+`><b>Processes: </b><i>`+$msg['processes']+`</i></span>
        </div>
        `;

        }
        else {
        console.log("Issue with status update.");
        console.log(response);
        
        }
   }

   
 });
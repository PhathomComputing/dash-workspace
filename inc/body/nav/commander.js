$(document).ready(function(){
    console.log("Search Loaded");
    var cmder = $('#commander-input');

    var navbar = $('#menu-bar');
    var button = $('.navbar-toggle');
    button.click(function(){
        if(navbar.hasClass('open')){
            
            //console.log('click');
            
            navbar.animate({height:'0px'},1000,function(){
                navbar.css({'display':'none'});
            });
            navbar.removeClass('open');
            
        } else {
            //console.log('click');

            navbar.css({display:'block'});
            navbar.animate({height:'200px'},1000);

            navbar.addClass('open');
        }
    });
});

document.getElementById("commander-input").focus();
// loading = false;

var searchThis='search';
  class navCommand{
        siteNav;
        siteList; 

        constructor(){
          this.searchNav = ['google','yahoo','bing','udemy','youtube','duckduckgo'];
          this.siteList = sitesList;
        }
        //https://www.marketwatch.com/tools/ipo-calendar
        printCommands(){
          var list = Object.getOwnPropertyNames(this.siteList);
          var sites = this.siteList;
          
          list.forEach((key)=>{

            var printCon = key+' |--> '+sites[key]['cmd'];
            
            console.log(printCon );
          });
        }

        getURLs(){
          return this.siteList;
        }
        
        jsonCall(){
          
          if(confirm("Custom URL?")){
            var url = prompt("What is the url?");
            var data = prompt("What is the JSON string?");
          }else{
            var url = '';
            var data = '';
          }
          if(data ==''){
            data = ``;
          }
          if(url ==''){
            var zipcode = "32825";
            url = "http://api.openweathermap.org/data/2.5/weather?zip="+zipcode+",&appid=c065bad95ccc4c10390a416e5be1705b"
            //url = "http://api.openweathermap.org/data/2.5/forecast?id=524901&appid=c065bad95ccc4c10390a416e5be1705b";
          }
          $.ajax({
            url:url,
            data:data,
            success:function(res){
              console.log("======================================");
              console.log(res);
            },
            error:function(res){
              console.log(res);
            }
          });
        }
  }

  var comm = new navCommand();



 


  function commander(val){
    var urls = comm.getURLs();
    
    if(Array.isArray(val)){

    }else{
      var cmds = val.split(" ");
      var engine = cmds[0];
      var newTab = "True";

      if(engine == "curlTest()"){
        alert("Ready");
      }
      //console.log();
      var props = Object.getOwnPropertyNames(urls);
      var foundCmd = false;
      props.forEach((key)=>{
        // go through each array item

        if(urls[key]['cmd'].includes(engine.toLowerCase())){


          foundCmd = true;
          var params = cmds.splice(1,cmds.length);
          var search="";
          console.log("detected cmd");
          var buildUrl = urls[key]['sub']+urls[key]['domain'];


          if(urls[key]['rss'].includes("*V*")){
            buildUrl = urls[key]['sub']+urls[key]['domain']+urls[key]['rss'].replace("*V*",params[0]);
          }
          else if(urls[key]['rss']){
            buildUrl+=urls[key]['rss'];
            for(var i =0; i < params.length; i++){
              if(newTab == params[i]){
                newTab = 'True';
              }else{
                search += params[i];
                if(i+1==params.length){
                
                }else{
                  
                  search += "%20";
                }
              }
              
            }
            buildUrl += search;
          }
          


          if(urls[key]['vars']){
            buildUrl+="?";
            var paramN=0;
            urls[key]['vars'].forEach(item=>{
              if(Array.isArray(item)){
                buildUrl+=item[0]+'='+item[1];

              }else{
                if(item == "text" || item == "q" || item == "p"){
                  var searchText = params.splice(paramN, params.length);
                  //console.log(searchText);
                  var translateText='';
                  for(var i =0; i < params.length+1; i++){
                    translateText += searchText[i];
                    if(i+1==params.length){
                      
                    }else{
                      translateText += "%20";
                    }
                    //console.log(translateText);
                  }

                  buildUrl+=item+'='+translateText;
                }else{
                  buildUrl+=item+'='+params[paramN];

                }
                paramN++;
              }
              buildUrl+="&";
            });
            //console.log(paramN);
            
          }
          


          //console.log(buildUrl);
          if(newTab == "True"){
            window.open(buildUrl,"_blank");

          }else{
            window.location.assign(buildUrl);

          }



        }else{
          // no cmd detected per item in array
          
          
         
        }
      });


      if(foundCmd == false){
        // no cmd was found through whole array
          // if(loading == true){

          // }else{
            var val = document.getElementById("commander-input").value;
            // loading = true;
            commander("g> "+val);
          // }
      }



    }
  }


  function commandType(cmd){
    var val = document.getElementById("commander-input").value;
    if(cmd == "yahoo-finance"){
      searchValue("$> "+val)
    }
    else if(cmd == "bing"){
      searchValue("bing> "+val);
    }
    else if(cmd == "yahoo"){
      searchValue("yahoo> "+val);
    }
    else if(cmd == "google"){
      searchValue("google> "+val);
    }
    else if(cmd == "search"){
      //search area
    }
    else if(cmd == "blocks"){
      // blocks area
    }
    else if(cmd == "commands"){
      searchValue("command> "+val);
    }
    else if(cmd == "settings"){
      // settings area
    }
  }


  function fileNav(val,cmds){
      console.log(val);
      dir = '';
      file = cmds[1];
      localhost = "http://localhost/";
      if(file=="root"){
        dir = localhost+"/";
      }else if(file=="wordpress"){
        dir = localhost+"/";
      }
      engine=dir;
      return engine;
  }


  function directInput(data){
      console.log(data);
      
      searchValue(data);
      
    
  }


  $('#commander-input').keypress(function(key){
    if(key.which == 13){
      
      var input = $('#commander-input').val();
      if(input.toLowerCase() == "menu"){
        comm.printCommands();
      }else if(input.includes('.com')){
        window.open("http://www."+input,"_blank");
        
      }else if(input.toLowerCase() =='php>curl'){
        $.ajax({
          method:"POST",
          url:"http://localhost/dash/inc/body/nav/php-tools/curl-call.php",
          success:function(){
            alert("Ok");
          },
          error:function(){
            alert("Nope");
          }
        })
        
      }else if(input.toLowerCase() =='ajax>curl'){
        $.ajax({
          method:"GET",
          url:"https://api-m.sandbox.paypal.com/v2/invoicing/invoices?total_required=true",
          headers: {
            "Content-type":"application/json",
            "Authorization":"Bearer A21AAJ_ouWJlu1JxL_ayh7IwGFgPbik9fdthNQXiGRjBomMp9dOEkZK2W6GTW8n8AXpwHnMUhdQ5Gd3nJM4JYWZU-IPuu42bg"
          },
          success:function(data){
            console.log(data);
            alert("Ok");
          },
          error:function(){
            alert("Nope");
          }
        })
        
      }else {
        if(input.split(" ")[0]=='json>'){
          comm.jsonCall();
        }
        commander( input );

      }
    }
  });


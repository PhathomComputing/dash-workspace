
    //   if(engine.toLowerCase() == "google>" || engine.toLowerCase() == "g:"){
    //     engine=urls['google']['sub']+urls['google']['domain']+urls['google']['rss'];

    //   }else if(engine.toLowerCase() == "yahoo>" || engine.toLowerCase() == "y:"){
    //     engine="https://search.yahoo.com/search?p=";

    //   }else if(engine.toLowerCase() == "bing>" || engine.toLowerCase() == "b:"){
    //     engine="https://www.bing.com/search?q=";

    //   }else if(engine.toLowerCase() == "duckduckgo>" || engine.toLowerCase() == "d:"){
    //     engine="https://duckduckgo.com/?q=";

    //   }else if(engine.toLowerCase() == "youtube>" || engine.toLowerCase() == "yt:"){
    //     engine="https://www.youtube.com/results?search_query=";

    //   }else if(engine.toLowerCase() == "command>" || engine.toLowerCase() == ">>"){
    //     commander(cmds);
    //     return ;

    //   }else if(engine.toLowerCase() == "files>" || engine.toLowerCase() == "//"){
    //     engine = fileNav(val,cmds);

    //   }else if(engine.toLowerCase() == "trends>" || engine.toLowerCase() == "?>"){
    //     engine="https://trends.google.com/trends/explore?date=all&q=";

    //   }else if(engine.toLowerCase() == "photos" || engine.toLowerCase() == "camera>"){
    //     engine="https://photos.google.com/";

    //   }else if(engine.toLowerCase() == "tutor" || engine.toLowerCase() == "tl>"){
    //     engine="https://takelessons.com/provider";

    //   }else if(engine.toLowerCase() == "stocks" || engine.toLowerCase() == "robin"){
    //     engine="https://robinhood.com/";

    //   }else if(engine.toLowerCase() == "calendar>" || engine.toLowerCase() == "c:"){
    //     engine="https://calendar.google.com/calendar/u/1/r/weeknhood.com/";

    //   }else if(engine.toLowerCase() == "finance>" || engine.toLowerCase() == "$>"){
    //     engine="https://finance.yahoo.com/quote/?p=";

    //   }else if(engine.toLowerCase() == "class>" || engine.toLowerCase() == "u>"){
    //     engine="https://www.udemy.com/home/my-courses/search/?q=";

    //   }else if(list.includes(engine) || engine.toLowerCase() == "u>"){
    //     engine="https://www."+engine+".com";
    //     window.open(engine,"_blank");
    //     return;

    //   }else if(list.join('|').indexOf(engine)>=0){
    //     var loc = list.join('|').indexOf(engine);
    //     console.log("nothing yet...");p
    //     return;

    //   }else{
    //     if(val.search('.com') != -1){
    //       engine="http://"+val;pp
    //       console.log(engine);

    //     } else {
    //       engine=urls['google']['sub']+"google.com/search?q=";
    //       console.log(engine);
    //       defSearch = true;

    //     }
    //   }
    //   if(defSearch){
    //     cmds = cmds.splice(0,cmds.length);
        
    //   }else{
    //     cmds = cmds.splice(1,cmds.length);
        
    //   }
    //   var val="";

    //   for(var i =0; i < cmds.length; i++){
    //     val += cmds[i];
    //     if(i+1==cmds.length){

    //     }else{
    //       val += "%20";
    //     }
    //   }
    //   // console.log(cmds);
    //   // console.log(val);
    //   window.open(engine+val,"_blank");
    // }
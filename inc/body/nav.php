<!-- NAVIGATION MENU -->
<nav>
  <script>
  var searchThis='search';
  function searchType(type){
    searchThis = type;
  }
  </script>
<div class="navbar navbar-expand-lg navbar-nav navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button  type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-bar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div> 
    <div id="menu-bar" class="navbar-collapse collapse" style="height:auto;">
      <ul class="nav navbar-nav">
        <li class="active"><a href="../dashboard/"><i class="icon-home icon-white"></i>XamppCP</a></li>
        <li><a href="../phpmyadmin/"><i class="icon-folder-open icon-white"></i> DB</a></li>
        <li><a href="../root/"><i class="icon-folder-open icon-white"></i> Root</a></li>
        
      </ul>
    </div><!--/.nav-collapse -->
    <div class="commander-container">
      <input id="commander-input" class="form-control form-control-dark search-nav" type="text" placeholder="Search" aria-label="Search">
      <div class="commander-options"><div class="command-type">
        <a><span class="glyphicon glyphicon-search" onclick="searchType('search')" aria-hidden="true"></span></a> 
        <a><span class="glyphicon glyphicon-th-large" onclick="searchType('blocks')" aria-hidden="true"></span></a> 
        <a><span class="glyphicon glyphicon-th-list" onclick="searchType('commands')" aria-hidden="true"></span></a> 
        <a><span class="glyphicon glyphicon-cog" onclick="searchType('settings')" aria-hidden="true"></span></a> 
      </div>
    </div>
      <script src="inc/body/nav/commander.js"></script>
      <a class="navbar-brand" href="index.php">
        <img src="assets/img/logo.png" alt=""> 
      </a>
    </div>
    

  </div>
</div>
</nav>
<script>
 
  function directInput(data){
    console.log(data);
    
      data = data.replace(' ','+');
      data = 'search?q='+data;
      //window.location.replace('http://www.google.com/'+data);
      window.open(
        'http://www.google.com/'+data,
          '_blank' // <- This is what makes it open in a new window.
      );
    
  }
  $('#commander-input').keypress(function(key){
    if(key.which == 13){
      directInput( $('#commander-input').val());
    }
  });
</script>





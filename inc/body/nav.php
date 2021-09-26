<!-- NAVIGATION MENU -->
<nav>
  
<div class="navbar navbar-expand-lg navbar-nav navbar-inverse navbar-fixed-top">
  <div class="container top-container" >

    <div class="navbar-header">
        <button type="button" class="navbar-toggle" >

        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div> 
    <div id="menu-bar" class="collapse" style="height:auto;">

        <ul class="nav navbar-nav">
        <li><a href="../dashboard/" target="_blank"><i class="icon-home icon-white"></i>XamppCP</a></li>
        <li><a href="../phpmyadmin/" target="_blank"><i class="icon-folder-open icon-white"></i> DB</a></li>
        <li><a href="../root/" target="_blank"><i class="icon-folder-open icon-white"></i> Root</a></li>
        <li><a href="./workbench/" target="_blank"><i class="icon-folder-open icon-white"></i> WorkBench</a></li>
        
      </ul>
    </div><!--/.nav-collapse -->
    <div class="commander-container">
      <input id="commander-input" autocomplete="on" class="form-control form-control-dark search-nav" type="text" placeholder="Search" aria-label="Search">
      
      <div class="commander-options"><div class="command-type">
      <a><span class="glyphicon search-btn" onclick="commandType('yahoo-finance')" aria-hidden="true">$</span></a> 
        <a><span class="glyphicon search-btn" onclick="commandType('bing')" aria-hidden="true">B</span></a> 
        <a><span class="glyphicon search-btn" onclick="commandType('yahoo')" aria-hidden="true">Y</span></a> 
        <a><span class="glyphicon search-btn" onclick="commandType('google')" aria-hidden="true">G</span></a> 
|
        <a><span class="glyphicon  search-btn glyphicon-search" onclick="commandType('search')" aria-hidden="true"></span></a> 
        <a><span class="glyphicon  search-btn glyphicon-th-large" onclick="commandType('blocks')" aria-hidden="true"></span></a> 
        <a><span class="glyphicon  search-btn glyphicon-th-list" onclick="commandType('commands')" aria-hidden="true"></span></a> 
        <a><span class="glyphicon  search-btn glyphicon-cog" onclick="commandType('settings')" aria-hidden="true"></span></a> 
      </div>
    </div>
      <a class="navbar-brand" href="index.php">
        <img src="assets/img/logo.png" alt=""> 
      </a>
    </div>
    

  </div>
</div>
</nav>

<script>
  var sitesList;
  function importSites(data){
    sitesList = data;
  }
</script>
<script src="inc/body/nav/sitesList.js"></script>

<script src="inc/body/nav/commander.js"></script>





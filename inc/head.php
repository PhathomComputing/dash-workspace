
<!doctype html>
<html><head>
    <meta charset="utf-8">

    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Carlos Alvarez - Alvarez.is">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/flexslider.css" rel="stylesheet">
    <link href="assets/css/jquery-ui.css" rel="stylesheet">
    <link href="assets/css/font-style.css" rel="stylesheet">

    <?php 
    $_SESSION['theme'] = 'light';
    if(!isset($_SESSION['theme'])){
      ?><link href="assets/css/main.css" rel="stylesheet"><?php
    } else if( $_SESSION['theme']=='light'){
     ?><link href="assets/css/main-white.css" rel="stylesheet"><?php
    }
    
    ?>
    


    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">
  	<!-- Google Fonts call. Font Used Open Sans & Raleway -->

    <!-- Script Load-->
    <script src="assets/node_modules/jquery/dist/jquery.js"></script>

    <script src="assets/js/jquery-ui.js"></script>
    <script src="assets/node_modules/moment/moment.js"></script>
    <script src="assets/node_modules/moment-timezone/moment-timezone.js"></script>
    <script src="assets/node_modules/google-trends-api/lib/google-trends-api.min.js"></script>
    <script>
      if(!location.hash.replace('#', '').length) {
            //location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
            
      }
      console.log(location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', ''));
    </script>
    <script src="https://cdn.webrtc-experiment.com/socket.io.js"> </script>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://cdn.webrtc-experiment.com/IceServersHandler.js"></script>
    <script src="https://cdn.webrtc-experiment.com/getScreenId.js"> </script>
    <script src="https://cdn.webrtc-experiment.com/CodecsHandler.js"></script>
    <script src="https://cdn.webrtc-experiment.com/BandwidthHandler.js"></script>
    <script src="https://cdn.webrtc-experiment.com/screen.js"> </script>
    <script src="https://cdn.webrtc-experiment.com/meeting.js"></script>
    <script src="inc/body/block/block-components/js/chat.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7CZTYG3V8P"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-7CZTYG3V8P');
    </script>
    <?php ?>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    

    
    
  </head>
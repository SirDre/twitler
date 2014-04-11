<?php
  session_start();
  
  define('AUTH_CHECK',1);
  include_once("config.php");
  include_once("libs/twitteroauth.php");

?>
 
<html>
<head>
<title>Twitler Response</title>

<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />

<script type="text/javascript" src="assets/js/script.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

</head>
<body>
<div class="container">
 <div class="col">
 
<?php
 

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    
    echo '<div id="twitter-container">';
    
    echo ' <h2>Happy Tweeting</h2>';
    echo ' <p> Twitler was send and twitler respond. </p>;
 
    echo ' <a href="https://twitter.com/SenorDre" class="twitter-follow-button" data-dnt="true" >Follow @SenorDre</a> ';
    
    echo ' <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> ';
  
    echo '<div class="info"> <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php"> Home </a> | <a href="index.php?reset=1">Logout</a>!</div>';
    
    echo '</div>';

?>

 </div>
</div>
</body>
</html>

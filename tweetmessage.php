<?php
session_start();

define('AUTH_CHECK',1);
include_once("config.php");
include_once("libs/twitteroauth.php");

 ?>
 
 <html>
<head>
<title>Thank you</title>


<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/scripts.js"></script>
 


</head>
<body>
<div class="wrapper">
<div id="twitter-container">
 <?php
 
 
	$screenname 		= $_SESSION['request_vars']['screen_name'];
	$twitterid 			= $_SESSION['request_vars']['user_id'];
	$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
	$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];

	

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
	
		 echo ' <h2>Thank you for Tweeting with Twitler</h2>';
		 echo '	<p>Thank you <b>'.$screenname.'</b>. Your tweet is live online and can be viewed by many.';
		 echo '	 </p>';
		 echo '	<p>&nbsp; </p>';
		 
		 echo ' <a href="https://twitter.com/SenorDre" class="twitter-follow-button" data-dnt="true">Follow @SenorDre</a> ';

         echo ' <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> ';
		 
			//Show welcome message
		 echo '<div class="info"> <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php"> Home </a> | <a href="index.php?reset=1">Logout</a>!</div>';

?>
</div>
</div>
</body>
</html>

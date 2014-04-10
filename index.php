<?php
	//start session
	session_start();
	
	if($_GET["reset"]==1)
	{
	  session_destroy();
	  header('Location: ./index.php');
	}
	
	define('AUTH_CHECK',1);
	
	// Include config file 
	include_once("config.php");
	
	// remove tweets older than 12 hour to prevent spam
	//mysql_query("DELETE FROM demo_twitter_timeline WHERE id>1 AND dt<SUBTIME(NOW(),'0 12:0:0')");
	  
	//fetch the timeline
	$q = mysql_query("SELECT * FROM demo_twitter_timeline ORDER BY ID DESC");
	
	$timeline='';
	while($row=mysql_fetch_assoc($q))
	{
	  $timeline.=formatTweet($row['tweet'],$row['dt']);
	}
	
	// fetch the latest tweet
	$lastTweet = '';
	list($lastTweet) = mysql_fetch_array(mysql_query("SELECT tweet FROM demo_twitter_timeline ORDER BY id DESC LIMIT 1"));
	
	if(!$lastTweet) $lastTweet = "You don't have any tweets yet!";


?>

<html>
<head>
<title>Twitter Sign-in</title>

<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />

<script type="text/javascript" src="assets/js/scripts.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>


</head>
<body>
<div class="wrapper">
	<div id="twitter-container">
<?php

  if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
  {
  
  //Success, redirected back from process.php with varified status.
  	$screenname 		= $_SESSION['request_vars']['screen_name'];
  	$twitterid 		= $_SESSION['request_vars']['user_id']; 
  	$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
  	$oauth_token_secre	= $_SESSION['request_vars']['oauth_token_secret'];
  
  	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
   
   	//see if user wants to tweet using form.
    if(isset($_POST["twitler"]))   	{

	//Validate email address
	if(strlen($_POST['myemail']) < 7 || !preg_match("/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/",$_POST['myemail']))
	die("<h2>Hey, your email is invalid. </h2><p>&nbsp;</p<div class=\"welcome\"> <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href=\"index.php\"> Home </a> | <a href=\"index.php?reset=1\">Logout</a>!</div>");
	
	//Validate Text
	if(ini_get('magic_quotes_gpc'))
	$_POST['twitler']=stripslashes($_POST['twitler']);
	
	//Validate word count
	if(mb_strlen($_POST['twitler']) < 1 || mb_strlen($_POST['twitler'])>140)
	die("<h2>Hey, you typed too much text. Should be less than 141 char</h2><p>&nbsp;</p<div class=\"welcome_txt\"> <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href=\"index.php\"> Home </a> | <a href=\"index.php?reset=1\">Logout</a>!</div>");
	
	
	//Display widget for @SenorDre
	$my_update = $connection->post('friendships/create', array('screen_name' => 'SenorDre', 'follow' => TRUE));
	
	//Post my tweet to db
	mysql_query("INSERT INTO demo_twitter_timeline SET uid='".$twitterid."', sname='".$screenname."', tweet='".$_POST['twitler']."', dt=NOW(), name='".$_POST['tname']."', email='".$_POST['temail']."'");	 
	
	
	//Post my tweet to twitter
	$my_update = $connection->post('statuses/update', array('status' => $_POST["twitler"]));
  
    		 
	}
	


?>	
<?php
 
	echo '<h1>Welcome <strong> '.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>! </h1>';
?>
	
      <form action="index.php" method="post" >

	<span class="counter">140</span>
	
	<label > Name </label>	
	<input class="txt" name="myname" id="myname" type="text" value=""  />
	
	<label > email </label>	
	<input class="txt" name="myemail" id="myemail" type="text" value=""  />
	
	<label for="twitler">Tweet Text</label>
	<textarea name="twitler" id="twitler" tabindex="1" rows="2" cols="40"></textarea>
	
	<input class="submitButton inact" name="submit" type="submit" value="Tweet" />
	
	<span class="latest"><strong>Latest: </strong><span id="lastTweet"><?=$lastTweet?></span></span>
	<p>    
	<a href="https://twitter.com/SenorDre" class="twitter-follow-button" data-dnt="true">Follow @SenorDre</a> 
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</p>
	
	<div class="clear"></div>
	
	<input name="authenticity_token" type="hidden" value="CXz8yM9DNpjVOXrmnDIA50S8KNxP5WuKlHrEMUWZ" />
		
	</form>
	
	<h4 class="timeline">Timeline</h4>
	
	<ul class="statuses">
		
<?php
 
	//Get latest tweets
	$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $screenname, 'count' => 5));
	/* echo '<pre>'; print_r($my_tweets); echo '</pre>'; */
	
	echo '<div class="tweet_list"><strong>Latest Tweets : </strong>';
	echo '<ul>';
	foreach ($my_tweets as $my_tweet) {
		echo '<li>'.$my_tweet->text.' <br />-<i>'.$my_tweet->created_at.'</i></li>';
	}
	echo '</ul></div>';
		
?>
		
   </ul>


<?php
 
 
		
}else{
 
	echo ' <h2>Welcome to Twitler</h2>';
	echo ' <i>A twitter app for tweeting and storing tweets within your database</i>';
	echo ' <p>Use your Twitter account to sign-in. By signing in here, you can use Twitler </p>';
	
	//login button
	echo '<a href="process.php"><img src="assets/img/sign-in-with-twitter-l.png" width="151" height="24" border="0" /></a>';
	 
}

?>

   </div>
</div>
</body>
</html>

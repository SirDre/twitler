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
	include_once("libs/twitteroauth.php");

	
	// remove tweets older than 12 hour 
	//mysql_query("DELETE FROM demo_twitlerdb WHERE id>1 AND dt<SUBTIME(NOW(),'0 12:0:0')");


?>

<html>
<head>
<title>Twitter Sign-in</title>

<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="assets/js/scripts.js"></script> 


</head>
<body>
<div class="wrapper">
	<div id="twitter-container">
<?php

  if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
  {
	
	//Success, redirected back with varified status.
  	$screenname 		= $_SESSION['request_vars']['screen_name'];
  	$twitterid 		= $_SESSION['request_vars']['user_id']; 
  	$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
  	$oauth_token_secret	= $_SESSION['request_vars']['oauth_token_secret'];
  
  	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
   
   	//see if user wants to tweet using form.
    if(isset($_POST["twitler"]))   	{

	//Validate email address
	if(strlen($_POST['myemail']) < 7 || !preg_match("/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/",$_POST['myemail']))
	die('<h2>Hey, your email is invalid. </h2><p>&nbsp;</p<div class="welcome"> <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php"> Home </a> | <a href="index.php?reset=1">Logout</a>!</div>');
	
	//Validate Text
	if(ini_get('magic_quotes_gpc'))
	$_POST['twitler']=stripslashes($_POST['twitler']);
	
	//Validate word count
	if(mb_strlen($_POST['twitler']) < 1 || mb_strlen($_POST['twitler'])>140)
	die('<h2>Hey, you typed too much text. Should be less than 141 char</h2><p>&nbsp;</p<div class="info"> <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php"> Home </a> | <a href="index.php?reset=1">Logout</a>!</div>');
		
    //Post my tweet to db
	mysql_query("INSERT INTO demo_twitlerdb (`uid`, `sname`, `tweet`, `dt`, `name`, `email`) VALUES ('$twitterid', '$screenname', '".$_POST['twitler']."', NOW(), '".$_POST['myname']."', '".$_POST['myemail']."')")
	 or die(mysql_error()); 
 
	//Be friends with me
	$my_friendship = $connection->post('https://api.twitter.com/1.1/friendships/create.json', array('user_id' => 'SenorDre', 'follow' => TRUE));
	
	//Post my tweet to twitter
	$my_post = $connection->post('https://api.twitter.com/1.1/statuses/update.json', array('status' => $_POST["twitler"]));
  

    //redirect
  	header('Location: tweetmessage.php'); 
    		 
	}
	


?>	
<?php
 
	echo '<h2>Welcome <strong> '.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>! </h2>';
?>
	
    <form id="tweetForm" action="index.php" method="post" >

	<span class="counter">140</span>
	
	<label > Name </label>	
	<input class="input" name="myname" id="myname" type="text" value=""  />
	
	<label > email </label>	
	<input class="input" name="myemail" id="myemail" type="text" value=""  />
	
	<label for="twitler">Tweet Text</label>
	<textarea class="textarea" name="twitler" id="twitler" tabindex="1" rows="2" cols="40"></textarea>
	
	<input class="btn btn-primary" name="submit" type="submit" value="Tweet" />

	<p>    
	<a href="https://twitter.com/<?php echo ''.$screenname.''; ?>" class="twitter-follow-button" data-dnt="true">Follow @<?php echo ''.$screenname.''; ?></a> 
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</p>
	
	<div class="clear"></div>
	
	</form>
	
	<h4 class="timeline">Timeline</h4>
	
	<ul class="statuses">
		
		<?php
 
		//Get latest tweets
		$my_tweets = $connection->get('https://api.twitter.com/1.1/statuses/user_timeline.json?', array('screen_name' => $screenname, 'count' => 5));

		echo '<div class="tweet_list"><strong>Latest Tweets : </strong>';
		echo '<ul>';
		foreach ($my_tweets as $my_tweet) {
			echo '<li><img src="'. $my_tweet->profile_image_url_https .'" ><a href="https://twitter.com/'.$screenname.'">'.$my_tweet->text.' <br />-<i>'.$my_tweet->created_at.'</i></i></li>';
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
	echo '<a href="tweetverifier.php"><img src="assets/img/sign-in-with-twitter-l.png" width="151" height="24" border="0" /></a>';
	 
}

?>

   </div>
</div>
</body>
</html>

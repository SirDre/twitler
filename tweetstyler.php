<?php

session_start();
 
define('AUTH_CHECK',1);
include_once("config.php");
include_once("libs/twitteroauth.php");


function formatTweet($tweet,$dt)
{
	if(is_string($dt)) $dt=strtotime($dt);

	$tweet=htmlspecialchars(stripslashes($tweet));
    $screenname = $_SESSION['request_vars']['screen_name'];
	
 
	<li>
  	<a href="#"><img class="avatar" src="assets/img/avatar.jpg" width="48" height="48" alt="avatar" /></a>
  	<div class="tweetTxt">
  	<strong><a href="#">SenorDre</a></strong> '. preg_replace('/((?:http|https|ftp):\/\/(?:[A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?[^\s\"\']+)/i','<a href="$1" rel="nofollow" target="blank">$1</a>',$tweet).'
  	<div class="date"> $dt </div>
  	</div>
  	<div class="clear"></div>
	</li>';

}

?>

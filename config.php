<?php
if(!defined('AUTH_CHECK')) die('You are not allowed to execute this file directly');


//Replace * with your twitter application variables.
define('CONSUMER_KEY', '*******');
define('CONSUMER_SECRET', '*******');

define('OAUTH_CALLBACK', 'process.php');


// Database config 
$db_host		= 'localhost';
$db_user		= 'root';
$db_pass		= 'root1';
$db_database = 'twitler_db'; 


$link = mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysql_select_db($db_database,$link);
mysql_query("SET names UTF8");

?>

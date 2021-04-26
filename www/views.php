<?php

require_once('./lib/ExpressSessionHandler.php');
	  
use danfsd\ExpressSessionHandler;
	  
	  // This is the express-session's secret you defined in your NodeJS application
const SESSION_SECRET = "node.js rules";

$handler = new ExpressSessionHandler(SESSION_SECRET);

// Setting the Handler
session_set_save_handler($handler, true);

// Starting/Recoverying session
session_start();

// Populates $_SESSION['cookie'] with data that express-session requires
$handler->populateSession();

if (isset($_SESSION['views'])){
	$_SESSION['views']++;
} else {
	$_SESSION['views'] = 1;
}
echo 'アクセス数: ' . $_SESSION['views'];
//var_dump($_SESSION);
//var_dump($_COOKIE);
?>

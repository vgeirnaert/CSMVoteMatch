<?php 
// load our variables
// ../config.php is stored outside the webtree
include_once '../config.php';

//========================================================
// Connect to the database
//
// returns MySQLi connection
//========================================================
function connectDB()
{
	$mysqli = new mysqli(Config::db_server, Config::db_username, Config::db_password, Config::database);
	
	return $mysqli;
}

//========================================================
// Disconnect
//========================================================
function disconnectDB($mysqli) {
	$mysqli->close();
}

?>
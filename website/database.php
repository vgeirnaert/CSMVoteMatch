<?php 
// load our variables
// ../config2.php is stored outside the webtree
require_once '../config2.php';




function disconnectDB($mysqli) {
	$mysqli->close();
}

class VotematchDB {
	private static $conn = NULL;
	private static $numconn = 0;
	
	public static function getConnection() {
		// if the connection isn't set yet
		if(self::$conn == NULL || self::$conn->connect_errno) {
			self::$conn = self::connectDB(); // connect
		}
		
		self::$numconn++;
		
		return self::$conn;
	}
	
	//========================================================
	// Connect to the database
	//
	// returns MySQLi connection
	//========================================================
	private static function connectDB() {
		$mysqli = new mysqli(Config::db_server, Config::db_username, Config::db_password, Config::database);
		
		return $mysqli;
	}
	
	//========================================================
	// Disconnect
	//========================================================
	public static function close() {
		// if it's an object
		if(self::$conn != NULL) {
			self::$numconn--;
			// and if the connection exists without error AND if we have no other open connections anymore
			if(!self::$conn->connect_errno && self::$numconn < 0) {
				// close it
				self::$conn->close();
				self::$conn = NULL;
				
			}
		}
	}
}
?>
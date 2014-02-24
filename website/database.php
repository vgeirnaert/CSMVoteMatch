<?php 
// load our variables
// ../config2.php is stored outside the webtree
require_once '../../../configs/votematch/eve_vm.php';

function disconnectDB(&$pdo) {
	$pdo=NULL;
}

class VotematchDB {
	private static $conn = NULL;
	private static $numconn = 0;
	
	public static function getConnection() {
		// if the connection isn't set yet
		if(self::$conn == NULL) {
			try {
				self::$conn = self::connectDB(); // connect
			} catch (Exception $e) {
				throw new Exception($e->getMessage()); 
			}
		}
		
		self::$numconn++;
		
		return self::$conn;
	}
	
	//========================================================
	// Connect to the database
	//
	// returns PDO connection
	//========================================================
	private static function connectDB() {
		try {
			$connection = new PDO('pgsql:host=' . Config::db_server . ';dbname=' . Config::database, Config::db_username, Config::db_password);
			$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // PDO::ERRMODE_SILENT or PDO::ERRMODE_WARNING
			return $connection;
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	//========================================================
	// Disconnect
	//========================================================
	public static function close() {
		// if it's an object
		if(self::$conn != NULL) {
			self::$numconn--;
			// and if the connection exists without error AND if we have no other open connections anymore
			if(self::$numconn < 0) {
				// close it
				self::$conn = NULL;
				
			}
		}
	}
	
	public static function bindAll($stmt, $ar_columns) {
		for($i = 0; $i < count($ar_columns); $i++) {
			$stmt->bindColumn($i + 1, $ar_columns[$i]);
		}
	}
}
?>
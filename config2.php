<?php
class Config {
	// database server vars
	const db_server = '255.255.255.255';
	const db_username = 'myusername';
	const db_password = 'mypassword';
	
	// database vars
	const database = 'mydb';
	
	// website vars
	const active_election = 1; // database id
	const matching_active = 1; // 0 = matching disabled (candidates can set/edit their answers) and 1 = matching enabled (candidates cannot edit their answers)
} 
?>
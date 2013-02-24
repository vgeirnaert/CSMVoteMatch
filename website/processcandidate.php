<?php 
require_once 'database.php';

$mysqli = VotematchDB::getConnection();
	
if (mysqli_connect_errno()) {
	echo '<p><h2>Error connecting to database:</h2>' . mysqli_connect_error() . '</p>';
} else {
	session_start();
	if(isset($_SESSION["cdata"])) {
	
		// check date
		// sanitize data
		// update db row
			
		$playsince = validateDate($_POST["playsince"]);
		$playspace = getSpace($_POST["playspace"]);
		$playstyle = getStyle($_POST["playstyle"]);
		
		$rlname = sanitize($_POST["rlname"]);
		$rljob = sanitize($_POST["rljob"]);
		$rlloc = sanitize($_POST["rllocation"]);
		$rlage = checkAge($_POST["rlage"]);
		$campaign = trim(sanitize($_POST["campaign"]));
		$url = checkUrl($_POST["url"]);
		$twitter = sanitize($_POST["twitter"]);
		$thread = checkUrl($_POST["thread"]);
		
		$canevemail = 0;
		if($_POST["canevemail"] == "on")
			$canevemail = 1;
			
		$canconvo = 0;
		if($_POST["canconvo"] == "on")
			$canconvo = 1;
			
		$email = sanitize($_POST["email"]);
		$eveexp = trim(sanitize($_POST["eveexp"]));
		$rlexp = trim(sanitize($_POST["rlexp"]));
		
		$questions = $_SESSION["cdata"]["questions"];
		
		for($i = 0; $i < count($questions); $i++) {
			$qtuple = $questions[$i];
			
			$qtuple["answer"] = sanitize($_POST["question_" . $qtuple["qid"]]);
			
			$questions[$i] = $qtuple;
		}
		
		// db stuff
		$userid = $_SESSION["cdata"]["id"];
		$stmt = $mysqli->prepare("UPDATE candidates SET website=?, thread=?, twitter=?, real_name=?, real_location=?, real_age=?, real_occupation=?, played_since=?, flies_in=?, playstyle=?, can_evemail=?, can_convo=?, email=?, campaign_statement=?, experience_eve=?, experience_real=? WHERE id=?");
		$stmt->bind_param("sssssissssiissssi", $url, $thread, $twitter, $rlname, $rlloc, $rlage, $rljob, $playsince, $playspace, $playstyle, $canevemail, $canconvo, $email, $campaign, $eveexp, $rlexp, $userid);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $mysqli->prepare("DELETE FROM open_answers WHERE candidate_id = ?");
		$stmt->bind_param("i", $userid);
		$stmt->execute();
		$stmt->close();
		
		
		$stmt = $mysqli->prepare("INSERT INTO open_answers (question_id, candidate_id, answer) VALUES(?, ?, ?)");
		$questionid = 0;
		$answer = "";
		$stmt->bind_param("iis", $questionid, $userid, $answer);
		
		for($i = 0; $i < count($questions); $i++) {
			$qtuple = $questions[$i];
			$questionid = $qtuple["qid"];
			$answer = $qtuple["answer"];
			$stmt->execute();
		}
		
		$stmt->close();
		
		header("Location: candidate.php?id=$userid");
	} 
}

VotematchDB::close();

function checkUrl($url) {
	$url = trim($url);
	if( (substr($url, 0, 7) == "http://" || substr($url, 0, 8) == "https://") && strpos($url, '"') == false && strpos($url, '<') == false && strpos($url, '>') == false) 
		return $url;
	
	return null;
}

function sanitize($string) {
	return htmlspecialchars($string);
}

function checkAge($age) {
	$age = trim($age);
	if(ctype_digit($age))
		return $age;
		
	return null;
		
}

function validateDate($date) {
	$date = trim($date);
	$timestamp = strtotime($date);
	
	if($timestamp != false) {
		echo "boooooooo!";
		return date("Y-m-d", $timestamp);
		}
		
	return null;
}

function getStyle($style) {
	switch($style) {
		case 1:
			return "pvp";
		case 2:
			return "pve";
		case 3:
			return "ind";
		case 4:
			return "ldr";
		case 5:
			return "meta";
		case 6:
			return "oth";	
	}
	
	return null;
}

function getSpace($space) {
	switch($space) {
		case 1:
			return "high";
		case 2:
			return "low";
		case 3:
			return "null";
		case 4:
			return "wh";	
	}
	
	return null;
}
?>
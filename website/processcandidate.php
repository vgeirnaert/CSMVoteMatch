<?php 
require_once 'database.php';

try {
	$pdo = VotematchDB::getConnection();
	
	ini_set('session.gc_maxlifetime', 20800);
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
		$stmt = $pdo->prepare("UPDATE candidates SET website=:website, thread=:thread, twitter=:twitter, real_name=:real_name, real_location=:real_location, real_age=:real_age, real_occupation=:real_occupation, played_since=:played_since, flies_in=:flies_in, playstyle=:playstyle, can_evemail=:can_evemail, can_convo=:can_convo, email=:email, campaign_statement=:campaign_statement, experience_eve=:experience_eve, experience_real=:experience_real WHERE id=:id");
		
		$stmt->bindParam('website', $url);
		$stmt->bindParam('thread', $thread);
		$stmt->bindParam('twitter', $twitter);
		$stmt->bindParam('real_name', $rlname);
		$stmt->bindParam('real_location', $rlloc);
		$stmt->bindParam('real_age', $rlage);
		$stmt->bindParam('real_occupation', $rljob);
		$stmt->bindParam('played_since', $playsince);
		$stmt->bindParam('flies_in', $playspace);
		$stmt->bindParam('playstyle', $playstyle);
		$stmt->bindParam('can_evemail', $canevemail);
		$stmt->bindParam('can_convo', $canconvo);
		$stmt->bindParam('email', $email);
		$stmt->bindParam('campaign_statement', $campaign);
		$stmt->bindParam('experience_eve', $eveexp);
		$stmt->bindParam('experience_real', $rlexp);
		$stmt->bindParam('id', $userid);
		$stmt->execute();

		$stmt->closeCursor();
		$isProblem = false;
		
		$stmt = $pdo->prepare("DELETE FROM open_answers WHERE candidate_id = :cid");
		$stmt->execute(array('cid'=>$userid));
		$stmt->closeCursor();

		$stmt = $pdo->prepare("INSERT INTO open_answers (question_id, candidate_id, answer) VALUES(:qid, :cid, :ans)");
		$stmt->bindParam('qid', $questionid);
		$stmt->bindParam('cid', $userid);
		$stmt->bindParam('ans', $answer);
		$questionid = 0;
		$answer = "";
		
		for($i = 0; $i < count($questions); $i++) {
			$qtuple = $questions[$i];
			$questionid = $qtuple["qid"];
			$answer = $qtuple["answer"];
			$stmt->execute();
		}
		
		$stmt->closeCursor();
		VotematchDB::close();
		if(!$isProblem) {
			include 'header.php';
?>
<div class="row inverted rounded">
	<h1>Success!</h1>
</div>
<br>
<div class="row rounded">
	Details entered succesfully!</br><br/>
	Click <a href="login.php">here</a> to return to your profile.
</div>
<?php
			include 'footer.php';
		}
	} else {
		printError("Session timeout! This can possibly be fixed by opening the login page <b>in a new tab of your browser</b>, log in again, then using <b>the back button</b> on your browser go back to your profile page and then re-submit your answers. We apologise for the inconvenience.");
	}
} catch (Exception $e) {
	echo '<p><h2>Error connecting to database:</h2>' . $e->getMessage() . '</p>';
}

function printError($string) {
	echo '<p><h2>Error executing query:</h2>' . $string . '</p>Please contact Dierdra Vaal';
}



function checkUrl($url) {
	$url = trim($url);
	if( (substr($url, 0, 7) == "http://" || substr($url, 0, 8) == "https://") && strpos($url, '"') == false && strpos($url, '<') == false && strpos($url, '>') == false) 
		return $url;
	
	return null;
}

function sanitize($string) {
	return stripslashes($string);
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
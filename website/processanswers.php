<?php 
require_once 'database.php';
require_once 'questions.php';

$mysqli = VotematchDB::getConnection();
	
if (mysqli_connect_errno()) {
	echo '<p><h2>Error connecting to database:</h2>' . mysqli_connect_error() . '</p>';
} else {
	session_start();
	if(isset($_SESSION["cdata"])) {
		
		Questions::initClassicQuestions();
		$questions = Questions::getNumClassicQuestions();
		
		$userid = $_SESSION["cdata"]["id"];
		
		// remove original classic answers
		$stmt = $mysqli->prepare("DELETE FROM classic_answers WHERE candidate_id = ?");
		$stmt->bind_param("i", $userid);
		$stmt->execute();
		$stmt->close();
		
		// input new classic answers
		$qid = 0;
		$q_answer = 0;
		$comment = "";
		$q_weight = 1.0;
		
		$stmt = $mysqli->prepare("INSERT INTO classic_answers (question_id, candidate_id, answer, weight, comment) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("iiids", $qid, $userid, $q_answer, $q_weight, $comment);
		
		for($i = 0; $i < $questions; $i++) {
			$qid = Questions::getIdForQuestion($i);
			
			$q_answer = parseAnswer($_POST["q" . $i]);
			$q_weight = floatval($_POST["q" . $i . "_weight"]);
			$comment = sanitize($_POST["c" . $i]);
			
			//echo "classic $qid $q_answer $q_weight $comment </br>";
			$stmt->execute();
		}
		$stmt->close();
		
		// remove original okc answers
		$stmt = $mysqli->prepare("DELETE FROM okc_answers WHERE candidate_id = ?");
		$stmt->bind_param("i", $userid);
		$stmt->execute();
		$stmt->close();
		
		// input new okc answers
		$id_array = unserialize($_POST["ids"]);
		
		$answer = 0;
		$weight = 0;
		$comment = "";
		
		$stmt = $mysqli->prepare("INSERT INTO okc_answers (candidate_id, answer_id, weight, comment) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("iiis", $userid, $answer, $weight, $comment);
		
		for($i = 0; $i < count($id_array); $i++) {
			$qid = $id_array[$i];
			$answer = intval($_POST["ans_" . $qid]);
			$weight = parseOKCWeight($_POST["imp_" . $qid]);
			$comment = sanitize($_POST["okc_c" . $qid]);
			
			//echo "okc $qid $answer $weight $comment </br>";
			$stmt->execute();
		}
		$stmt->close();
	
		include 'header.php';
?>
<div class="row inverted rounded">
	<h1>Success!</h1>
</div>
<br>
<div class="row rounded">
	Answers entered succesfully!</br><br/>
	Click <a href="editcandidate.php">here</a> to return to your profile.
</div>
<?php
		include 'footer.php';
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


// change text code for answer to numeric answer value
function parseAnswer($ans) {
	switch($ans) {
		case "SD":
			return -2;
		break;
		case "D":
			return -1;
		break;
		case "A":
			return 1;
		break;
		case "SA":
			return 2;
		break;
		default: // No opinion or weird input
			return 0;
		break;
	}
}

function parseOKCWeight($weight) {	
	switch($weight) {
		case "li":
			return 1;
		break;
		case "si":
			return 5;
		break;
		case "vi":
			return 10;
		break;
		case "ma":
			return 50;
		break;
		default:
			return 0;
		break;
	}
}
?>
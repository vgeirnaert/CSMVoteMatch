<?php 
require_once 'database.php';
require_once 'questions.php';

try {
	$pdo = VotematchDB::getConnection();
	
	ini_set('session.gc_maxlifetime', 20800);
	session_start();
	if(isset($_SESSION["cdata"])) {
		$theQuestions = new Questions();
		
		$userid = $_SESSION["cdata"]["id"];
			
		// remove original okc answers
		$stmt = $pdo->prepare("DELETE FROM okc_answers WHERE candidate_id = :cid");
		$stmt->execute(array('cid'=>$userid));
		$stmt->closeCursor();
		
		// input new okc answers
		$id_array = unserialize(stripslashes($_POST["ids"]));
		
		$answer = 0;
		$weight = 0;
		$comment = "";
		
		$stmt = $pdo->prepare("INSERT INTO okc_answers (candidate_id, answer_id, weight, comment) VALUES (:cid, :aid, :weight, :comment)");
		$stmt->bindParam('cid', $userid);
		$stmt->bindParam('aid', $answer);
		$stmt->bindParam('weight', $weight);
		$stmt->bindParam('comment', $comment);
		
		for($i = 0; $i < count($id_array); $i++) {
			$qid = $id_array[$i];
			$answer = intval($_POST["ans_" . $qid]);
			$weight = parseOKCWeight($_POST["imp_" . $qid]);
			$comment = sanitize($_POST["okc_c" . $qid]);
			
			if($answer != 0) {
				$stmt->execute();
			}	
		}
		$stmt->closeCursor();
		VotematchDB::close();
	
		include 'header.php';
?>
<div class="row inverted rounded">
	<h1>Success!</h1>
</div>
<br>
<div class="row rounded">
	Answers entered succesfully!</br><br/>
	Click <a href="login.php">here</a> to return to your profile.
</div>
<?php
		include 'footer.php';
		
	} else {
		doError("Session timeout"); 
	}
} catch (Exception $e) {
	echo '<p><h2>Error connecting to database:</h2>' . $e->getMessage() . '</p>';
}

function doError($string) {
	include 'header.php';
?>
<div class="row inverted rounded">
	<h1>Error!</h1>
</div>
<br>
<div class="row rounded">
	<?php echo $string; ?></br><br/>
	This can <i>possibly</i> be fixed by doing the following (in this order):
	<ul><li>Open <a href="login.php">the login page</a> <b>in a new tab in your browser</b></li>
	<li>Log in again through the login page you opened in the other tab</li>
	<li>Use the <b>back button of your browser</b> to go back from this page to your questionnaire page</li>
	<li>Re-submit your answers on the questionnaire page</li>
	</ul>
	We apologise for the inconvenience. If this happens again, please contact <a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank">Dierdra Vaal</a>.
</div>
<?php
	include 'footer.php';
}



function checkUrl($url) {
	$url = trim($url);
	if( (substr($url, 0, 7) == "http://" || substr($url, 0, 8) == "https://") && strpos($url, '"') == false && strpos($url, '<') == false && strpos($url, '>') == false) 
		return $url;
	
	return null;
}

function sanitize($string) {
	if($string == null)
		return "";
		
	return stripslashes($string);
}

function checkAge($age) {
	$age = trim($age);
	if(ctype_digit($age))
		return $age;
		
	return null;
		
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
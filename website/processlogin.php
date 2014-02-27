<?php 
require_once 'database.php';
ini_set('session.gc_maxlifetime', 20800);

try {
	$pdo = VotematchDB::getConnection();
	
	if(isset($_POST["username"]) && isset($_POST["password"])) {
	
		$username = $_POST["username"];
		$password = $_POST["password"];
		// get candidate details
		$stmt = $pdo->prepare("SELECT c.id, c.website, c.thread, c.twitter, c.char_id, c.char_name, c.corp_name, c.alliance_name, c.real_name, c.real_location, c.real_age, c.real_occupation, c.played_since, c.flies_in, c.playstyle, c.can_evemail, c.can_convo, c.email, c.campaign_statement, c.experience_eve, c.experience_real, h.csm FROM candidates AS c LEFT JOIN csm_history AS h ON c.char_id = h.character_id WHERE c.username = :username AND c.password = :password AND c.election_id = :elid");
		$election = Config::active_election;
		$stmt->execute(array('username'=>$username, 'password'=>$password, 'elid'=>$election));

		//VotematchDB::bindAll($stmt, array($id, $website, $thread, $twitter, $charid, $charname, $corpname, $alliancename, $realname, $realloc, $realage, $realocc, $played, $flies, $playstyle, $bevemail, $bconvo, $email, $campaignstmt, $eveexp, $realexp, $csm));
		$stmt->bindColumn(1, $id);
		$stmt->bindColumn(2, $website);
		$stmt->bindColumn(3, $thread);
		$stmt->bindColumn(4, $twitter);
		$stmt->bindColumn(5, $charid);
		$stmt->bindColumn(6, $charname);
		$stmt->bindColumn(7, $corpname);
		$stmt->bindColumn(8, $alliancename);
		$stmt->bindColumn(9, $realname);
		$stmt->bindColumn(10, $realloc);
		$stmt->bindColumn(11, $realage);
		$stmt->bindColumn(12, $realocc);
		$stmt->bindColumn(13, $played);
		$stmt->bindColumn(14, $flies);
		$stmt->bindColumn(15, $playstyle);
		$stmt->bindColumn(16, $bevemail);
		$stmt->bindColumn(17, $bconvo);
		$stmt->bindColumn(18, $email);
		$stmt->bindColumn(19, $campaignstmt);
		$stmt->bindColumn(20, $eveexp);
		$stmt->bindColumn(21, $realexp);
		$stmt->bindColumn(22, $csm);
		
		$cdetails = array();
		$csmarray = array();
		$recordfound = false;
		while($stmt->fetch(PDO::FETCH_BOUND)) {
			$recordfound = true;
			if(count($cdetails) == null) {
				$cdetails["username"] = $username;
				$cdetails["id"] = $id;
				$cdetails["website"] = $website;
				$cdetails["thread"] = $thread;
				$cdetails["twitter"] = htmlspecialchars($twitter);
				$cdetails["charid"] = htmlspecialchars($charid);
				$cdetails["charname"] = htmlspecialchars($charname);
				$cdetails["corpname"] = htmlspecialchars($corpname);
				$cdetails["alliancename"] = htmlspecialchars($alliancename);
				$cdetails["realname"] = htmlspecialchars($realname);
				$cdetails["realloc"] = htmlspecialchars($realloc);
				$cdetails["realage"] = htmlspecialchars($realage);
				$cdetails["realocc"] = htmlspecialchars($realocc);
				$cdetails["played"] = htmlspecialchars($played);
				$cdetails["flies"] = htmlspecialchars($flies);
				$cdetails["playstyle"] = htmlspecialchars($playstyle);
				$cdetails["bevemail"] = htmlspecialchars($bevemail);
				$cdetails["bconvo"] = htmlspecialchars($bconvo);
				$cdetails["email"] = htmlspecialchars($email);
				$cdetails["statement"] = htmlspecialchars($campaignstmt);
				$cdetails["eveexp"] = htmlspecialchars($eveexp);
				$cdetails["realexp"] = htmlspecialchars($realexp);
				
				if($csm != 0)
					array_push($csmarray, $csm);
			} else {
				if($csm != 0)
					array_push($csmarray, $csm);
			}
		}
		
		$cdetails["csm"] = $csmarray;
		
		$stmt->closeCursor();
		
		if($recordfound) {
		
			// get open questions and answers
			$stmt = $pdo->prepare("SELECT q.question, a.answer, q.id FROM open_questions AS q LEFT JOIN open_answers AS a ON q.id = a.question_id AND a.candidate_id = :cid WHERE q.election_id = :elid ORDER BY q.id");
			
			$election = Config::active_election;
			
			$stmt->execute(array('cid'=>$cdetails["id"], 'elid'=>$election));
			
			//VotematchDb::bindAll($stmt, array($question, $answer, $qid));
			$stmt->bindColumn(1, $question);
			$stmt->bindColumn(2, $answer);
			$stmt->bindColumn(3, $qid);

			$questions = array();
			while($stmt->fetch()) {
				array_push($questions, array("question"=>$question, "answer"=>$answer, "qid"=>$qid));
			}
			
			$cdetails["questions"] = $questions;
			
			$stmt->closeCursor();
			
			session_start();
			$_SESSION['cdata'] = $cdetails;
			
			header('Location: editcandidate.php');
		} else {
			endSession(true);
		}
	} else {
		endSession(false);
	}
	
	VotematchDB::close();
} catch(Exception $e) {
	echo '<p><h2>Error connecting to database:</h2>' . $e->getMessage() . '</p>';
}



function endSession($isError) {
	session_start();
	session_destroy();
		
	include 'header.php'; 
	if($isError)
		echo '<div class="row inverted rounded"><h1>Candidate not found</h1></div><br><div class="row rounded">You can retry logging in <a href="login.php">here</a>.</div>';
	else
		echo '<div class="row inverted rounded"><h1>Logged out</h1></div><br><div class="row rounded">You can log in <a href="login.php">here</a>.</div>';
	include 'footer.php'; 
}
 ?>
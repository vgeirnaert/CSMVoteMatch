<?php 
require_once 'database.php';

$mysqli = VotematchDB::getConnection();
	
if (mysqli_connect_errno()) {
	echo '<p><h2>Error connecting to database:</h2>' . mysqli_connect_error() . '</p>';
} else {

	if(isset($_POST["username"]) && isset($_POST["password"])) {
	
		$username = $_POST["username"];
		$password = $_POST["password"];
		// get candidate details
		$stmt = $mysqli->prepare("SELECT c.id, c.website, c.thread, c.twitter, c.char_id, c.char_name, c.corp_name, c.alliance_name, c.real_name, c.real_location, c.real_age, c.real_occupation, c.played_since, c.flies_in, c.playstyle, c.can_evemail, c.can_convo, c.email, c.campaign_statement, c.experience_eve, c.experience_real, h.csm FROM candidates AS c LEFT JOIN csm_history AS h ON c.char_id = h.character_id WHERE c.username = ? AND c.password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();

		$stmt->bind_result($id, $website, $thread, $twitter, $charid, $charname, $corpname, $alliancename, $realname, $realloc, $realage, $realocc, $played, $flies, $playstyle, $bevemail, $bconvo, $email, $campaignstmt, $eveexp, $realexp, $csm);
		
		$cdetails = array();
		$csmarray = array();
		$recordfound = false;
		while($stmt->fetch()) {
			$recordfound = true;
			if(count($cdetails) == null) {
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
		
		$stmt->close();
		
		if($recordfound) {
		
			// get open questions and answers
			$stmt = $mysqli->prepare("SELECT q.question, a.answer FROM open_questions AS q LEFT JOIN open_answers AS a ON q.id = a.question_id WHERE q.election_id = ? AND a.candidate_id = ? ORDER BY q.id");
			
			$election = Config::active_election;
			$stmt->bind_param("ii", $election, $cdetails["id"]);
			
			$stmt->execute();
			
			$stmt->bind_result($question, $answer);
			
			$questions = array();
			while($stmt->fetch()) {
				array_push($questions, array("question"=>$question, "answer"=>htmlspecialchars($answer)));
			}
			
			$stmt->close();
	
			$pagetitle = $cdetails["charname"] . " for CSM - Eve Vote Match 2.0";

			include 'header.php'; 
?>
<div class="row inverted rounded">
	<h1>Edit candidate: <?php echo $cdetails["charname"]; ?></h1>
</div>
<br>
<div class="row rounded">
	<form>
	<div class="span5 coverview rounded pull-right">
		<img src="https://image.eveonline.com/Character/<?php echo $cdetails["charid"]; ?>_512.jpg" />
	</div>
	<div class="span6 coverview rounded">
		<a href="editquestions.php" class="btn btn-large btn-primary">&laquo; Click here to set or change your answers to the questionnaire</a>
	</div>
	<div class="span6 coverview rounded">
		<h2>In Eve Online</h2>
		<div class="span6">
			<div class="span2">
				Character name
			</div>
			<div class="span4 bold">
				<a href="https://gate.eveonline.com/Profile/<?php echo $cdetails["charname"]; ?>" target="_blank"><?php echo $cdetails["charname"]; ?></a>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Corporation
			</div>
			<div class="span4 bold">
				<a href="https://gate.eveonline.com/Corporation/<?php echo $cdetails["corpname"]; ?>" target="_blank"><?php echo $cdetails["corpname"]; ?></a>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Alliance
			</div>
			<div class="span4 bold">
				<a href="https://gate.eveonline.com/Alliance/<?php echo $cdetails["alliancename"]; ?>" target="_blank"><?php echo $cdetails["alliancename"]; ?></a>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				CSM experience
			</div>
			<div class="span4">
				<?php 
					$csm = $cdetails["csm"];
					if(count($csm) > 0) {
						for($i = 0; $i < count($csm); $i++) {
							echo "CSM" . $csm[$i] . ", ";
						}
					} else {
						echo "None";
					}					
				?>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Playing since
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["played"]; ?>">
			</div>
		</div>
	</div>
	<div class="span6 coverview rounded">
		<h2>In real life</h2>
		<div class="span6">
			<div class="span2">
				Name
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["realname"]; ?>">
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Location
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["realloc"]; ?>">
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Occupation
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["realocc"]; ?>">
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Age
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["realage"]; ?>">
			</div>
		</div>
	</div>
	<div class="span6 coverview rounded">
		<h2>Campaign statement</h2>
		<textarea style="width: 95%" rows="10">
		<?php echo $cdetails["statement"]; ?>
		</textarea>
	</div>
	<div class="span5 coverview rounded pull-right">
		<h2>Contact information</h2>
		<div class="span5">
			<div class="span2">
				Website URL
			</div>
			<div class="span3">
				<input type="text" value="<?php echo $cdetails["website"]; ?>">
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Twitter name
			</div>
			<div class="span3">
				<input type="text" value="<?php echo $cdetails["twitter"]; ?>">				
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Campaign thread URL
			</div>
			<div class="span3">
				<input type="text" value="<?php echo $cdetails["thread"]; ?>">
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Can users evemail you
			</div>
			<div class="span3 bold">
				<label for="evemail" class="checkbox"><input type="checkbox" id="evemail" <?php if($cdetails["bevemail"]) echo 'checked'; ?>>Yes</label>
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Can users convo you
			</div>
			<div class="span3 bold">
				<label for="convo" class="checkbox"><input type="checkbox" id="convo" <?php if($cdetails["bconvo"]) echo 'checked'; ?>>Yes</label>
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Public email address
			</div>
			<div class="span3">
				<input type="text" value="<?php echo $cdetails["email"]; ?>">				
			</div>
		</div>
	</div>
	<div class="span6 coverview rounded">
		<h2>Experience in Eve</h2>
		<textarea style="width: 95%" rows="10">
		<?php echo $cdetails["eveexp"]; ?>
		</textarea>
	</div>
	<div class="span5 coverview rounded pull-right">
		<h2>Real life experience</h2>
		<textarea style="width: 95%" rows="10">
		<?php echo $cdetails["realexp"]; ?>
		</textarea>
	</div>

	<div class="span11 coverview rounded">
		<h2>Questions</h2>
		<?php
			for($i = 0; $i < count($questions); $i++) {
				$qtuple = $questions[$i];
				
				echo '<h3>' . $qtuple["question"] . '</h3>';
				echo '<textarea style="width: 95%" rows="5">';
				echo $qtuple["answer"];
				echo '</textarea>';
			}
		?> 
		
	</div>
	<div class="span11 coverview rounded">
			<input type="submit" style="font-size:30px; line-height: 60px;" class="btn btn-warning pull-right" value="Submit changes">
	</div>
	</form>
</div>
<?php	
			include 'footer.php'; 
		} else {
			postFail();
		}
	} else {
		postFail();
	}
}


VotematchDB::close();

function postFail() {
	include 'header.php'; 
	echo '<div class="row inverted rounded"><h1>Candidate not found</h1></div><br><div class="row rounded">You can retry logging in <a href="login.php">here</a>.</div>';
	include 'footer.php'; 
}?>
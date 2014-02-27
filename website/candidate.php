<?php 
require_once 'database.php';

function sanitize($string) {
	return htmlspecialchars(stripslashes($string));
}

try {
	$pdo = VotematchDB::getConnection();

	// get candidate details
	$stmt = $pdo->prepare("SELECT c.id, c.website, c.thread, c.twitter, c.char_id, c.char_name, c.corp_name, c.alliance_name, c.real_name, c.real_location, c.real_age, c.real_occupation, c.played_since, c.flies_in, c.playstyle, c.can_evemail, c.can_convo, c.email, c.campaign_statement, c.experience_eve, c.experience_real, h.csm FROM candidates AS c LEFT JOIN csm_history AS h ON c.char_id = h.character_id WHERE (c.id = :cid OR c.char_id = :charid) AND c.election_id = :elid");
	$cid = $_GET["id"];
	$charid = $_GET["cid"];
	$election = Config::active_election;
	$stmt->execute(array('cid' => $cid, 'charid' => $charid, 'elid' => $election));

	
	//VoteMatchDB::bindAll($stmt, array($id, $website, $thread, $twitter, $charid, $charname, $corpname, $alliancename, $realname, $realloc, $realage, $realocc, $played, $flies, $playstyle, $bevemail, $bconvo, $email, $campaignstmt, $eveexp, $realexp, $csm));
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
	while($stmt->fetch(PDO::FETCH_BOUND)) {
		if(count($cdetails) == null) {
			$cdetails["id"] = $id;
			$cdetails["website"] = $website;
			$cdetails["thread"] = $thread;
			$cdetails["twitter"] = sanitize($twitter);
			$cdetails["charid"] = sanitize($charid);
			$cdetails["charname"] = sanitize($charname);
			$cdetails["corpname"] = sanitize($corpname);
			$cdetails["alliancename"] = sanitize($alliancename);
			$cdetails["realname"] = sanitize($realname);
			$cdetails["realloc"] = sanitize($realloc);
			$cdetails["realage"] = sanitize($realage);
			$cdetails["realocc"] = sanitize($realocc);
			$cdetails["played"] = sanitize($played);
			$cdetails["flies"] = sanitize($flies);
			$cdetails["playstyle"] = sanitize($playstyle);
			$cdetails["bevemail"] = sanitize($bevemail);
			$cdetails["bconvo"] = sanitize($bconvo);
			$cdetails["email"] = sanitize($email);
			$cdetails["statement"] = sanitize($campaignstmt);
			$cdetails["eveexp"] = sanitize($eveexp);
			$cdetails["realexp"] = sanitize($realexp);
			
			if($csm != 0)
				array_push($csmarray, $csm);
		} else {
			if($csm != 0)
				array_push($csmarray, $csm);
		}
	}
	
	$cdetails["csm"] = $csmarray;
	
	$stmt->closeCursor();
	
	// get open questions and answers
	$stmt = $pdo->prepare("SELECT q.question, a.answer FROM open_questions AS q LEFT JOIN open_answers AS a ON q.id = a.question_id AND a.candidate_id = :canid WHERE q.election_id = :elid ORDER BY q.id");
	
	
	
	$stmt->execute(array('canid' => $cdetails["id"], 'elid' => $election));
	
	//VoteMatchDB::bindAll($stmt, array($question, $answer));
	$stmt->bindColumn(1, $question);
	$stmt->bindColumn(2, $answer);
	$questions = array();
	while($stmt->fetch(PDO::FETCH_BOUND)) {
		array_push($questions, array("question"=>$question, "answer"=>sanitize($answer)));
	}
	
	$stmt->closeCursor();
} catch (Exception $e) {
	echo '<p><h2>Error connecting to database:</h2>' . $e->getMessage() . '</p>';
}

VotematchDB::close();

$pagetitle = $cdetails["charname"] . " for CSM";

include 'header.php'; 
?>
<!-- facebook like button code -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript" src="http://vk.com/js/api/share.js?11" charset="windows-1251"></script>
<div class="row inverted rounded">
	<h1>Candidate: <?php echo $cdetails["charname"]; ?></h1>
</div>
<br>
<div class="row rounded">
	<div class="span6 coverview rounded">
		<a class="btn" href="<?php echo $cdetails["website"]; ?>" target="_blank"><img src="img/website.png" /> Website</a>&nbsp;&nbsp;
		<a class="btn" href="https://twitter.com/<?php echo $cdetails["twitter"]; ?>" target="_blank"><img src="img/twitter.png" /> Twitter</a>&nbsp;&nbsp;
		<a class="btn" href="<?php echo $cdetails["thread"]; ?>" target="_blank"><img src="img/forumlogo.png" /> Forum thread</a>&nbsp;&nbsp;
		<!--<a class="btn" href="compare.php?cid=<?php echo $cdetails["charid"]; ?>"><img src="img/votematch.png" /> Vote Match</a>-->
	</div>
	<div class="span5 pull-right">
		<div class="span5 coverview rounded pull-right">
			<img src="https://image.eveonline.com/Character/<?php echo $cdetails["charid"]; ?>_512.jpg" />
		</div>
		<div class="span5 coverview rounded pull-right">
			<h2>Promote this candidate</h2>
			<div class="span1" style="width: 110px;">
				<a href="https://twitter.com/share" class="twitter-share-button" data-text="I support <?php echo $cdetails["charname"]; ?> for CSM!" data-via="EveVoteMatch" data-size="small" data-hashtags="tweetfleet,eveonline,csm8">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			<div class="span1" style="width: 110px;">
				<div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
			</div>
			<div class="span1" style="width: 110px;">
				<div class="g-plusone" data-size="medium"></div>
			</div>
			<div class="span1" style="width: 110px;">
				<script type="text/javascript">document.write(VK.Share.button(false,{type: "button", text: "Share"}));</script>
			</div>
		</div>
		<div class="span5 coverview rounded pull-right">
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
					<?php echo $cdetails["played"]; ?>
				</div>
			</div>
		</div>
		<div class="span5 coverview rounded pull-right">
			<h2>In real life</h2>
			<div class="span6">
				<div class="span2">
					Name
				</div>
				<div class="span4 bold">
					<?php echo $cdetails["realname"]; ?>
				</div>
			</div>
			<div class="span6">
				<div class="span2">
					Location
				</div>
				<div class="span4 bold">
					<?php echo $cdetails["realloc"]; ?>
				</div>
			</div>
			<div class="span6">
				<div class="span2">
					Occupation
				</div>
				<div class="span4 bold">
					<?php echo $cdetails["realocc"]; ?>
				</div>
			</div>
			<div class="span6">
				<div class="span2">
					Age
				</div>
				<div class="span4 bold">
					<?php echo $cdetails["realage"]; ?>
				</div>
			</div>
		</div>
		
		<div class="span5 coverview rounded pull-right">
			<h2>Contact information</h2>
			<div class="span5">
				<div class="span2">
					Website
				</div>
				<div class="span3">
					<?php 
						if($cdetails["website"])
							echo '<a href="' .  $cdetails["website"] .'" target="_blank">' . $cdetails["website"] . '</a>';
						else
							echo 'Not available';
					?>
				</div>
			</div>
			<div class="span5">
				<div class="span2">
					Twitter
				</div>
				<div class="span3">
					<?php 
						if($cdetails["twitter"])
							echo '<a href="https://twitter.com/' . $cdetails["twitter"] . '" target="_blank">@' . $cdetails["twitter"] . '</a>';
						else
							echo 'Not available';
					?>
					
				</div>
			</div>
			<div class="span5">
				<div class="span2">
					Campaign thread
				</div>
				<div class="span3">
					<a href="<?php echo $cdetails["thread"]; ?>" target="_blank">Official campaign thread</a>
				</div>
			</div>
			<div class="span5">
				<div class="span2">
					Evemail
				</div>
				<div class="span3 bold">
					<?php 
						if($cdetails["bevemail"])
							echo '<a href="https://gate.eveonline.com/Mail/Compose/' . $cdetails["charname"] . '" target="_blank">Yes</a>';
						else
							echo 'No';
					?>
				</div>
			</div>
			<div class="span5">
				<div class="span2">
					Ingame convo
				</div>
				<div class="span3 bold">
					<?php 
						if($cdetails["bconvo"])
							echo 'Yes';
						else
							echo 'No';
					?>
				</div>
			</div>
			<div class="span5">
				<div class="span2">
					Email
				</div>
				<div class="span3">
					<?php 
						if($cdetails["email"]) {
							echo '<script type="text/javascript">
									document.write("<n uers=\"znvygb:' . str_rot13($cdetails["email"]) . '\" ery=\"absbyybj\">Rznvy guvf pnaqvqngr</n>".replace(/[a-zA-Z]/g, 
									function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));
								</script>';
						} else
							echo 'No';
					?>
					
				</div>
			</div>
		</div>
	</div>
	<div class="span6 coverview rounded">
		<h2>Campaign statement</h2>
		<?php echo nl2br($cdetails["statement"]); ?>
	</div>
	<div class="span6 coverview rounded">
		<h2>Experience in Eve</h2>
		<?php echo nl2br($cdetails["eveexp"]); ?>
	</div>
	<div class="span6 coverview rounded">
		<h2>Real life experience</h2>
		<?php echo nl2br($cdetails["realexp"]); ?>
	</div>

	<div class="span11 coverview rounded">
		<h2>Questions</h2>
		<?php
			for($i = 0; $i < count($questions); $i++) {
				$qtuple = $questions[$i];
				
				echo '<h3>' . $qtuple["question"] . '</h3>';
				echo nl2br($qtuple["answer"]);
			}
		?> 
	</div>
</div>


<?php include 'footer.php'; ?>
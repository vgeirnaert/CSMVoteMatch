<?php 
include 'header.php'; 
require_once 'database.php';
?>

<div class="row inverted rounded">
	<div class="span6"><h1>Candidates overview</h1></div>
	<div class="span5"><br><a class="btn pull-right" href="#" onclick="toggleFilterButton();">Hide filters</a></div>
	<div class="span11 filters">
		<h3>Filters</h3>
		<div class="span2">
			<h4>Flies most in</h4>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="high" /> Highsec<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="low" /> Lowsec<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="null" /> Nullsec<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="wh" /> Wormhole
		</div>
		<div class="span4">
			<h4>Main playstyle</h4>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="pvp" /> PvP (player vs player combat)<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="pve" /> PvE (missions, exploration, etc)<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="ind" /> Industry (mining, manufacturing, trading, etc)<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="ldr" /> Leadership (corp/alliance managment, etc)<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="meta" /> Metagaming (scamming, espionage, etc)<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="oth" /> Other
		</div>
		<div class="span3">
			<h4>CSM Experience</h4>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="csm" /> Former council member<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="nocsm" /> No CSM experience
		</div>
		<div class="span3">
			<h4>Time in Eve</h4>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="lt1" /> less than 1 year<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="1t2" /> 1-2 years<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="2t3" /> 2-3 years<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="3t4" /> 3-4 years<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="4t5" /> 4-5 years<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="mt5" /> more than 5 years
		</div>
	</div>
</div>
<script src="js/candidates.js"></script>
<br>
<div class="row rounded">
<?php
try {	
	$pdo = VotematchDB::getConnection();

	$stmt = $pdo->prepare("SELECT c.id, c.char_id, c.char_name, c.corp_name, c.alliance_name, c.flies_in, c.playstyle, h.csm, c.played_since FROM candidates AS c LEFT JOIN csm_history AS h ON c.char_id = h.character_id WHERE c.election_id = :elid AND c.can_convo IS NOT NULL ORDER BY random()");
	$election = Config::active_election;
	$stmt->execute(array('elid'=>$election));

	//VotematchDB::bindAll($stmt, array($id, $charid, $charname, $corpname, $alliancename, $flies1, $play1, $csm, $played));
	$stmt->bindColumn(1, $id);
	$stmt->bindColumn(2, $charid);
	$stmt->bindColumn(3, $charname);
	$stmt->bindColumn(4, $corpname);
	$stmt->bindColumn(5, $alliancename);
	$stmt->bindColumn(6, $flies1);
	$stmt->bindColumn(7, $play1);
	$stmt->bindColumn(8, $csm);
	$stmt->bindColumn(9, $played);
	
	$current_char = array();
	while($stmt->fetch(PDO::FETCH_BOUND)) {
		if(!in_array($id,$current_char)) {
			// new char!
			echo getCharHtml($id, $charid, $charname, $corpname, $alliancename, $flies1, $play1, $csm, $played);
			
			array_push($current_char,$id);
		} 
	}
	
	$stmt->closeCursor();
	

	VotematchDB::close();
} catch (Exception $e) {
	echo '<p><h2>Error connecting to database:</h2>' . $e->getMessage() . '</p>';
}

function getCharHtml($id, $charid, $charname, $corpname, $alliancename, $flies1, $play1, $csm, $played) {
	$html = '<div class="span4 candidate ';
	
	$html .= getFlyClass($flies1) . ' ' . getCSMClass($csm) . ' ' . getPlaytimeClass($played) . ' ' . getActivityClass($play1) . ' rounded">';
	
	$html .= '<a href="candidate.php?id=' . $id . '"><h3>' . $charname . '</h3>';
	$html .= '<img src="https://image.eveonline.com/Character/' . $charid . '_128.jpg" class="img-rounded" />';
	$html .= "<p>$corpname<br>$alliancename &nbsp</p></a></div>";
	
	return $html;
}

function getFlyClass($flies) {
	if($flies == "0.0")
		return "null";
		
	return $flies;
}

function getCSMClass($csm) {
	if($csm != 0)
		return 'csm';
		
	return 'nocsm';
}

function getPlaytimeClass($played) {
	$time = strtotime($played);
	
	$elapsed = time() - $time;
	
	$year = 31556926; // in seconds, aproximate
	
	if($elapsed < $year)
		return 'lt1';
	else if($elapsed > $year && $elapsed <= ($year * 2))
		return '1t2';
	else if($elapsed > ($year * 2) && $elapsed <= ($year * 3))
		return '2t3';
	else if($elapsed > ($year * 3) && $elapsed <= ($year * 4))
		return '3t4';
	else if($elapsed > ($year * 4) && $elapsed <= ($year * 5))
		return '4t5';
	else if($elapsed > ($year * 5))
		return 'mt5';
}

function getActivityClass($play) {			
	return $play;
}
?>
</div>


<?php include 'footer.php'; ?>
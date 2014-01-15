<?php 
include 'header.php'; 

require_once 'questions.php';
require_once 'database.php';
require_once 'candidate_class.php';
require_once 'answer_class.php';

$questions = new Questions();

$questions->initClassicQuestions();
$questions->initOKCQuestions(false);
$questions->closeDB();

// code to handle the user supplied answers if he came here from survey.php
function makeUserAnswers() {
	$line = '{"name":"You", "cid":"0", ';
	$line .= makeClassicAnswers();
	
	$line .=', ';
	
	$line .= makeOKCAnswers(); 
	
	return $line;
}

function makeCandidateAnswers() {

	$mysqli = VotematchDB::getConnection();
	if (mysqli_connect_errno()) {
		echo '<p><h2>Error connecting to database:</h2>' . mysqli_connect_error() . '</p>';
	} else {
		$all_candidates = array();
		$election = Config::active_election;
		
		/*$stmt = $mysqli->prepare("SELECT c.char_name, c.char_id, a.id, a.answer, a.weight, a.comment FROM candidates AS c RIGHT JOIN classic_answers AS a ON a.candidate_id = c.id WHERE election_id = ? ORDER BY c.char_name ASC, a.id ASC;");
		$stmt->bind_param("i", $election);
		$stmt->execute();
		
		$stmt->bind_result($c_name, $c_id, $a_id, $answer, $weight, $comment);
		$current_character = new Candidate(-1, "");
		while($stmt->fetch()) {
			if($current_character->getName() != $c_name) {
				// if we come across a new character, add the previous one to the 
				// candidates list (assuming it's not our placeholder character object
				if($current_character->getId() != -1)
					array_push($all_candidates, $current_character);
				
				// make a new character object
				$current_character = new Candidate($c_id, $c_name);
			}
			
			// add answer details to new character
			$current_character->addClassicAnswer(new Answer($a_id, $answer, $weight, $comment));
			
		}
		
		
		
		$stmt->close();*/
		
		$stmt = $mysqli->prepare("SELECT c.char_name, c.char_id, a.answer_id, a.weight, a.comment, q.id FROM candidates AS c RIGHT JOIN okc_answers AS a ON a.candidate_id = c.id LEFT JOIN okc_options AS o ON o.id = a.answer_id RIGHT JOIN  okc_questions AS q ON o.question_id = q.id WHERE q.election_id = ? ORDER BY c.char_name ASC, q.id ASC;");
		$stmt->bind_param("i", $election);
		$stmt->execute();
		
		$stmt->bind_result($c_name, $c_id, $answer, $weight, $comment, $q_id);
		$current_character = new Candidate(-1, "");
		while($stmt->fetch()) {
			if($current_character->getName() != $c_name && $c_name != null) {
				// if we come across a new character, add the previous one to the 
				// candidates list (assuming it's not our placeholder character object
				if($current_character->getId() != -1)
					array_push($all_candidates, $current_character);
					
				$current_character = new Candidate($c_id, $c_name);
			}
			
			// add answer details to new character
			$current_character->addOkcAnswer(new Answer($q_id, $answer, $weight, $comment));
		}
		
		// add last character to list
		array_push($all_candidates, $current_character);
		
		$stmt->close();
		$ccount = 0;
		foreach($all_candidates as $candidate) {
			$js = "";
			if($ccount > 0)
				$js .= ",\n";
				
			$js .= '{"name":"' . $candidate->getName() . '", "cid":"' . $candidate->getId() . '", "classic_answers":{';
			
			$i = 0;
			foreach($candidate->getClassicAnswers() as $answer) {
				if($i > 0)
					$js .= ",\n";
					
				$js .= '"q' . $i . '":{"answer":' . $answer->getAnswer() . ', "weight":' . $answer->getWeight() . ', "comment":"' . addslashes(htmlspecialchars($answer->getComment())) . '"}';
				$i++;
			}
			
			$js .= '}, "okc_answers":{';
			$i = 0;
			foreach($candidate->getOkcAnswers() as $answer) {
				if($i > 0)
					$js .= ",\n";
					
				$js .= '"q' . $answer->getId() . '":{"answer":[' . $answer->getAnswer() . '], "weight":' . $answer->getWeight() . ', "comment":"' . addslashes(htmlspecialchars($answer->getComment())) . '"}';
				$i++;
			}
			
			$js .= '}}';
			
			$ccount++;
			
			echo $js;
		}
	}
	VotematchDB::close();
}

function getCandidateFromList($all_candidates, $c_name) {
	foreach($all_candidates as $c) {
		if($c->getName() == $c_name)
			return $c;
	}
	
	return null;
}

function makeClassicAnswers() {
	global $questions;
	
	$num_questions = $questions->getNumClassicQuestions();
	
	$line = '"classic_answers":{';
	
	for($i = 0; $i < $num_questions; $i++) {
		$answer = parseAnswer($_POST["q" . $i]);
		$weight = parseWeight($_POST["q" . $i . "_weight"]);
		
		if($i > 0)
			$line .= ",";
			
		$line = $line . ' "q' . $i . '":{"answer":' . $answer . ', "weight":' . $weight . ' , "comment":""}';

	}
	
	$line .= "}";
	
	return $line;
}

function makeOKCAnswers() {
	global $questions;
	$id_array;
	
	if(isset($_POST["ids"]))
		$id_array = unserialize($_POST["ids"]); 
	else
		$id_array = $questions->getOkcQuestionIds();
		
	$line = '"okc_answers":{';
	for($i = 0; $i < count($id_array); $i++) {
		$id = $id_array[$i];
		$answer_array =  $_POST["ans_" . $id];
		$answer = "[]";
		$weight = parseOKCWeight("ni");
		
		if(is_array($answer_array)) {
			$answer = "[" . implode(",", $answer_array) . "]";
			$weight = parseOKCWeight($_POST["imp_" . $id]);
		}
		
		if($i > 0 )
			$line .= ", ";
		
		$line .= '"q' . $id . '":{"answer":' . $answer . ', "weight":' . $weight . ', "comment":""}';
	}
	
	$line .= '} },';
	return $line;
	
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

// turn unsupplied weights into value 1
function parseWeight($weight) {
	if($weight == "")
		return 1;
		
	return $weight;
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

function printOkcQuestionIds() {
	global $questions;
	$js = "[";
	$i = 0;
	foreach($questions->getOkcQuestionIds() as $id) {
		if($i > 0)
			$js .= ", ";
			
		$js .= $id;
			
		$i++;
	}
	
	$js .= "]";
	
	echo $js;
}
?>

<script type="text/javascript">
<?php 
echo $questions->getClassicQuestionsArray(); 
echo "\n\n";
echo $questions->getOKCQuestionsArray();
?>	

var matchQuestions = [];

var candidates = [
	<?php 
	echo makeUserAnswers(); 
	makeCandidateAnswers(); ?>
];

var matchOKCQuestions = [];
var okcQuestionIds = <?php printOkcQuestionIds(); ?>;

var matchCandidates = [];

var matchUser = candidates[0];

var language = 0;

</script>

<div class="row inverted rounded">
	<h1>Compare candidates</h1>
</div>
<br>

<div class="row rounded" >
	<div class="span11 coverview rounded">
		<div class="span6">
			<b>How important is a question to the candidate?</b><br>
			<img src="img/irrelevant.png"/> Irrelevant, <img src="img/littleimp.png"/> A little important, <img src="img/somewhatimp.png"/> Somewhat important, <img src="img/veryimp.png"/> Very important, <img src="img/mandatory.png"/> Mandatory - <span class="neutral"><img src="img/balloon.png"/></span> Candidate supplied a comment or explanation
		</div>
		<div class="span5 pull-right">
			<b>Match with you:</b><br>
		<?php if(isset($_POST["ids"])) {?>
			<span class="verybad">Terrible match</span>
			<span class="bad">Bad match</span>
			<span class="neutral">Neutral match</span>
			<span class="good">Good match</span>
			<span class="verygood">Great match</span>			
		<?php } else { ?>
			Find out <a href="survey.php">here!</a>
		<?php } ?>
		</div>
	</div>
	<a href="#" class="btn pull-right" onclick="toggleCandidates();return false;" id="showexcess">Show more candidates &raquo;</a>
	<div>
		<a href="#" class="btn" onclick="toggleButtonPanel('questionbuttons');">Question options</a> <a href="#" class="btn" onclick="toggleButtonPanel('candidatebuttons');">Candidate options</a> <?php if(isset($_POST["ids"])) echo '<a href="#" class="btn" onclick="toggleUser();" id="showuser">Show my answers</a>'; ?>
		<div class="buttonholder">
			<div class="questionbuttons buttonpanel rounded">
				<a href="#" class="btn" onclick="excludeQuestions();toggleButtonPanel('questionbuttons');">Exclude checked questions</a><br><a href="#" class="btn" onclick="includeQuestions();toggleButtonPanel('questionbuttons');">Include only checked questions</a><br><a href="#" class="btn" onclick="resetQuestions();toggleButtonPanel('questionbuttons');">Reset all questions</a>
			</div>
			<div class="candidatebuttons buttonpanel rounded">
				<a href="#" class="btn" onclick="excludeCandidates();toggleButtonPanel('candidatebuttons');">Exclude checked candidates</a><br><a href="#" class="btn" onclick="includeCandidates();toggleButtonPanel('candidatebuttons');">Include only checked candidates</a><br><a href="#" class="btn" onclick="compareCandidatesWith();toggleButtonPanel('candidatebuttons');">Compare candidates with...</a><br><a href="#" class="btn" onclick="resetCandidates();toggleButtonPanel('candidatebuttons');">Reset all candidates</a>
			</div>
		</div>
	</div>
	<br>
	<div id="contentholder">		
	</div>
</div>

<div style="display:none;">

</div>
<script src="js/compare.js"></script>
<script src="js/vendor/opentip-jquery.js"></script>

<?php if(!isset($_POST["ids"])) { ?>
<script type="text/javascript">
toggleCandidates();
</script>
<?php } ?>

<?php include 'footer.php'; ?>
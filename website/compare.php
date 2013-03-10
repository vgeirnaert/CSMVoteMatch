<?php include 'header.php'; 
require_once 'questions.php';

Questions::initClassicQuestions();
Questions::initOKCQuestions(false);
Questions::closeDB();

// code to handle the user supplied answers if he came here from survey.php
function makeUserAnswers() {
	$line = '{"name":"You", "cid":"0", ';
	$line .= makeClassicAnswers();
	
	$line .=', ';
	
	$line .= makeOKCAnswers(); 
	
	return $line;
}

function makeCandidateAnswers() {
	
}

function makeClassicAnswers() {
	$num_questions = Questions::getNumClassicQuestions();
	
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
	$id_array = unserialize($_POST["ids"]);
	
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
?>

<script type="text/javascript">
<?php 
echo Questions::getClassicQuestionsArray(); 
echo "\n\n";
echo Questions::getOKCQuestionsArray();
?>	

var matchQuestions = [];

var candidates = [
	<?php echo makeUserAnswers(); ?>
	{"name":"All Strongly Disagree", "cid":"109000795", 
		"classic_answers":{"q0":{"answer":-2, "weight":1, "comment":"Test comment <br>newline"},"q1":{"answer":-2, "weight":1, "comment":""},"q2":{"answer":-2, "weight":1, "comment":""},"q3":{"answer":-2, "weight":1, "comment":""},"q4":{"answer":-2, "weight":1, "comment":""},"q5":{"answer":-2, "weight":1, "comment":""},"q6":{"answer":-2, "weight":1, "comment":""},"q7":{"answer":-2, "weight":1, "comment":""},"q8":{"answer":-2, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[2], "weight": 10}, "q1":{"answer":[2], "weight": 1}, "q2":{"answer":[3], "weight": 10}, "q3":{"answer":[1], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[2], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[1], "weight": 5}, "q8":{"answer":[3], "weight": 5}, "q9":{"answer":[3], "weight": 10}}},
	{"name":"All Strongly Agree", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":2, "weight":1, "comment":""},"q1":{"answer":2, "weight":1, "comment":""},"q2":{"answer":2, "weight":1, "comment":""},"q3":{"answer":2, "weight":1, "comment":""},"q4":{"answer":2, "weight":1, "comment":""},"q5":{"answer":2, "weight":1, "comment":""},"q6":{"answer":2, "weight":1, "comment":""},"q7":{"answer":2, "weight":1, "comment":""},"q8":{"answer":2, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[3], "weight": 50}, "q1":{"answer":[3], "weight": 1}, "q2":{"answer":[2], "weight": 10}, "q3":{"answer":[4], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[1], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[1], "weight": 5}, "q8":{"answer":[4], "weight": 5}, "q9":{"answer":[3], "weight": 5}}
		},
	{"name":"Agree", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":1, "weight":1, "comment":""},"q1":{"answer":1, "weight":1, "comment":""},"q2":{"answer":1, "weight":1, "comment":""},"q3":{"answer":1, "weight":1, "comment":""},"q4":{"answer":1, "weight":1, "comment":""},"q5":{"answer":1, "weight":1, "comment":""},"q6":{"answer":1, "weight":1, "comment":""},"q7":{"answer":1, "weight":1, "comment":""},"q8":{"answer":1, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[1], "weight": 50}, "q1":{"answer":[3], "weight": 1}, "q2":{"answer":[3], "weight": 10}, "q3":{"answer":[3], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[3], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[4], "weight": 5}, "q8":{"answer":[1], "weight": 10}, "q9":{"answer":[2], "weight": 50}}
	},
	{"name":"Disagree", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":-1, "weight":1, "comment":""},"q1":{"answer":-1, "weight":1, "comment":""},"q2":{"answer":-1, "weight":1, "comment":""},"q3":{"answer":-1, "weight":1, "comment":""},"q4":{"answer":-1, "weight":1, "comment":""},"q5":{"answer":-1, "weight":1, "comment":""},"q6":{"answer":-1, "weight":1, "comment":""},"q7":{"answer":-1, "weight":1, "comment":""},"q8":{"answer":-1, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[3], "weight": 50}, "q1":{"answer":[3], "weight": 1}, "q2":{"answer":[2], "weight": 10}, "q3":{"answer":[4], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[1], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[1], "weight": 5}, "q8":{"answer":[4], "weight": 5}, "q9":{"answer":[3], "weight": 5}}
	},
	{"name":"Strongly Disagree important", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":-2, "weight":0.5, "comment":""},"q1":{"answer":-2, "weight":1.5, "comment":""},"q2":{"answer":-2, "weight":0.5, "comment":""},"q3":{"answer":-2, "weight":1.5, "comment":""},"q4":{"answer":-2, "weight":0.5, "comment":""},"q5":{"answer":-2, "weight":0.5, "comment":""},"q6":{"answer":-2, "weight":2, "comment":""},"q7":{"answer":-2, "weight":1, "comment":""},"q8":{"answer":-2, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[2], "weight": 10}, "q1":{"answer":[2], "weight": 1}, "q2":{"answer":[3], "weight": 10}, "q3":{"answer":[1], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[2], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[1], "weight": 5}, "q8":{"answer":[3], "weight": 5}, "q9":{"answer":[3], "weight": 10}}
	},
	{"name":"Mister Mix", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":-2, "weight":0.5, "comment":""},"q1":{"answer":2, "weight":1.5, "comment":""},"q2":{"answer":0, "weight":0.5, "comment":""},"q3":{"answer":-1, "weight":1.5, "comment":""},"q4":{"answer":-1, "weight":0.5, "comment":""},"q5":{"answer":1, "weight":0.8, "comment":""},"q6":{"answer":2, "weight":1.7, "comment":""},"q7":{"answer":1, "weight":1.3, "comment":""},"q8":{"answer":-1, "weight":0.7, "comment":""}},
		"okc_answers":{"q0":{"answer":[1], "weight": 50}, "q1":{"answer":[3], "weight": 1}, "q2":{"answer":[3], "weight": 10}, "q3":{"answer":[3], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[3], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[4], "weight": 5}, "q8":{"answer":[1], "weight": 10}, "q9":{"answer":[2], "weight": 50}}
	},	
	{"name":"All Strongly Disagree", "cid":"109000795", 
		"classic_answers":{"q0":{"answer":-2, "weight":1, "comment":"Test comment <br>newline"},"q1":{"answer":-2, "weight":1, "comment":""},"q2":{"answer":-2, "weight":1, "comment":""},"q3":{"answer":-2, "weight":1, "comment":""},"q4":{"answer":-2, "weight":1, "comment":""},"q5":{"answer":-2, "weight":1, "comment":""},"q6":{"answer":-2, "weight":1, "comment":""},"q7":{"answer":-2, "weight":1, "comment":""},"q8":{"answer":-2, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[2], "weight": 10}, "q1":{"answer":[2], "weight": 1}, "q2":{"answer":[3], "weight": 10}, "q3":{"answer":[1], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[2], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[1], "weight": 5}, "q8":{"answer":[3], "weight": 5}, "q9":{"answer":[3], "weight": 10}}},
	{"name":"All Strongly Agree", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":2, "weight":1, "comment":""},"q1":{"answer":2, "weight":1, "comment":""},"q2":{"answer":2, "weight":1, "comment":""},"q3":{"answer":2, "weight":1, "comment":""},"q4":{"answer":2, "weight":1, "comment":""},"q5":{"answer":2, "weight":1, "comment":""},"q6":{"answer":2, "weight":1, "comment":""},"q7":{"answer":2, "weight":1, "comment":""},"q8":{"answer":2, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[3], "weight": 50}, "q1":{"answer":[3], "weight": 1}, "q2":{"answer":[2], "weight": 10}, "q3":{"answer":[4], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[1], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[1], "weight": 5}, "q8":{"answer":[4], "weight": 5}, "q9":{"answer":[3], "weight": 5}}
		},
	{"name":"Agree", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":1, "weight":1, "comment":""},"q1":{"answer":1, "weight":1, "comment":""},"q2":{"answer":1, "weight":1, "comment":""},"q3":{"answer":1, "weight":1, "comment":""},"q4":{"answer":1, "weight":1, "comment":""},"q5":{"answer":1, "weight":1, "comment":""},"q6":{"answer":1, "weight":1, "comment":""},"q7":{"answer":1, "weight":1, "comment":""},"q8":{"answer":1, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[1], "weight": 50}, "q1":{"answer":[3], "weight": 1}, "q2":{"answer":[3], "weight": 10}, "q3":{"answer":[3], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[3], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[4], "weight": 5}, "q8":{"answer":[1], "weight": 10}, "q9":{"answer":[2], "weight": 50}}
	},
	{"name":"Disagree", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":-1, "weight":1, "comment":""},"q1":{"answer":-1, "weight":1, "comment":""},"q2":{"answer":-1, "weight":1, "comment":""},"q3":{"answer":-1, "weight":1, "comment":""},"q4":{"answer":-1, "weight":1, "comment":""},"q5":{"answer":-1, "weight":1, "comment":""},"q6":{"answer":-1, "weight":1, "comment":""},"q7":{"answer":-1, "weight":1, "comment":""},"q8":{"answer":-1, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[3], "weight": 50}, "q1":{"answer":[3], "weight": 1}, "q2":{"answer":[2], "weight": 10}, "q3":{"answer":[4], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[1], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[1], "weight": 5}, "q8":{"answer":[4], "weight": 5}, "q9":{"answer":[3], "weight": 5}}
	},
	{"name":"Strongly Disagree important", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":-2, "weight":0.5, "comment":""},"q1":{"answer":-2, "weight":1.5, "comment":""},"q2":{"answer":-2, "weight":0.5, "comment":""},"q3":{"answer":-2, "weight":1.5, "comment":""},"q4":{"answer":-2, "weight":0.5, "comment":""},"q5":{"answer":-2, "weight":0.5, "comment":""},"q6":{"answer":-2, "weight":2, "comment":""},"q7":{"answer":-2, "weight":1, "comment":""},"q8":{"answer":-2, "weight":1, "comment":""}},
		"okc_answers":{"q0":{"answer":[2], "weight": 10}, "q1":{"answer":[2], "weight": 1}, "q2":{"answer":[3], "weight": 10}, "q3":{"answer":[1], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[2], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[1], "weight": 5}, "q8":{"answer":[3], "weight": 5}, "q9":{"answer":[3], "weight": 10}}
	},
	{"name":"Mister Mix", "cid":"109000795", 
		"classic_answers": {"q0":{"answer":-2, "weight":0.5, "comment":""},"q1":{"answer":2, "weight":1.5, "comment":""},"q2":{"answer":0, "weight":0.5, "comment":""},"q3":{"answer":-1, "weight":1.5, "comment":""},"q4":{"answer":-1, "weight":0.5, "comment":""},"q5":{"answer":1, "weight":0.8, "comment":""},"q6":{"answer":2, "weight":1.7, "comment":""},"q7":{"answer":1, "weight":1.3, "comment":""},"q8":{"answer":-1, "weight":0.7, "comment":""}},
		"okc_answers":{"q0":{"answer":[1], "weight": 50}, "q1":{"answer":[3], "weight": 1}, "q2":{"answer":[3], "weight": 10}, "q3":{"answer":[3], "weight": 50}, "q4":{"answer":[2], "weight": 1}, "q5":{"answer":[3], "weight": 1}, "q6":{"answer":[3], "weight": 0}, "q7":{"answer":[4], "weight": 5}, "q8":{"answer":[1], "weight": 10}, "q9":{"answer":[2], "weight": 50}}
	}	
];

var matchOKCQuestions = [1,2,3,5,6,7,8,9];

var matchCandidates = [];

var matchUser = candidates[0];

var language = 0;

</script>

<div class="row inverted rounded">
	<h1>Compare candidates</h1>
</div>
<br>

<div class="row rounded" >
	<div class="span12">
		<div class="span6 coverview rounded">
			<b>Their opinion:</b><br>
			<img src="img/doublethumbsdown.png" title="Strongly disagree" /> Strongly disagree, 
			<img src="img/thumbsdown.png" title="Disagree" /> Disagree, 
			<img src="img/noopinion.png" title="No opinion" /> No opinion, 
			<img src="img/thumbsup.png" title="Agree" /> Agree, 
			<img src="img/doublethumbsup.png"  title="Strongly agree"/> Strongly agree
			<br><br>
			<img src="img/balloon.png" title="Comment" /> Mouse over to see this candidate's explanation of their answer
		</div>
		<div class="span5 coverview rounded">
			<b>Match with you:</b><br>
			<span class="verybad">Terrible match</span>
			<span class="bad">Bad match</span>
			<span class="neutral">Neutral match</span>
			<span class="good">Good match</span>
			<span class="verygood">Perfect match</span>
		</div>
	</div>
	<a href="#" class="btn pull-right" onclick="toggleCandidates();return false;" id="showexcess">Show all candidates &raquo;</a>
	<div>
		<a href="#" class="btn" onclick="toggleButtonPanel('questionbuttons');">Question options</a> <a href="#" class="btn" onclick="toggleButtonPanel('candidatebuttons');">Candidate options</a> <?php if(isset($_POST["q0"])) echo '<a href="#" class="btn" onclick="toggleUser();" id="showuser">Show my answers</a>'; ?>
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

<?php include 'footer.php'; ?>
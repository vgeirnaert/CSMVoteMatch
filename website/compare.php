<?php include 'header.php'; 

function makeUserAnswers() {
	$num_questions = 9;
	
	$line = '{"name":"You", "cid":"0"';
	
	for($i = 0; $i < $num_questions; $i++) {
		$answer = parseAnswer($_POST["q" . $i]);
		$weight = parseWeight($_POST["q" . $i . "_weight"]);
		
		$line = $line . ', "q' . $i . '":{"answer":' . $answer . ', "weight":' . $weight . ' , "comment":""}';

	}
	
	$line = $line . '},';
	
	return $line;
}

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

function parseWeight($weight) {
	if($weight == "")
		return 1;
		
	return $weight;
}

?>

<script type="text/javascript">
var questions = [
	["question1_en", "question1_ger", "question1_rus", "question1_jp"],
	["question2_en", "question2_ger", "question2_rus", "question2_jp"],
	["question3_en", "question3_ger", "question3_rus", "question3_jp"],
	["question4_en", "question4_ger", "question4_rus", "question4_jp"],
	["question5_en", "question5_ger", "question5_rus", "question5_jp"],
	["question6_en", "question6_ger", "question6_rus", "question6_jp"],
	["question7_en", "question7_ger", "question7_rus", "question7_jp"],
	["question8_en", "question8_ger", "question8_rus", "question8_jp"],
	["question9_en", "question9_ger", "question9_rus", "question9_jp"],
	];
	
var matchQuestions = [0,1,2,3,4,5,6,7,8];

var candidates = [
	<?php echo makeUserAnswers(); ?>
	{"name":"All Strongly Disagree", "cid":"109000795", "q0":{"answer":-2, "weight":1, "comment":"Test comment<br>newline"},"q1":{"answer":-2, "weight":1, "comment":"Test comment"},"q2":{"answer":-2, "weight":1, "comment":"Test comment"},"q3":{"answer":-2, "weight":1, "comment":"Test comment"},"q4":{"answer":-2, "weight":1, "comment":"Test comment"},"q5":{"answer":-2, "weight":1, "comment":"Test comment"},"q6":{"answer":-2, "weight":1, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"All Strongly Agree", "cid":"109000795", "q0":{"answer":2, "weight":1, "comment":"Test comment"},"q1":{"answer":2, "weight":1, "comment":"Test comment"},"q2":{"answer":2, "weight":1, "comment":"Test comment"},"q3":{"answer":2, "weight":1, "comment":"Test comment"},"q4":{"answer":2, "weight":1, "comment":"Test comment"},"q5":{"answer":2, "weight":1, "comment":"Test comment"},"q6":{"answer":2, "weight":1, "comment":"Test comment"},"q7":{"answer":2, "weight":1, "comment":"Test comment"},"q8":{"answer":2, "weight":1, "comment":"Test comment"}},
	{"name":"Agree", "cid":"109000795", "q0":{"answer":1, "weight":1, "comment":"Test comment"},"q1":{"answer":1, "weight":1, "comment":"Test comment"},"q2":{"answer":1, "weight":1, "comment":"Test comment"},"q3":{"answer":1, "weight":1, "comment":"Test comment"},"q4":{"answer":1, "weight":1, "comment":"Test comment"},"q5":{"answer":1, "weight":1, "comment":"Test comment"},"q6":{"answer":1, "weight":1, "comment":"Test comment"},"q7":{"answer":1, "weight":1, "comment":"Test comment"},"q8":{"answer":1, "weight":1, "comment":"Test comment"}},
	{"name":"Disagree", "cid":"109000795", "q0":{"answer":-1, "weight":1, "comment":"Test comment"},"q1":{"answer":-1, "weight":1, "comment":"Test comment"},"q2":{"answer":-1, "weight":1, "comment":"Test comment"},"q3":{"answer":-1, "weight":1, "comment":"Test comment"},"q4":{"answer":-1, "weight":1, "comment":"Test comment"},"q5":{"answer":-1, "weight":1, "comment":"Test comment"},"q6":{"answer":-1, "weight":1, "comment":"Test comment"},"q7":{"answer":-1, "weight":1, "comment":"Test comment"},"q8":{"answer":-1, "weight":1, "comment":"Test comment"}},
	{"name":"Strongly Disagree important", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q1":{"answer":-2, "weight":1.5, "comment":"Test comment"},"q2":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q3":{"answer":-2, "weight":1.5, "comment":"Test comment"},"q4":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q5":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q6":{"answer":-2, "weight":2, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"Mister Mix", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q1":{"answer":2, "weight":1.5, "comment":"Test comment"},"q2":{"answer":0, "weight":0.5, "comment":"Test comment"},"q3":{"answer":-1, "weight":1.5, "comment":"Test comment"},"q4":{"answer":-1, "weight":0.5, "comment":"Test comment"},"q5":{"answer":1, "weight":0.8, "comment":"Test comment"},"q6":{"answer":2, "weight":1.7, "comment":"Test comment"},"q7":{"answer":1, "weight":1.3, "comment":"Test comment"},"q8":{"answer":-1, "weight":0.7, "comment":"Test comment"}},
	{"name":"All Strongly Disagree", "cid":"109000795", "q0":{"answer":-2, "weight":1, "comment":"Test comment"},"q1":{"answer":-2, "weight":1, "comment":"Test comment"},"q2":{"answer":-2, "weight":1, "comment":"Test comment"},"q3":{"answer":-2, "weight":1, "comment":"Test comment"},"q4":{"answer":-2, "weight":1, "comment":"Test comment"},"q5":{"answer":-2, "weight":1, "comment":"Test comment"},"q6":{"answer":-2, "weight":1, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"All Strongly Agree", "cid":"109000795", "q0":{"answer":2, "weight":1, "comment":"Test comment"},"q1":{"answer":2, "weight":1, "comment":"Test comment"},"q2":{"answer":2, "weight":1, "comment":"Test comment"},"q3":{"answer":2, "weight":1, "comment":"Test comment"},"q4":{"answer":2, "weight":1, "comment":"Test comment"},"q5":{"answer":2, "weight":1, "comment":"Test comment"},"q6":{"answer":2, "weight":1, "comment":"Test comment"},"q7":{"answer":2, "weight":1, "comment":"Test comment"},"q8":{"answer":2, "weight":1, "comment":"Test comment"}},
	{"name":"Agree", "cid":"109000795", "q0":{"answer":1, "weight":1, "comment":"Test comment"},"q1":{"answer":1, "weight":1, "comment":"Test comment"},"q2":{"answer":1, "weight":1, "comment":"Test comment"},"q3":{"answer":1, "weight":1, "comment":"Test comment"},"q4":{"answer":1, "weight":1, "comment":"Test comment"},"q5":{"answer":1, "weight":1, "comment":"Test comment"},"q6":{"answer":1, "weight":1, "comment":"Test comment"},"q7":{"answer":1, "weight":1, "comment":"Test comment"},"q8":{"answer":1, "weight":1, "comment":"Test comment"}},
	{"name":"Disagree", "cid":"109000795", "q0":{"answer":-1, "weight":1, "comment":"Test comment"},"q1":{"answer":-1, "weight":1, "comment":"Test comment"},"q2":{"answer":-1, "weight":1, "comment":"Test comment"},"q3":{"answer":-1, "weight":1, "comment":"Test comment"},"q4":{"answer":-1, "weight":1, "comment":"Test comment"},"q5":{"answer":-1, "weight":1, "comment":"Test comment"},"q6":{"answer":-1, "weight":1, "comment":"Test comment"},"q7":{"answer":-1, "weight":1, "comment":"Test comment"},"q8":{"answer":-1, "weight":1, "comment":"Test comment"}},
	{"name":"Strongly Disagree important", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q1":{"answer":-2, "weight":1.5, "comment":"Test comment"},"q2":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q3":{"answer":-2, "weight":1.5, "comment":"Test comment"},"q4":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q5":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q6":{"answer":-2, "weight":2, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"Mister Mix", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q1":{"answer":2, "weight":1.5, "comment":"Test comment"},"q2":{"answer":0, "weight":0.5, "comment":"Test comment"},"q3":{"answer":-1, "weight":1.5, "comment":"Test comment"},"q4":{"answer":-1, "weight":0.5, "comment":"Test comment"},"q5":{"answer":1, "weight":0.8, "comment":"Test comment"},"q6":{"answer":2, "weight":1.7, "comment":"Test comment"},"q7":{"answer":1, "weight":1.3, "comment":"Test comment"},"q8":{"answer":-1, "weight":0.7, "comment":"Test comment"}},
	{"name":"All Strongly Disagree", "cid":"109000795", "q0":{"answer":-2, "weight":1, "comment":"Test comment"},"q1":{"answer":-2, "weight":1, "comment":"Test comment"},"q2":{"answer":-2, "weight":1, "comment":"Test comment"},"q3":{"answer":-2, "weight":1, "comment":"Test comment"},"q4":{"answer":-2, "weight":1, "comment":"Test comment"},"q5":{"answer":-2, "weight":1, "comment":"Test comment"},"q6":{"answer":-2, "weight":1, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"All Strongly Agree", "cid":"109000795", "q0":{"answer":2, "weight":1, "comment":"Test comment"},"q1":{"answer":2, "weight":1, "comment":"Test comment"},"q2":{"answer":2, "weight":1, "comment":"Test comment"},"q3":{"answer":2, "weight":1, "comment":"Test comment"},"q4":{"answer":2, "weight":1, "comment":"Test comment"},"q5":{"answer":2, "weight":1, "comment":"Test comment"},"q6":{"answer":2, "weight":1, "comment":"Test comment"},"q7":{"answer":2, "weight":1, "comment":"Test comment"},"q8":{"answer":2, "weight":1, "comment":"Test comment"}},
	{"name":"Agree", "cid":"109000795", "q0":{"answer":1, "weight":1, "comment":"Test comment"},"q1":{"answer":1, "weight":1, "comment":"Test comment"},"q2":{"answer":1, "weight":1, "comment":"Test comment"},"q3":{"answer":1, "weight":1, "comment":"Test comment"},"q4":{"answer":1, "weight":1, "comment":"Test comment"},"q5":{"answer":1, "weight":1, "comment":"Test comment"},"q6":{"answer":1, "weight":1, "comment":"Test comment"},"q7":{"answer":1, "weight":1, "comment":"Test comment"},"q8":{"answer":1, "weight":1, "comment":"Test comment"}},
	{"name":"Disagree", "cid":"109000795", "q0":{"answer":-1, "weight":1, "comment":"Test comment"},"q1":{"answer":-1, "weight":1, "comment":"Test comment"},"q2":{"answer":-1, "weight":1, "comment":"Test comment"},"q3":{"answer":-1, "weight":1, "comment":"Test comment"},"q4":{"answer":-1, "weight":1, "comment":"Test comment"},"q5":{"answer":-1, "weight":1, "comment":"Test comment"},"q6":{"answer":-1, "weight":1, "comment":"Test comment"},"q7":{"answer":-1, "weight":1, "comment":"Test comment"},"q8":{"answer":-1, "weight":1, "comment":"Test comment"}},
	{"name":"Strongly Disagree important", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q1":{"answer":-2, "weight":1.5, "comment":"Test comment"},"q2":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q3":{"answer":-2, "weight":1.5, "comment":"Test comment"},"q4":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q5":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q6":{"answer":-2, "weight":2, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"Mister Mix", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q1":{"answer":2, "weight":1.5, "comment":"Test comment"},"q2":{"answer":0, "weight":0.5, "comment":"Test comment"},"q3":{"answer":-1, "weight":1.5, "comment":"Test comment"},"q4":{"answer":-1, "weight":0.5, "comment":"Test comment"},"q5":{"answer":1, "weight":0.8, "comment":"Test comment"},"q6":{"answer":2, "weight":1.7, "comment":"Test comment"},"q7":{"answer":1, "weight":1.3, "comment":"Test comment"},"q8":{"answer":-1, "weight":0.7, "comment":"Test comment"}},
	{"name":"All Strongly Disagree", "cid":"109000795", "q0":{"answer":-2, "weight":1, "comment":"Test comment"},"q1":{"answer":-2, "weight":1, "comment":"Test comment"},"q2":{"answer":-2, "weight":1, "comment":"Test comment"},"q3":{"answer":-2, "weight":1, "comment":"Test comment"},"q4":{"answer":-2, "weight":1, "comment":"Test comment"},"q5":{"answer":-2, "weight":1, "comment":"Test comment"},"q6":{"answer":-2, "weight":1, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"All Strongly Agree", "cid":"109000795", "q0":{"answer":2, "weight":1, "comment":"Test comment"},"q1":{"answer":2, "weight":1, "comment":"Test comment"},"q2":{"answer":2, "weight":1, "comment":"Test comment"},"q3":{"answer":2, "weight":1, "comment":"Test comment"},"q4":{"answer":2, "weight":1, "comment":"Test comment"},"q5":{"answer":2, "weight":1, "comment":"Test comment"},"q6":{"answer":2, "weight":1, "comment":"Test comment"},"q7":{"answer":2, "weight":1, "comment":"Test comment"},"q8":{"answer":2, "weight":1, "comment":"Test comment"}},
	{"name":"Agree", "cid":"109000795", "q0":{"answer":1, "weight":1, "comment":"Test comment"},"q1":{"answer":1, "weight":1, "comment":"Test comment"},"q2":{"answer":1, "weight":1, "comment":"Test comment"},"q3":{"answer":1, "weight":1, "comment":"Test comment"},"q4":{"answer":1, "weight":1, "comment":"Test comment"},"q5":{"answer":1, "weight":1, "comment":"Test comment"},"q6":{"answer":1, "weight":1, "comment":"Test comment"},"q7":{"answer":1, "weight":1, "comment":"Test comment"},"q8":{"answer":1, "weight":1, "comment":"Test comment"}},
	{"name":"Disagree", "cid":"109000795", "q0":{"answer":-1, "weight":1, "comment":"Test comment"},"q1":{"answer":-1, "weight":1, "comment":"Test comment"},"q2":{"answer":-1, "weight":1, "comment":"Test comment"},"q3":{"answer":-1, "weight":1, "comment":"Test comment"},"q4":{"answer":-1, "weight":1, "comment":"Test comment"},"q5":{"answer":-1, "weight":1, "comment":"Test comment"},"q6":{"answer":-1, "weight":1, "comment":"Test comment"},"q7":{"answer":-1, "weight":1, "comment":"Test comment"},"q8":{"answer":-1, "weight":1, "comment":"Test comment"}},
	{"name":"Strongly Disagree important", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q1":{"answer":-2, "weight":1.5, "comment":"Test comment"},"q2":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q3":{"answer":-2, "weight":1.5, "comment":"Test comment"},"q4":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q5":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q6":{"answer":-2, "weight":2, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"Mister Mix", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":"Test comment"},"q1":{"answer":2, "weight":1.5, "comment":"Test comment"},"q2":{"answer":0, "weight":0.5, "comment":"Test comment"},"q3":{"answer":-1, "weight":1.5, "comment":"Test comment"},"q4":{"answer":-1, "weight":0.5, "comment":"Test comment"},"q5":{"answer":1, "weight":0.8, "comment":"Test comment"},"q6":{"answer":2, "weight":1.7, "comment":"Test comment"},"q7":{"answer":1, "weight":1.3, "comment":"Test comment"},"q8":{"answer":-1, "weight":0.7, "comment":"Test comment"}}
];

var matchCandidates = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24];


var matchUser = candidates[0];

var language = 0;

</script>

<div class="row inverted rounded">
	<h1>Compare candidates</h1>
</div>
<br>

<div class="row rounded" >
	<a href="#" class="btn pull-right" onclick="toggleCandidates();return false;" id="showexcess">&laquo; Hide results </a>
	<div>
		<a href="#" class="btn" onclick="toggleButtonPanel('questionbuttons');">Question options</a> <a href="#" class="btn" onclick="toggleButtonPanel('candidatebuttons');">Candidate options</a>
		<div class="buttonholder">
			<div class="questionbuttons buttonpanel rounded">
				<a href="#" class="btn" onclick="excludeQuestions();toggleButtonPanel('questionbuttons');">Ignore checked questions</a><br><a href="#" class="btn" onclick="includeQuestions();toggleButtonPanel('questionbuttons');">Include only checked questions</a><br><a href="#" class="btn" onclick="resetQuestions();toggleButtonPanel('questionbuttons');">Reset all questions</a>
			</div>
			<div class="candidatebuttons buttonpanel rounded">
				<a href="#" class="btn" onclick="excludeCandidates();toggleButtonPanel('candidatebuttons');">Ignore checked candidates</a><br><a href="#" class="btn" onclick="includeCandidates();toggleButtonPanel('candidatebuttons');">Include only checked candidates</a><br><a href="#" class="btn" onclick="compareCandidatesWith();toggleButtonPanel('candidatebuttons');">Compare candidates with...</a><br><a href="#" class="btn" onclick="resetCandidates();toggleButtonPanel('candidatebuttons');">Reset all candidates</a>
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
<script src="js/opentip-jquery.js"></script>

<?php include 'footer.php'; ?>
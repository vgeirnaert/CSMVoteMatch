<?php include 'header.php'; 

// code to handle the user supplied answers if he came here from survey.php
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

/*
// database related code to retrieve questions and candidate answers
include 'database.php';

// connect to our database
$mysqli = connectDB();

// get all questions from the db
include 'questions.php';

// get the candidate answers from the db
$stmt = $mysqli->prepare("SELECT * FROM answers AS a LEFT JOIN candidates AS c ON a.candidateid = c.id LEFT JOIN questions AS q ON a.questionid = q.id WHERE q.electionid = ? GROUP BY c.id");
$stmt->bind_param("i", Config::active_election);
$stmt->execute();

// print start of our javascript candidates array:
echo 'var candidates = [';

// include user details
makeUserAnswers();

// print database result rows as javascript array elements
while($row = $result->fetch_assoc()){
	echo '{"name":"All Strongly Disagree", "cid":"109000795", "q0":{"answer":-2, "weight":1, "comment":"Test comment <br>newline"},"q1":{"answer":-2, "weight":1, "comment":""},"q2":{"answer":-2, "weight":1, "comment":""},"q3":{"answer":-2, "weight":1, "comment":""},"q4":{"answer":-2, "weight":1, "comment":""},"q5":{"answer":-2, "weight":1, "comment":""},"q6":{"answer":-2, "weight":1, "comment":""},"q7":{"answer":-2, "weight":1, "comment":""},"q8":{"answer":-2, "weight":1, "comment":""}},';
}

// print end of the javascript array
echo '];';

// close the db connection
disconnectDB($mysqli);
*/
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
	

var matchQuestions = [];

var candidates = [
	<?php echo makeUserAnswers(); ?>
	{"name":"All Strongly Disagree", "cid":"109000795", "q0":{"answer":-2, "weight":1, "comment":"Test comment <br>newline"},"q1":{"answer":-2, "weight":1, "comment":""},"q2":{"answer":-2, "weight":1, "comment":""},"q3":{"answer":-2, "weight":1, "comment":""},"q4":{"answer":-2, "weight":1, "comment":""},"q5":{"answer":-2, "weight":1, "comment":""},"q6":{"answer":-2, "weight":1, "comment":""},"q7":{"answer":-2, "weight":1, "comment":""},"q8":{"answer":-2, "weight":1, "comment":""}},
	{"name":"All Strongly Agree", "cid":"109000795", "q0":{"answer":2, "weight":1, "comment":""},"q1":{"answer":2, "weight":1, "comment":""},"q2":{"answer":2, "weight":1, "comment":""},"q3":{"answer":2, "weight":1, "comment":""},"q4":{"answer":2, "weight":1, "comment":""},"q5":{"answer":2, "weight":1, "comment":""},"q6":{"answer":2, "weight":1, "comment":""},"q7":{"answer":2, "weight":1, "comment":""},"q8":{"answer":2, "weight":1, "comment":""}},
	{"name":"Agree", "cid":"109000795", "q0":{"answer":1, "weight":1, "comment":""},"q1":{"answer":1, "weight":1, "comment":""},"q2":{"answer":1, "weight":1, "comment":""},"q3":{"answer":1, "weight":1, "comment":""},"q4":{"answer":1, "weight":1, "comment":""},"q5":{"answer":1, "weight":1, "comment":""},"q6":{"answer":1, "weight":1, "comment":""},"q7":{"answer":1, "weight":1, "comment":""},"q8":{"answer":1, "weight":1, "comment":""}},
	{"name":"Disagree", "cid":"109000795", "q0":{"answer":-1, "weight":1, "comment":""},"q1":{"answer":-1, "weight":1, "comment":""},"q2":{"answer":-1, "weight":1, "comment":""},"q3":{"answer":-1, "weight":1, "comment":""},"q4":{"answer":-1, "weight":1, "comment":""},"q5":{"answer":-1, "weight":1, "comment":""},"q6":{"answer":-1, "weight":1, "comment":""},"q7":{"answer":-1, "weight":1, "comment":""},"q8":{"answer":-1, "weight":1, "comment":""}},
	{"name":"Strongly Disagree important", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":""},"q1":{"answer":-2, "weight":1.5, "comment":""},"q2":{"answer":-2, "weight":0.5, "comment":""},"q3":{"answer":-2, "weight":1.5, "comment":""},"q4":{"answer":-2, "weight":0.5, "comment":""},"q5":{"answer":-2, "weight":0.5, "comment":""},"q6":{"answer":-2, "weight":2, "comment":""},"q7":{"answer":-2, "weight":1, "comment":""},"q8":{"answer":-2, "weight":1, "comment":""}},
	{"name":"Mister Mix", "cid":"109000795", "q0":{"answer":-2, "weight":0.5, "comment":""},"q1":{"answer":2, "weight":1.5, "comment":""},"q2":{"answer":0, "weight":0.5, "comment":""},"q3":{"answer":-1, "weight":1.5, "comment":""},"q4":{"answer":-1, "weight":0.5, "comment":""},"q5":{"answer":1, "weight":0.8, "comment":""},"q6":{"answer":2, "weight":1.7, "comment":""},"q7":{"answer":1, "weight":1.3, "comment":""},"q8":{"answer":-1, "weight":0.7, "comment":""}},
	{"name":"All Strongly Disagree", "cid":"109000795", "q0":{"answer":-2, "weight":1, "comment":"Test comment 1 "},"q1":{"answer":-2, "weight":1, "comment":"Test comment 2"},"q2":{"answer":-2, "weight":1, "comment":"Test comment 3"},"q3":{"answer":-2, "weight":1, "comment":"Test comment 4"},"q4":{"answer":-2, "weight":1, "comment":"Test comment 5"},"q5":{"answer":-2, "weight":1, "comment":"Test comment 6"},"q6":{"answer":-2, "weight":1, "comment":"Test comment"},"q7":{"answer":-2, "weight":1, "comment":"Test comment"},"q8":{"answer":-2, "weight":1, "comment":"Test comment"}},
	{"name":"All Strongly Agree", "cid":"109000795", "q0":{"answer":2, "weight":1, "comment":"Test comment 1"},"q1":{"answer":2, "weight":1, "comment 2":"Test comment"},"q2":{"answer":2, "weight":1, "comment":"Test comment 3"},"q3":{"answer":2, "weight":1, "comment":"Test comment"},"q4":{"answer":2, "weight":1, "comment":"Test comment"},"q5":{"answer":2, "weight":1, "comment":"Test comment"},"q6":{"answer":2, "weight":1, "comment":"Test comment"},"q7":{"answer":2, "weight":1, "comment":"Test comment"},"q8":{"answer":2, "weight":1, "comment":"Test comment"}},
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
	<a href="#" class="btn pull-right" onclick="toggleCandidates();return false;" id="showexcess">&laquo; Hide results </a>
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
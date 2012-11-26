<?php include 'header.php'; ?>

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
//var matchQuestions = [0,2,4,6,8];

var candidates = [
	{"name":"All Strongly Disagree", "cid":"109000795", "q1_answer":-2, "q1_weight":1,"q2_answer":-2, "q2_weight":1,"q3_answer":-2, "q3_weight":1,"q4_answer":-2, "q4_weight":1,"q5_answer":-2, "q5_weight":1,"q6_answer":-2, "q6_weight":1,"q7_answer":-2, "q7_weight":1,"q8_answer":-2, "q8_weight":1,"q9_answer":-2, "q9_weight":1},
	{"name":"All Strongly Agree", "cid":"109000795", "q1_answer":2, "q1_weight":1,"q2_answer":2, "q2_weight":1,"q3_answer":2, "q3_weight":1,"q4_answer":2, "q4_weight":1,"q5_answer":2, "q5_weight":1,"q6_answer":2, "q6_weight":1,"q7_answer":2, "q7_weight":1,"q8_answer":2, "q8_weight":1,"q9_answer":2, "q9_weight":1},
	{"name":"Agree", "cid":"109000795", "q1_answer":1, "q1_weight":1,"q2_answer":1, "q2_weight":1,"q3_answer":1, "q3_weight":1,"q4_answer":1, "q4_weight":1,"q5_answer":1, "q5_weight":1,"q6_answer":1, "q6_weight":1,"q7_answer":1, "q7_weight":1,"q8_answer":1, "q8_weight":1,"q9_answer":1, "q9_weight":1},
	{"name":"Disagree", "cid":"109000795", "q1_answer":-1, "q1_weight":1,"q2_answer":-1, "q2_weight":1,"q3_answer":-1, "q3_weight":1,"q4_answer":-1, "q4_weight":1,"q5_answer":-1, "q5_weight":1,"q6_answer":-1, "q6_weight":1,"q7_answer":-1, "q7_weight":1,"q8_answer":-1, "q8_weight":1,"q9_answer":-1, "q9_weight":1},
	{"name":"Strongly Disagree important", "cid":"109000795", "q1_answer":-2, "q1_weight":2,"q2_answer":-2, "q2_weight":2,"q3_answer":-2, "q3_weight":2,"q4_answer":-2, "q4_weight":1,"q5_answer":-2, "q5_weight":1,"q6_answer":-2, "q6_weight":1,"q7_answer":-2, "q7_weight":0,"q8_answer":-2, "q8_weight":0,"q9_answer":-2, "q9_weight":0},
	{"name":"Mister Mix", "cid":"109000795", "q1_answer":-2, "q1_weight":1.5,"q2_answer":-1, "q2_weight":1.5,"q3_answer":1, "q3_weight":0.5,"q4_answer":2, "q4_weight":0.5,"q5_answer":1, "q5_weight":0.5,"q6_answer":-1, "q6_weight":1.5,"q7_answer":-2, "q7_weight":1.5,"q8_answer":-1, "q8_weight":1,"q9_answer":1, "q9_weight":0.5},
	{"name":"All Strongly Disagree", "cid":"109000795", "q1_answer":-2, "q1_weight":1,"q2_answer":-2, "q2_weight":1,"q3_answer":-2, "q3_weight":1,"q4_answer":-2, "q4_weight":1,"q5_answer":-2, "q5_weight":1,"q6_answer":-2, "q6_weight":1,"q7_answer":-2, "q7_weight":1,"q8_answer":-2, "q8_weight":1,"q9_answer":-2, "q9_weight":1},
	{"name":"All Strongly Agree", "cid":"109000795", "q1_answer":2, "q1_weight":1,"q2_answer":2, "q2_weight":1,"q3_answer":2, "q3_weight":1,"q4_answer":2, "q4_weight":1,"q5_answer":2, "q5_weight":1,"q6_answer":2, "q6_weight":1,"q7_answer":2, "q7_weight":1,"q8_answer":2, "q8_weight":1,"q9_answer":2, "q9_weight":1},
	{"name":"Agree", "cid":"109000795", "q1_answer":1, "q1_weight":1,"q2_answer":1, "q2_weight":1,"q3_answer":1, "q3_weight":1,"q4_answer":1, "q4_weight":1,"q5_answer":1, "q5_weight":1,"q6_answer":1, "q6_weight":1,"q7_answer":1, "q7_weight":1,"q8_answer":1, "q8_weight":1,"q9_answer":1, "q9_weight":1},
	{"name":"Disagree", "cid":"109000795", "q1_answer":-1, "q1_weight":1,"q2_answer":-1, "q2_weight":1,"q3_answer":-1, "q3_weight":1,"q4_answer":-1, "q4_weight":1,"q5_answer":-1, "q5_weight":1,"q6_answer":-1, "q6_weight":1,"q7_answer":-1, "q7_weight":1,"q8_answer":-1, "q8_weight":1,"q9_answer":-1, "q9_weight":1},
	{"name":"Strongly Disagree important", "cid":"109000795", "q1_answer":-2, "q1_weight":2,"q2_answer":-2, "q2_weight":2,"q3_answer":-2, "q3_weight":2,"q4_answer":-2, "q4_weight":1,"q5_answer":-2, "q5_weight":1,"q6_answer":-2, "q6_weight":1,"q7_answer":-2, "q7_weight":0,"q8_answer":-2, "q8_weight":0,"q9_answer":-2, "q9_weight":0},
	{"name":"Mister Mix", "cid":"109000795", "q1_answer":-2, "q1_weight":1.5,"q2_answer":-1, "q2_weight":1.5,"q3_answer":1, "q3_weight":0.5,"q4_answer":2, "q4_weight":0.5,"q5_answer":1, "q5_weight":0.5,"q6_answer":-1, "q6_weight":1.5,"q7_answer":-2, "q7_weight":1.5,"q8_answer":-1, "q8_weight":1,"q9_answer":1, "q9_weight":0.5},
	{"name":"All Strongly Disagree", "cid":"109000795", "q1_answer":-2, "q1_weight":1,"q2_answer":-2, "q2_weight":1,"q3_answer":-2, "q3_weight":1,"q4_answer":-2, "q4_weight":1,"q5_answer":-2, "q5_weight":1,"q6_answer":-2, "q6_weight":1,"q7_answer":-2, "q7_weight":1,"q8_answer":-2, "q8_weight":1,"q9_answer":-2, "q9_weight":1},
	{"name":"All Strongly Agree", "cid":"109000795", "q1_answer":2, "q1_weight":1,"q2_answer":2, "q2_weight":1,"q3_answer":2, "q3_weight":1,"q4_answer":2, "q4_weight":1,"q5_answer":2, "q5_weight":1,"q6_answer":2, "q6_weight":1,"q7_answer":2, "q7_weight":1,"q8_answer":2, "q8_weight":1,"q9_answer":2, "q9_weight":1},
	{"name":"Agree", "cid":"109000795", "q1_answer":1, "q1_weight":1,"q2_answer":1, "q2_weight":1,"q3_answer":1, "q3_weight":1,"q4_answer":1, "q4_weight":1,"q5_answer":1, "q5_weight":1,"q6_answer":1, "q6_weight":1,"q7_answer":1, "q7_weight":1,"q8_answer":1, "q8_weight":1,"q9_answer":1, "q9_weight":1},
	{"name":"Disagree", "cid":"109000795", "q1_answer":-1, "q1_weight":1,"q2_answer":-1, "q2_weight":1,"q3_answer":-1, "q3_weight":1,"q4_answer":-1, "q4_weight":1,"q5_answer":-1, "q5_weight":1,"q6_answer":-1, "q6_weight":1,"q7_answer":-1, "q7_weight":1,"q8_answer":-1, "q8_weight":1,"q9_answer":-1, "q9_weight":1},
	{"name":"Strongly Disagree important", "cid":"109000795", "q1_answer":-2, "q1_weight":2,"q2_answer":-2, "q2_weight":2,"q3_answer":-2, "q3_weight":2,"q4_answer":-2, "q4_weight":1,"q5_answer":-2, "q5_weight":1,"q6_answer":-2, "q6_weight":1,"q7_answer":-2, "q7_weight":0,"q8_answer":-2, "q8_weight":0,"q9_answer":-2, "q9_weight":0},
	{"name":"Mister Mix", "cid":"109000795", "q1_answer":-2, "q1_weight":1.5,"q2_answer":-1, "q2_weight":1.5,"q3_answer":1, "q3_weight":0.5,"q4_answer":2, "q4_weight":0.5,"q5_answer":1, "q5_weight":0.5,"q6_answer":-1, "q6_weight":1.5,"q7_answer":-2, "q7_weight":1.5,"q8_answer":-1, "q8_weight":1,"q9_answer":1, "q9_weight":0.5},
	{"name":"All Strongly Disagree", "cid":"109000795", "q1_answer":-2, "q1_weight":1,"q2_answer":-2, "q2_weight":1,"q3_answer":-2, "q3_weight":1,"q4_answer":-2, "q4_weight":1,"q5_answer":-2, "q5_weight":1,"q6_answer":-2, "q6_weight":1,"q7_answer":-2, "q7_weight":1,"q8_answer":-2, "q8_weight":1,"q9_answer":-2, "q9_weight":1},
	{"name":"All Strongly Agree", "cid":"109000795", "q1_answer":2, "q1_weight":1,"q2_answer":2, "q2_weight":1,"q3_answer":2, "q3_weight":1,"q4_answer":2, "q4_weight":1,"q5_answer":2, "q5_weight":1,"q6_answer":2, "q6_weight":1,"q7_answer":2, "q7_weight":1,"q8_answer":2, "q8_weight":1,"q9_answer":2, "q9_weight":1},
	{"name":"Agree", "cid":"109000795", "q1_answer":1, "q1_weight":1,"q2_answer":1, "q2_weight":1,"q3_answer":1, "q3_weight":1,"q4_answer":1, "q4_weight":1,"q5_answer":1, "q5_weight":1,"q6_answer":1, "q6_weight":1,"q7_answer":1, "q7_weight":1,"q8_answer":1, "q8_weight":1,"q9_answer":1, "q9_weight":1},
	{"name":"Disagree", "cid":"109000795", "q1_answer":-1, "q1_weight":1,"q2_answer":-1, "q2_weight":1,"q3_answer":-1, "q3_weight":1,"q4_answer":-1, "q4_weight":1,"q5_answer":-1, "q5_weight":1,"q6_answer":-1, "q6_weight":1,"q7_answer":-1, "q7_weight":1,"q8_answer":-1, "q8_weight":1,"q9_answer":-1, "q9_weight":1},
	{"name":"Strongly Disagree important", "cid":"109000795", "q1_answer":-2, "q1_weight":2,"q2_answer":-2, "q2_weight":2,"q3_answer":-2, "q3_weight":2,"q4_answer":-2, "q4_weight":1,"q5_answer":-2, "q5_weight":1,"q6_answer":-2, "q6_weight":1,"q7_answer":-2, "q7_weight":0,"q8_answer":-2, "q8_weight":0,"q9_answer":-2, "q9_weight":0},
	{"name":"Mister Mix", "cid":"109000795", "q1_answer":-2, "q1_weight":1.5,"q2_answer":-1, "q2_weight":1.5,"q3_answer":1, "q3_weight":0.5,"q4_answer":2, "q4_weight":0.5,"q5_answer":1, "q5_weight":0.5,"q6_answer":-1, "q6_weight":1.5,"q7_answer":-2, "q7_weight":1.5,"q8_answer":-1, "q8_weight":1,"q9_answer":1, "q9_weight":0.5}
];

var matchCandidates = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
//var matchCandidates = [3,4,5];

var matchUser = candidates[5];

var language = 2;

</script>

<div class="row inverted rounded">
	<h1>Compare candidates</h1>
</div>
<br>

<div class="row rounded" >
	<b><a href="#" class="btn pull-right" onclick="toggleCandidates();return false;" id="showexcess">Show all candidates &raquo;</a></b><br><br>
	<div id="contentholder">		
	</div>
</div>

<script src="js/compare.js"></script>

<?php include 'footer.php'; ?>
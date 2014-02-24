<?php 
error_reporting(E_ALL);

ini_set('session.gc_maxlifetime', 20800);
session_start();

if(isset($_SESSION["cdata"])) {
	$cdetails = $_SESSION["cdata"];
	
	$pagetitle = "Edit candidate details for " . $cdetails["charname"];

	include 'header.php'; 
	require 'questions.php';
?>
<div class="row inverted rounded">
	<h1>Edit candidate: <?php echo $cdetails["charname"]; ?></h1>
</div>
<br>
<div class="row rounded">
	<div class="span11 coverview rounded">
		<a href="processlogin.php" class="btn btn-large btn-danger">Log out</a>
		<a href="editcandidate.php" class="btn btn-large btn-primary pull-right">Click here to set or change your profile details &raquo;</a>
		<br><b>Notice:</b> We recommend <i>saving your progress every 30 minutes or so</i> to avoid session timeout. You'll be able to continue where you left off afterwards. We apologise for the inconvenience.
	</div>
	<form method="post" action="processanswers.php" name="survey" onsubmit="return checkForm();">
<?php
	require_once 'database.php';
	require_once 'answer_class.php';

	$id = $cdetails["id"];
	try {
		$pdo = VotematchDB::getConnection();

		// get okc answers
		$stmt = $pdo->prepare("SELECT o.question_id, a.answer_id, a.weight, a.comment FROM okc_answers AS a LEFT JOIN okc_options AS o ON a.answer_id = o.id WHERE a.candidate_id = :cid ORDER BY o.question_id ASC");
		$stmt->execute(array('cid', $id));

		VotematchDB::bindAll($stmt, array($question_id, $answer, $weight, $comment));
		$answers_okc = array();
		while($stmt->fetch(PDO::FETCH_BOUND)) {
			array_push($answers_okc, new Answer($question_id, $answer, $weight, $comment));
		}
		$stmt->closeCursor();

		VotematchDB::close();
	} catch (Exception $e) {
		echo '<p><h2>Error connecting to database:</h2>' . $e->getMessage() . '</p>';
	}

	$theQuestions = new Questions();
	//$theQuestions->initClassicQuestions();
	$theQuestions->initOKCQuestions(true);
?>
		</table>
	</div> -->
	
	<div class="span11 coverview rounded">
		<h2>Questions</h2>
		Please answer the following 60 questions. In addition to the answers you can set the importance of each issue and you can add a comment explaining your answer.<br><br>
		It is possible to answer only some of the questions and answer the rest later, as long as you make sure to submit your partial answers using the 'Submit answers' button at the bottom of the page.
<?php
	echo $theQuestions->printOKCQuestions($answers_okc);
	echo $theQuestions->getOKCIds();
?>
	</div>	
	<div class="span6">
		<br><br>
		<input type="submit" value="Submit answers" class="pull-right btn btn-warning" style="font-size:30px; line-height: 60px;" />
	</div>
	</form>
</div>
<script src="js/survey.js"></script>
<script type="text/javascript">
<?php
	//echo $theQuestions->getClassicQuestionsArray();
	//echo "\n\n";
	echo $theQuestions->getOKCQuestionsArray();
?>
/*var opinions = [
	["Strongly disagree", "Trifft gar nicht zu", "&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080;&#32;&#1085;&#1077;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1089;&#1077;&#1085;", "&#20840;&#12367;&#21516;&#24847;&#12391;&#12365;&#12394;&#12356;"],
	["Disagree", "Nicht &uuml;bereinstimmen", "&#1085;&#1077;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1072;&#1090;&#1100;&#1089;&#1103;", "&#21516;&#24847;&#12375;&#12394;&#12356;"],
	["No opinion", "Keine Meinung", "&#1053;&#1077;&#1090;&#32;&#1084;&#1085;&#1077;&#1085;&#1080;&#1103;", "&#24847;&#35211;&#12394;&#12375;"],
	["Agree", "Stimme zu", "&#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1072;&#1090;&#1100;&#1089;&#1103;", "&#21516;&#24847;&#12377;&#12427;"],
	["Strongly agree", "Stimme voll zu", "&#1055;&#1086;&#1083;&#1085;&#1086;&#1089;&#1090;&#1100;&#1102;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1089;&#1077;&#1085;", "&#24375;&#12367;&#21516;&#24847;&#12377;&#12427;"],
	["Importance", "Bedeutung", "&#1079;&#1085;&#1072;&#1095;&#1077;&#1085;&#1080;&#1077;", "&#37325;&#35201;&#24615;"],
];*/

var explanations = ["<b>Election questionnaire</b><br>After filling in this questionnaire, your answers will be compared to the answers from the CSM candidates and a matching percentage will be calculated. You can adjust the importance of the questions relative to eachother with the plus and minus buttons. Note that you need to assign all importance points in order to submit the questionnaire.",
"<b>Wahl Fragebogen</b><br>Nach dem Ausf&#252;llen dieses Fragebogens werden Ihre Antworten auf die Antworten von den CSM Kandidaten verglichen werden und eine passende Prozentsatz berechnet werden. Sie k&#246;nnen die Bedeutung der Fragen relativ zueinander mit den Plus-und Minus-Tasten.",
"<b>&#1042;&#1099;&#1073;&#1086;&#1088;&#1099;&#32;&#1072;&#1085;&#1082;&#1077;&#1090;&#1099;</b><br>&#1055;&#1086;&#1089;&#1083;&#1077;&#32;&#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1080;&#1103;&#32;&#1101;&#1090;&#1086;&#1081;&#32;&#1072;&#1085;&#1082;&#1077;&#1090;&#1099;&#44;&#32;&#1042;&#1072;&#1096;&#1080;&#32;&#1086;&#1090;&#1074;&#1077;&#1090;&#1099;&#32;&#1073;&#1091;&#1076;&#1091;&#1090;&#32;&#1089;&#1088;&#1072;&#1074;&#1085;&#1080;&#1074;&#1072;&#1090;&#1100;&#1089;&#1103;&#32;&#1089;&#32;&#1086;&#1090;&#1074;&#1077;&#1090;&#1072;&#1084;&#1080;&#32;&#1086;&#1090;&#32;&#67;&#83;&#77;&#32;&#1082;&#1072;&#1085;&#1076;&#1080;&#1076;&#1072;&#1090;&#1086;&#1074;&#32;&#1080;&#32;&#1089;&#1086;&#1086;&#1090;&#1074;&#1077;&#1090;&#1089;&#1090;&#1074;&#1091;&#1102;&#1097;&#1080;&#1077;&#32;&#1087;&#1088;&#1086;&#1094;&#1077;&#1085;&#1090;&#32;&#1073;&#1091;&#1076;&#1077;&#1090;&#32;&#1088;&#1072;&#1089;&#1089;&#1095;&#1080;&#1090;&#1072;&#1085;&#46;&#32;&#1042;&#1099;&#32;&#1084;&#1086;&#1078;&#1077;&#1090;&#1077;&#32;&#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1080;&#1090;&#1100;&#32;&#1074;&#1072;&#1078;&#1085;&#1086;&#1089;&#1090;&#1100;&#32;&#1074;&#1086;&#1087;&#1088;&#1086;&#1089;&#1086;&#1074;&#32;&#1086;&#1090;&#1085;&#1086;&#1089;&#1080;&#1090;&#1077;&#1083;&#1100;&#1085;&#1086;&#32;&#1076;&#1088;&#1091;&#1075;&#32;&#1076;&#1088;&#1091;&#1075;&#1072;&#32;&#1089;&#32;&#1087;&#1083;&#1102;&#1089;&#1086;&#1084;&#32;&#1080;&#32;&#1084;&#1080;&#1085;&#1091;&#1089;&#1086;&#1084;&#32;&#1082;&#1085;&#1086;&#1087;&#1082;&#1072;&#1084;&#1080;&#46;",
"<b>&#36984;&#25369;&#12450;&#12531;&#12465;&#12540;&#12488;</b><br>&#12371;&#12398;&#12450;&#12531;&#12465;&#12540;&#12488;&#12395;&#35352;&#20837;&#12375;&#12383;&#24460;&#12289;&#12354;&#12394;&#12383;&#12398;&#31572;&#12360;&#12399;&#67;&#83;&#77;&#20505;&#35036;&#32773;&#12363;&#12425;&#12398;&#22238;&#31572;&#12392;&#27604;&#36611;&#12377;&#12427;&#12392;&#12289;&#19968;&#33268;&#29575;&#12364;&#35336;&#31639;&#12373;&#12428;&#12414;&#12377;&#12290;&#12354;&#12394;&#12383;&#12399;&#12289;&#12503;&#12521;&#12473;&#12392;&#12510;&#12452;&#12490;&#12473;&#12398;&#12508;&#12479;&#12531;&#12434;&#20351;&#12387;&#12390;&#12362;&#20114;&#12356;&#12395;&#30456;&#23550;&#30340;&#12394;&#36074;&#21839;&#12398;&#37325;&#35201;&#24230;&#12434;&#35519;&#25972;&#12377;&#12427;&#12371;&#12392;&#12364;&#12391;&#12365;&#12414;&#12377;&#12290;"
];

var okc_ans_translations = ["Answers I will accept from a candidate:", "Antworten werde ich von einem Kandidaten akzeptieren:", "&#1054;&#1090;&#1074;&#1077;&#1090;&#1099; &#1103; &#1073;&#1091;&#1076;&#1091; &#1087;&#1088;&#1080;&#1085;&#1080;&#1084;&#1072;&#1090;&#1100; &#1086;&#1090; &#1082;&#1072;&#1085;&#1076;&#1080;&#1076;&#1072;&#1090;&#1086;&#1074;:", "&#31572;&#12360;&#12399;&#31169;&#12364;&#20505;&#35036;&#12363;&#12425;&#21463;&#12369;&#20184;&#12369;&#12414;&#12377;&#12290;"];
var okc_imp_translations = ["How important is this issue to you?", "Wie wichtig ist dieses Thema f&#252;r Sie?", "&#1053;&#1072;&#1089;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1074;&#1072;&#1078;&#1085;&#1072; &#1101;&#1090;&#1072; &#1087;&#1088;&#1086;&#1073;&#1083;&#1077;&#1084;&#1072; &#1076;&#1083;&#1103; &#1074;&#1072;&#1089;?", "&#12354;&#12394;&#12383;&#12395;&#12371;&#12398;&#21839;&#38988;&#12364;&#12393;&#12428;&#12367;&#12425;&#12356;&#37325;&#35201;&#12391;&#12377;&#12363;&#65311;"];
var okc_imp_ni_translations = ["Irrelevant", "&#220;berhaupt nicht wichtig", "&#1053;&#1077; &#1074;&#1072;&#1078;&#1085;&#1086; &#1085;&#1072; &#1074;&#1089;&#1077;&#1093;", "&#12414;&#12387;&#12383;&#12367;&#37325;&#35201;&#12391;&#12399;&#12354;&#12426;&#12414;&#12379;&#12435;"];
var okc_imp_li_translations = ["A little important", "Ein wenig wichtig", "&#1053;&#1077;&#1084;&#1085;&#1086;&#1075;&#1086; &#1074;&#1072;&#1078;&#1085;&#1099;&#1093;", "&#23569;&#12375;&#37325;&#35201;"];
var okc_imp_si_translations = ["Somewhat important", "Etwas wichtig", "&#1053;&#1077;&#1089;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1074;&#1072;&#1078;&#1085;&#1099;&#1093;", "&#12420;&#12420;&#37325;&#35201;"];
var okc_imp_vi_translations = ["Very important", "Sehr wichtig", "&#1054;&#1095;&#1077;&#1085;&#1100; &#1074;&#1072;&#1078;&#1085;&#1086;", "&#38750;&#24120;&#12395;&#37325;&#35201;&#12394;"];
var okc_imp_ma_translations = ["Mandatory", "Verpflichtend", "&#1086;&#1073;&#1103;&#1079;&#1072;&#1090;&#1077;&#1083;&#1100;&#1085;&#1099;&#1081;", "&#24517;&#38920;&#12398;"];

//var weights = [];
var language=0;

var freePoints = 0.0;
var maxPoints = questions.length;

// script entry point
start();

function checkForm() {
	if(validateForm()) {
		return true;
	}
	
	return false;
}
</script>
<?php	
	$theQuestions->closeDB();
	include 'footer.php'; 
}

/*function printWeightsArray($answers, $theQuestions) {
	$js = "[";
	for($i = 0; $i < $theQuestions->getNumClassicQuestions(); $i++) {
		if($i > 0)
			$js .= ", ";
			
		if(isset($answers[$i]))
			$js .= $answers[$i]->getWeight();
		else 
			$js .= '1.0';
	}
	
	$js .= "];";
	
	echo $js;
}*/
?>
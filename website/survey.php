<?php 
require 'questions.php';
require 'header.php'; 
?>
<div class="row inverted rounded">
	<h1>Questionnaire</h1>
</div>
<br>
<div class="row rounded">
	<div class="span2"><img src="img/gb.png" onclick="changeLanguage(0);"> <img src="img/de.png" onclick="changeLanguage(1);"> <img src="img/ru.png" onclick="changeLanguage(2);"> <img src="img/it.png" onclick="changeLanguage(3);"></div>
	<form method="post" action="compare.php" name="survey" onsubmit="return validateForm();">
	<div class="span11 coverview rounded" id="explanation">
		<b>Election questionnaire</b><br>
		After filling in this questionnaire, your answers will be compared to the answers from the CSM candidates and a match percentage will be calculated. Any questions marked as 'Irrelevant' will not count towards your match percentage.
	</div>
	
<?php
$theQuestions = new Questions();

?>
	<div class="span11 coverview rounded">
		<h2>Questions</h2>
<?php
$theQuestions->initOKCQuestions(false);
$theQuestions->closeDB();
echo $theQuestions->printOKCQuestions(null);
echo $theQuestions->getOKCIds();
?>
		<br>
	</div>
	<div class="span6">
		<br><br>
		<input type="submit" value="Calculate match!" class="pull-right btn btn-warning" style="font-size:30px; line-height: 60px;" />
	</div>
	</form>
</div>
<script src="js/survey.js"></script>
<script type="text/javascript">
<?php
echo $theQuestions->getOKCQuestionsArray();
?>



var explanations = ["<b>Election questionnaire</b><br>After filling in this questionnaire, your answers will be compared to the answers from the CSM candidates and a match percentage will be calculated. Any questions marked as 'Irrelevant' will not count towards your match percentage.",
"<b>Wahlbogen</b><br>Nachdem du diesen Fragebogen ausgef&#252;llt hast werden deine Antworten mit den Antworten der CSM Kandidaten verglichen und es wird ein Wert errechnet anhand dessen du sehen kannst wie gut eure Ansichten zusammenpassen. Fragen die du als irrelevant markiert hast werden dabei nicht ber&#252;cksichtigt,",
"<b>&#1054;&#1087;&#1088;&#1086;&#1089;&#1085;&#1080;&#1082; &#1042;&#1099;&#1073;&#1086;&#1088;&#1086;&#1074;</b><br>&#1055;&#1086;&#1089;&#1083;&#1077; &#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1080;&#1103; &#1086;&#1087;&#1088;&#1086;&#1089;&#1085;&#1080;&#1082;&#1072;, &#1074;&#1072;&#1096;&#1080; &#1086;&#1090;&#1074;&#1077;&#1090;&#1099; &#1073;&#1091;&#1076;&#1091;&#1090; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1099; &#1089; &#1086;&#1090;&#1074;&#1077;&#1090;&#1072;&#1084;&#1080; &#1082;&#1072;&#1085;&#1076;&#1080;&#1076;&#1072;&#1090;&#1086;&#1074; CSM &#1080; &#1073;&#1091;&#1076;&#1077;&#1090; &#1088;&#1072;&#1089;&#1095;&#1080;&#1090;&#1072;&#1085; &#1087;&#1088;&#1086;&#1094;&#1077;&#1085;&#1090; &#1089;&#1086;&#1074;&#1087;&#1072;&#1076;&#1077;&#1085;&#1080;&#1081;. &#1051;&#1102;&#1073;&#1099;&#1077; &#1074;&#1086;&#1087;&#1088;&#1086;&#1089;&#1099; &#1086;&#1090;&#1084;&#1077;&#1095;&#1077;&#1085;&#1085;&#1099;&#1077; &#1082;&#1072;&#1082; '&#1053;&#1077;&#1074;&#1072;&#1078;&#1085;&#1086;' &#1085;&#1077; &#1073;&#1091;&#1076;&#1091;&#1090; &#1079;&#1072;&#1089;&#1095;&#1080;&#1090;&#1072;&#1085;&#1099; &#1087;&#1088;&#1080; &#1088;&#1072;&#1089;&#1095;&#1077;&#1090;&#1077; &#1089;&#1086;&#1074;&#1087;&#1072;&#1076;&#1077;&#1085;&#1080;&#1081;.",
"<b>Questonario sulle elezioni</b><br>Dopo aver compilato il questionario, le risposte saranno confrontate con le risposte date dai candidati del CSM e sar&#224; calcolata una percentuale di corrispondenza. Qualsiasi domanda indicata come 'irrilevante' non conter&#224; per la percentuale."
];

var okc_ans_translations = ["Answers I will accept from a candidate:", "Antworten die ich bei einem Kanditaten akzeptiere:", "&#1052;&#1085;&#1077; &#1087;&#1086;&#1076;&#1086;&#1081;&#1076;&#1091;&#1090; &#1083;&#1102;&#1073;&#1099;&#1077; &#1080;&#1079; &#1089;&#1083;&#1077;&#1076;&#1091;&#1102;&#1097;&#1080;&#1093; &#1086;&#1090;&#1074;&#1077;&#1090;&#1086;&#1074; &#1082;&#1072;&#1085;&#1076;&#1080;&#1076;&#1072;&#1090;&#1086;&#1074;:", "Risposte che io accetter&#242; da un candidato:"];
var okc_imp_translations = ["How important is this issue to you?", "Wie wichtig ist dir diese Sache?", "&#1053;&#1072;&#1089;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1074;&#1072;&#1078;&#1077;&#1085; &#1101;&#1090;&#1086;&#1090; &#1074;&#1086;&#1087;&#1088;&#1086;&#1089; &#1076;&#1083;&#1103; &#1074;&#1072;&#1089;?", "Quanto ritieni importante questo argomento?"];
var okc_imp_ni_translations = ["Irrelevant", "Irrelevant", "&#1053;&#1077;&#1074;&#1072;&#1078;&#1085;&#1086;", "Irrilevante"];
var okc_imp_li_translations = ["A little important", "Ein bisschen wichtig", "&#1052;&#1072;&#1083;&#1086;&#1079;&#1085;&#1072;&#1095;&#1080;&#1084;&#1086;", "Poco importante"];
var okc_imp_si_translations = ["Somewhat important", "Irgendwie schon wichtig", "&#1057;&#1088;&#1077;&#1076;&#1085;&#1077;&#1081; &#1074;&#1072;&#1078;&#1085;&#1086;&#1089;&#1090;&#1080;", "Abbastanza importante"];
var okc_imp_vi_translations = ["Very important", "Sehr wichtig", "&#1054;&#1095;&#1077;&#1085;&#1100; &#1074;&#1072;&#1078;&#1085;&#1086;", "Molto importante"];
var okc_imp_ma_translations = ["Mandatory", "Zwingend", "&#1054;&#1073;&#1103;&#1079;&#1072;&#1090;&#1077;&#1083;&#1100;&#1085;&#1086;", "Obbligatorio"];

<?php
echo "var language=" . getLang($_GET["lang"]) . ";";

function getLang($lang) {
	switch($lang) {
		case "ger":
			return 1;
			break;
		case "rus":
			return 2;
			break;
		case "it":
			return 3;
			break;
		default:
			return 0;
			break;
	}
}

?>

// script entry point
start();


</script>

<?php include 'footer.php'; ?>
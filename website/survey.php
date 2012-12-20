<?php include 'header.php'; ?>

<script type="text/javascript" src="js/vendor/jquery.carouFredSel-6.1.0-packed.js"></script>

<div class="row inverted rounded">
	<h1>Questionnaire</h1>
</div>
<br>
<div class="row rounded">
	<form method="post" action="compare.php" name="survey" onsubmit="return validateForm();">
	<div class="span11 coverview rounded" id="explanation">
		<b>Election questionnaire</b><br>
		After filling in this questionnaire, your answers will be compared to the answers from the CSM candidates and a matching percentage will be calculated. You can adjust the importance of the questions relative to eachother with the plus and minus buttons.
	</div>
	<div class="span2 pull-right coverview rounded">
		<h2>Importance</h2>
		<b>Points to distribute:</b>
		<h2 id="counter"></h2>
		<b>Adjust all questions:</b><br>
		<a href="#" class="btn" onclick="changeAllValues(-0.1); return false;"><b>-</b></a> <a href="#" class="btn" onclick="changeAllValues(0.1); return false;"><b>+</b></a>
	</div>
	<div class="span9 coverview rounded">
	<h2>Statements</h2>
	<table>
		<tr class="header">
			<th><div class="flags span2"><img src="img/gb.png" onclick="changeLanguage(0);"> <img src="img/de.png" onclick="changeLanguage(1);"> <img src="img/ru.png" onclick="changeLanguage(2);"> <img src="img/jp.png" onclick="changeLanguage(3);"></div></th>
			<th class="answer even">
				Strongly disagree
			</th>
			<th class="answer uneven">
				Disagree
			</th>
			<th class="answer even">
				No opinion
			</th>
			<th class="answer uneven">
				Agree
			</th>
			<th class="answer even">
				Strongly agree
			</th>
			<th class="answer uneven">
				Importance
			</th>
		</tr>
		<tr class="qrow even">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q0" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q0" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q0" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q0" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q0" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(0); return false;" class="btn btnsmall">-</a><input type="text" name="q0_weight" value="1" width="2" onchange="changeValue(0);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(0); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
		<tr class="qrow uneven">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q1" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q1" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q1" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q1" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q1" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(1); return false;" class="btn btnsmall">-</a><input type="text" name="q1_weight" value="1" width="2"  onchange="changeValue(1);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(1); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
		<tr class="qrow even">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q2" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q2" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q2" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q2" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q2" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(2); return false;" class="btn btnsmall">-</a><input type="text" name="q2_weight" value="1" width="2"  onchange="changeValue(2);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(2); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
		<tr class="qrow uneven">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q3" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q3" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q3" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q3" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q3" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(3); return false;" class="btn btnsmall">-</a><input type="text" name="q3_weight" value="1" width="2"  onchange="changeValue(3);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(3); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
		<tr class="qrow even">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q4" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q4" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q4" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q4" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q4" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(4); return false;" class="btn btnsmall">-</a><input type="text" name="q4_weight" value="1" width="2"  onchange="changeValue(4);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(4); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
		<tr class="qrow uneven">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q5" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q5" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q5" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q5" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q5" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(5); return false;" class="btn btnsmall">-</a><input type="text" name="q5_weight" value="1" width="2"  onchange="changeValue(5);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(5); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
		<tr class="qrow even">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q6" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q6" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q6" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q6" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q6" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(6); return false;" class="btn btnsmall">-</a><input type="text" name="q6_weight" value="1" width="2"  onchange="changeValue(6);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(6); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
		<tr class="qrow uneven">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q7" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q7" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q7" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q7" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q7" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(7); return false;" class="btn btnsmall">-</a><input type="text" name="q7_weight" value="1" width="2"  onchange="changeValue(7);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(7); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
		<tr class="qrow even">
			<td class="question">
			</td>
			<td class="answer">
				<input type="radio" name="q8" value="SD" />
			</td>
			<td class="answer">
				<input type="radio" name="q8" value="D" />
			</td>
			<td class="answer">
				<input type="radio" name="q8" value="NO" checked />
			</td>
			<td class="answer">
				<input type="radio" name="q8" value="A" />
			</td>
			<td class="answer">
				<input type="radio" name="q8" value="SA" />
			</td>
			<td class="answer">
				<a href="#" onclick="decrementWeight(8); return false;" class="btn btnsmall">-</a><input type="text" name="q8_weight" value="1" width="2"  onchange="changeValue(8);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(8); return false;" class="btn btnsmall">+</a>
			</td>
		</tr>
	</table>
	</div>
	<br>
	<div class="span9 coverview rounded">
		<h2>Questions</h2>
		<div id="carousel">
			<div>
				<h3>Question 1</h3>
				Acceptable answers from a candidate:<br>
				<input type="checkbox" /> Answer 1 <br>
				<input type="checkbox" /> Answer 2 <br>
				<input type="checkbox" /> Answer 3 <br>
				<input type="checkbox" /> Answer 4 <br>
				<br>
				How important is this issue to you?<br>
				<select>
					<option>Not important at all</option>
					<option>A little important</option>
					<option>Somewhat important</option>
					<option>Very important</option>
					<option>Mandatory</option>
				</select>
			</div>
			<div>
				<h3>Question 2</h3>
				Acceptable answers from a candidate:<br>
				<input type="checkbox" /> Answer 1 <br>
				<input type="checkbox" /> Answer 2 <br>
				<input type="checkbox" /> Answer 3 <br>
				<br>
				How important is this issue to you?<br>
				<select>
					<option>Not important at all</option>
					<option>A little important</option>
					<option>Somewhat important</option>
					<option>Very important</option>
					<option>Mandatory</option>
				</select>
			</div>
			<div>
				<h3>Question 3</h3>
				Acceptable answers from a candidate:<br>
				<input type="checkbox" /> Answer 1 <br>
				<input type="checkbox" /> Answer 2 <br>
				<input type="checkbox" /> Answer 3 <br>
				<br>
				How important is this issue to you?<br>
				<select>
					<option>Not important at all</option>
					<option>A little important</option>
					<option>Somewhat important</option>
					<option>Very important</option>
					<option>Mandatory</option>
				</select>
			</div>
			<div>
				<h3>Question 4</h3>
				Acceptable answers from a candidate:<br>
				<input type="checkbox" /> Answer 1 <br>
				<input type="checkbox" /> Answer 2 <br>
				<input type="checkbox" /> Answer 3 <br>
				<input type="checkbox" /> Answer 4 <br>
				<input type="checkbox" /> Answer 5 <br>
				<br>
				How important is this issue to you?<br>
				<select>
					<option>Not important at all</option>
					<option>A little important</option>
					<option>Somewhat important</option>
					<option>Very important</option>
					<option>Mandatory</option>
				</select>
			</div>
			<div>
				<h3>Question 5 it's really long just look at it go oh lawdy lawd it's so long I can't believe it, it's like a giant train or a really big snake</h3>
				Acceptable answers from a candidate:<br>
				<input type="checkbox" /> Answer 1 <br>
				<input type="checkbox" /> Answer 2 <br>
				<input type="checkbox" /> Answer 3 <br>
				<input type="checkbox" /> Answer 4 <br>
				<br>
				How important is this issue to you?<br>
				<select>
					<option>Not important at all</option>
					<option>A little important</option>
					<option>Somewhat important</option>
					<option>Very important</option>
					<option>Mandatory</option>
				</select>
			</div>
			<div>
				<h3>Question 6</h3>
				Acceptable answers from a candidate:<br>
				<input type="checkbox" /> Answer 1 <br>
				<input type="checkbox" /> Answer 2 <br>
				<input type="checkbox" /> Answer 3 <br>
				<input type="checkbox" /> Answer 4 <br>
				<br>
				How important is this issue to you?<br>
				<select>
					<option>Not important at all</option>
					<option>A little important</option>
					<option>Somewhat important</option>
					<option>Very important</option>
					<option>Mandatory</option>
				</select>
			</div>
		</div>
		<br>
		<div class="span9">
			<div class="span4">
				<a class="btn prev" id="prev" href="#"><span>&laquo; Previous question</span></a>
			</div>
			<div class="span4" id="pagination">
			</div>
			<div class="span2 pull-right">
				<a class="btn next pull-right" id="next" href="#"><span>Next question &raquo;</span></a>
			</div>
		</div>
	</div>
	<div class="span6">
		<br><br>
		<input type="submit" value="Calculate match!" class="pull-right btn" style="font-size:30px; line-height: 60px;" />
	</div>
	</form>
</div>
<script src="js/survey.js"></script>
<script type="text/javascript">
<?php
/*
// database related code to retrieve questions 
include 'database.php';

// connect to our database
$mysqli = connectDB();

include 'questions.php';

// close the db connection
disconnectDB($mysqli);
*/
?>
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
	
var opinions = [
	["Strongly disagree", "Trifft gar nicht zu", "&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080;&#32;&#1085;&#1077;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1089;&#1077;&#1085;", "&#20840;&#12367;&#21516;&#24847;&#12391;&#12365;&#12394;&#12356;"],
	["Disagree", "Nicht &uuml;bereinstimmen", "&#1085;&#1077;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1072;&#1090;&#1100;&#1089;&#1103;", "&#21516;&#24847;&#12375;&#12394;&#12356;"],
	["No opinion", "Keine Meinung", "&#1053;&#1077;&#1090;&#32;&#1084;&#1085;&#1077;&#1085;&#1080;&#1103;", "&#24847;&#35211;&#12394;&#12375;"],
	["Agree", "Stimme zu", "&#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1072;&#1090;&#1100;&#1089;&#1103;", "&#21516;&#24847;&#12377;&#12427;"],
	["Strongly agree", "Stimme voll zu", "&#1055;&#1086;&#1083;&#1085;&#1086;&#1089;&#1090;&#1100;&#1102;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1089;&#1077;&#1085;", "&#24375;&#12367;&#21516;&#24847;&#12377;&#12427;"],
	["Importance", "Bedeutung", "&#1079;&#1085;&#1072;&#1095;&#1077;&#1085;&#1080;&#1077;", "&#37325;&#35201;&#24615;"],
];

var explanations = ["<b>Election questionnaire</b><br>After filling in this questionnaire, your answers will be compared to the answers from the CSM candidates and a matching percentage will be calculated. You can adjust the importance of the questions relative to eachother with the plus and minus buttons. Note that you need to assign all importance points in order to submit the questionnaire.",
"<b>Wahl Fragebogen</b><br>Nach dem Ausf&#252;llen dieses Fragebogens werden Ihre Antworten auf die Antworten von den CSM Kandidaten verglichen werden und eine passende Prozentsatz berechnet werden. Sie k&#246;nnen die Bedeutung der Fragen relativ zueinander mit den Plus-und Minus-Tasten.",
"<b>&#1042;&#1099;&#1073;&#1086;&#1088;&#1099;&#32;&#1072;&#1085;&#1082;&#1077;&#1090;&#1099;</b><br>&#1055;&#1086;&#1089;&#1083;&#1077;&#32;&#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1080;&#1103;&#32;&#1101;&#1090;&#1086;&#1081;&#32;&#1072;&#1085;&#1082;&#1077;&#1090;&#1099;&#44;&#32;&#1042;&#1072;&#1096;&#1080;&#32;&#1086;&#1090;&#1074;&#1077;&#1090;&#1099;&#32;&#1073;&#1091;&#1076;&#1091;&#1090;&#32;&#1089;&#1088;&#1072;&#1074;&#1085;&#1080;&#1074;&#1072;&#1090;&#1100;&#1089;&#1103;&#32;&#1089;&#32;&#1086;&#1090;&#1074;&#1077;&#1090;&#1072;&#1084;&#1080;&#32;&#1086;&#1090;&#32;&#67;&#83;&#77;&#32;&#1082;&#1072;&#1085;&#1076;&#1080;&#1076;&#1072;&#1090;&#1086;&#1074;&#32;&#1080;&#32;&#1089;&#1086;&#1086;&#1090;&#1074;&#1077;&#1090;&#1089;&#1090;&#1074;&#1091;&#1102;&#1097;&#1080;&#1077;&#32;&#1087;&#1088;&#1086;&#1094;&#1077;&#1085;&#1090;&#32;&#1073;&#1091;&#1076;&#1077;&#1090;&#32;&#1088;&#1072;&#1089;&#1089;&#1095;&#1080;&#1090;&#1072;&#1085;&#46;&#32;&#1042;&#1099;&#32;&#1084;&#1086;&#1078;&#1077;&#1090;&#1077;&#32;&#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1080;&#1090;&#1100;&#32;&#1074;&#1072;&#1078;&#1085;&#1086;&#1089;&#1090;&#1100;&#32;&#1074;&#1086;&#1087;&#1088;&#1086;&#1089;&#1086;&#1074;&#32;&#1086;&#1090;&#1085;&#1086;&#1089;&#1080;&#1090;&#1077;&#1083;&#1100;&#1085;&#1086;&#32;&#1076;&#1088;&#1091;&#1075;&#32;&#1076;&#1088;&#1091;&#1075;&#1072;&#32;&#1089;&#32;&#1087;&#1083;&#1102;&#1089;&#1086;&#1084;&#32;&#1080;&#32;&#1084;&#1080;&#1085;&#1091;&#1089;&#1086;&#1084;&#32;&#1082;&#1085;&#1086;&#1087;&#1082;&#1072;&#1084;&#1080;&#46;",
"<b>&#36984;&#25369;&#12450;&#12531;&#12465;&#12540;&#12488;</b><br>&#12371;&#12398;&#12450;&#12531;&#12465;&#12540;&#12488;&#12395;&#35352;&#20837;&#12375;&#12383;&#24460;&#12289;&#12354;&#12394;&#12383;&#12398;&#31572;&#12360;&#12399;&#67;&#83;&#77;&#20505;&#35036;&#32773;&#12363;&#12425;&#12398;&#22238;&#31572;&#12392;&#27604;&#36611;&#12377;&#12427;&#12392;&#12289;&#19968;&#33268;&#29575;&#12364;&#35336;&#31639;&#12373;&#12428;&#12414;&#12377;&#12290;&#12354;&#12394;&#12383;&#12399;&#12289;&#12503;&#12521;&#12473;&#12392;&#12510;&#12452;&#12490;&#12473;&#12398;&#12508;&#12479;&#12531;&#12434;&#20351;&#12387;&#12390;&#12362;&#20114;&#12356;&#12395;&#30456;&#23550;&#30340;&#12394;&#36074;&#21839;&#12398;&#37325;&#35201;&#24230;&#12434;&#35519;&#25972;&#12377;&#12427;&#12371;&#12392;&#12364;&#12391;&#12365;&#12414;&#12377;&#12290;"
];

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
		case "jp":
			return 3;
			break;
		default:
			return 0;
			break;
	}
}

?>
var weights = [];

// initialise weights
for(var i = 0; i < questions.length; i++)
	weights.push(1);
	

var freePoints = 0.0;
var maxPoints = questions.length;

// script entry point
start();

$(document).ready(function() {
	/*	CarouFredSel: a circular, responsive jQuery carousel.
	Configuration created by the "Configuration Robot"
	at caroufredsel.dev7studios.com
	*/
	$("#carousel").carouFredSel({
		height: "variable",
		direction: "up",
		circular: false,
		infinite: false,
		items: {
			visible: 1,
			height: "variable"
		},
		scroll: 400,
		auto: false,
		prev: "#prev",
		next: "#next",
		pagination: {
			container: "#pagination",
			anchorBuilder: function( nr ) {
				var str  = '<a href="#" class="page rounded">';
				str += nr;
				str += '</a>';
				return str;
				
			}
		}
	});
});
</script>

<?php include 'footer.php'; ?>
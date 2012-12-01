<?php include 'header.php'; ?>

<div class="row inverted rounded">
	<h1>Questionnaire</h1>
</div>
<br>
<div class="row rounded">
	<form method="post" action="compare.php" name="survey" onsubmit="return validateForm();">
	<div class="span2 pull-right coverview rounded">
		<h2>Importance</h2>
		<b>Points to distribute:</b>
		<h2 id="counter"></h2>
		<b>Adjust all questions:</b><br>
		<a href="#" class="btn" onclick="changeAllValues(0.1);"><b>+</b></a> <a href="#" class="btn" onclick="changeAllValues(-0.1);"><b>-</b></a>
	</div>
	<div class="span9">
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
				<a href="#" onclick="decrementWeight(0);" class="btn btnsmall">-</a><input type="text" name="q0_weight" value="1" width="2" onchange="changeValue(0);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(0);" class="btn btnsmall">+</a>
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
				<a href="#" onclick="decrementWeight(1);" class="btn btnsmall">-</a><input type="text" name="q1_weight" value="1" width="2"  onchange="changeValue(1);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(1);" class="btn btnsmall">+</a>
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
				<a href="#" onclick="decrementWeight(2);" class="btn btnsmall">-</a><input type="text" name="q2_weight" value="1" width="2"  onchange="changeValue(2);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(2);" class="btn btnsmall">+</a>
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
				<a href="#" onclick="decrementWeight(3);" class="btn btnsmall">-</a><input type="text" name="q3_weight" value="1" width="2"  onchange="changeValue(3);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(3);" class="btn btnsmall">+</a>
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
				<a href="#" onclick="decrementWeight(4);" class="btn btnsmall">-</a><input type="text" name="q4_weight" value="1" width="2"  onchange="changeValue(4);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(4);" class="btn btnsmall">+</a>
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
				<a href="#" onclick="decrementWeight(5);" class="btn btnsmall">-</a><input type="text" name="q5_weight" value="1" width="2"  onchange="changeValue(5);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(5);" class="btn btnsmall">+</a>
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
				<a href="#" onclick="decrementWeight(6);" class="btn btnsmall">-</a><input type="text" name="q6_weight" value="1" width="2"  onchange="changeValue(6);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(6);" class="btn btnsmall">+</a>
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
				<a href="#" onclick="decrementWeight(7);" class="btn btnsmall">-</a><input type="text" name="q7_weight" value="1" width="2"  onchange="changeValue(7);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(7);" class="btn btnsmall">+</a>
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
				<a href="#" onclick="decrementWeight(8);" class="btn btnsmall">-</a><input type="text" name="q8_weight" value="1" width="2"  onchange="changeValue(8);" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(8);" class="btn btnsmall">+</a>
			</td>
		</tr>
	</table>
	<br>
	<input type="submit" value="Compare!" class="pull-right" />
	</div>
	</form>
</div>
<script src="js/survey.js"></script>
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
	
var opinions = [
	["Strongly disagree", "Trifft gar nicht zu", "&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080;&#32;&#1085;&#1077;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1089;&#1077;&#1085;", "&#20840;&#12367;&#21516;&#24847;&#12391;&#12365;&#12394;&#12356;"],
	["Disagree", "Nicht &uuml;bereinstimmen", "&#1085;&#1077;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1072;&#1090;&#1100;&#1089;&#1103;", "&#21516;&#24847;&#12375;&#12394;&#12356;"],
	["No opinion", "Keine Meinung", "&#1053;&#1077;&#1090;&#32;&#1084;&#1085;&#1077;&#1085;&#1080;&#1103;", "&#24847;&#35211;&#12394;&#12375;"],
	["Agree", "Stimme zu", "&#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1072;&#1090;&#1100;&#1089;&#1103;", "&#21516;&#24847;&#12377;&#12427;"],
	["Strongly agree", "Stimme voll zu", "&#1055;&#1086;&#1083;&#1085;&#1086;&#1089;&#1090;&#1100;&#1102;&#32;&#1089;&#1086;&#1075;&#1083;&#1072;&#1089;&#1077;&#1085;", "&#24375;&#12367;&#21516;&#24847;&#12377;&#12427;"],
	["Importance", "Bedeutung", "&#1079;&#1085;&#1072;&#1095;&#1077;&#1085;&#1080;&#1077;", "&#37325;&#35201;&#24615;"],
];

var language = 0;

var weights = [];

// initialise weights
for(var i = 0; i < questions.length; i++)
	weights.push(1);
	

var freePoints = 0.0;
var maxPoints = questions.length;

// script entry point
start();
</script>

<?php include 'footer.php'; ?>
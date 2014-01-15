// Javascript does not allow for proper OOP.
// So we define a base 'class' with a number of methods
function TraditionalCompareClass() {
}

// scoreQuestion takes the answer to a question from person A (you, the user) and compares them to the 
// answer of personB (the candidate), then returns a fidelity score for this question. The answers
// also include weights, indicating how important this issue is to each person.
TraditionalCompareClass.prototype.scoreQuestion = function(answerA, weightA, answerB, weightB) {
	var score = 0;
	
	if(answerA == 0) // if person A (you, the user) doesn't care about this question
		score = 0; // neutral fidelity, regardless of person B's answer
	else if(answerA == answerB) // if both are exactly the same 
		score = 2;	// strong positive fidelity
	else if( (Math.max(answerA, answerB) == 2 && Math.min(answerA, answerB) == 1 ) || (Math.max(answerA, answerB) == -1 && Math.min(answerA, answerB) == -2 ) ) // if both have 'agree' and 'strongly agree', or both have 'disagree' and 'strongly disagree'
		score = 1; // weak positive fidelity
	else {
		var difference = Math.min(answerA, answerB) - Math.max(answerA, answerB); // get relative distance between answer A and B
		if(difference >= -2) // if the distance is -2 or less (0 or -1) -- examples: "disagree" vs "agree", "agree" vs "no opinion"
			score = -1; // weak negative fidelity
		else // if the distance is more than -2 (-3 or -4) -- examples: "agree" vs "strongly disagree", "strongly disagree" vs "no opinion"
			score = -2; // strong negative fidelity
	}
	
	var weight = this.getWeight(weightA, weightB, answerA, answerB);
	
	// return weighted score
	return (score * weight) * weightA;
}

// score questions according to the OKCupid method (more or less)
// http://www.okcupid.com/help/match-percentages
// userAnswer has to be a javascript array, even if it only contains one element
// weight is a numerical value
// candidateAnswer is a numerical value
TraditionalCompareClass.prototype.scoreQuestionOKC = function(userAnswerArray, weight, candidateAnswer) {
	// Test if our candidate's answer is acceptable to the user
	if(jQuery.inArray(candidateAnswer[0], userAnswerArray) != -1) {
		// if so, return the weight of this answer (which is the score)
		return weight;
	}
	
	// if the candidate's answer isn't acceptable, return score 0
	return 0;
}

// return the matching score of two weights
TraditionalCompareClass.prototype.getWeight = function(weightA, weightB, answerA, answerB) {
	// what do we consider to be the cutoff (inclusive) between important and not important:
	var important = 1;
	
	// the multipliers we return for fidelity increases and decreases
	var increase = 1.5;
	var decrease = 0.5;
	
	// if both people agree this is important (or of neutral importance)
	// increase their fidelity (tend away from 0)
	if(weightA >= important && weightB >= important)
		return increase;
		
	// if both people agree this is not important
	if(weightA < important && weightB < important) {
		// if they agree on their answer, increase their fidelity (tend away from 0)
		if( (answerA > 0 && answerB > 0) || (answerA < 0 && answerB < 0) )
			return increase;
		else // decrease their fidelity (tend towards 0)
			return decrease;
	}
	
	// if the people disagree on this question's importance
	// decrease their fidelity (tend towards 0)
	if( Math.max(weightA, weightB) >= important && Math.min(weightA, weightB) < important)
		return decrease;
}

// getMaxFidelityScore returns the maximum fidelty score
// obtainable in a perfect match
TraditionalCompareClass.prototype.getMaxFidelityScore = function(totalQuestions) {
	return this.scoreQuestion(2,1,2,1) * totalQuestions;
}

// getMinFidelityScore returns the lowest fidelty score
// obtainable in case of the worst possible match
TraditionalCompareClass.prototype.getMinFidelityScore = function(totalQuestions) {
	return this.scoreQuestion(2,1,-2,1) * totalQuestions;
}

// takes an integer number and returns a string
// format "qX" where X is the number
function getQuestionKey(intQuestion) {
	return "q" + (intQuestion);
}

// iterate over all relevant questions for one candidate
// and determine his/her fidelity score
// return structure:
//
// 	Object{ 
// 		"candidate": int, // refers to index in candidates array
// 		"q1" ... "qN": {"fidelity": int, "weight": int}, // one for each question in matchQuestions[]
//		"score": int
// 	}
function matchCandidate(user, comparer, candidateIndex) {
	var score = 0;
	var candidate = candidates[candidateIndex];
	var candidateScore = {classic_score:[], okc_score:[]};
	candidateScore["candidate"] = candidateIndex;
	
	/*for(var i = 0; i < matchQuestions.length; i++) {
		// first, get the answers and weights from our user and candidate
		var answerA = user.classic_answers[getQuestionKey(matchQuestions[i])]["answer"];
		var weightA = user.classic_answers[getQuestionKey(matchQuestions[i])]["weight"];
		var answerB = candidate.classic_answers[getQuestionKey(matchQuestions[i])]["answer"];
		var weightB = candidate.classic_answers[getQuestionKey(matchQuestions[i])]["weight"];
		
		// then calculate a fidelity score and add it to the tally
		var questionFidelity = comparer.scoreQuestion(answerA, weightA, answerB, weightB);
		score += questionFidelity;
		
		var questionScore = {fidelity:questionFidelity, weight:comparer.getWeight(weightA, weightB, answerA, answerB)};
		candidateScore.classic_score[getQuestionKey(matchQuestions[i])] = questionScore;
	}*/
	
	var okcScoreU = 0;
	var maxUserScore = 0;
	var okcScoreC = 0;
	var maxCandidateScore = 0;
	
	for(var i = 0; i < matchOKCQuestions.length; i++) {
		var key = getQuestionKey(okcQuestionIds[matchOKCQuestions[i]]);
		
		var userAnswer = [];
		var userWeight = 0;
		if(typeof user.okc_answers[key] != 'undefined') {
			userAnswer = user.okc_answers[key]["answer"];
			userWeight = user.okc_answers[key]["weight"];
		}
			
		var candidateAnswer = [];
		var candidateWeight = 0;
		if(typeof candidate.okc_answers[key] != 'undefined') {
			candidateAnswer = candidate.okc_answers[key]["answer"];
			candidateWeight = candidate.okc_answers[key]["weight"];
		}	
		
		// calculate okc score and add
		
		var questionScoreU = comparer.scoreQuestionOKC(userAnswer, userWeight, candidateAnswer);
		var questionScoreC = comparer.scoreQuestionOKC(userAnswer, candidateWeight, candidateAnswer);
		okcScoreU += questionScoreU;
		maxUserScore += userWeight;
			
		if(userWeight != 0) {
			okcScoreC += questionScoreC;
			maxCandidateScore += candidateWeight;
		}
				
		var result = {userScore:questionScoreU, maxUserScore:userWeight, candidateScore:questionScoreC, maxCandidateScore:candidateWeight};
		candidateScore.okc_score[key] = result;
	}
	
	candidateScore["maxOkcScore"] = maxUserScore;
	
	var scoreOKC = 0;
	// make OKC match percentage
	if(maxUserScore != 0 && maxCandidateScore != 0)
		scoreOKC = Math.sqrt( (okcScoreU / maxUserScore) * (okcScoreC / maxCandidateScore) );
	
	scoreOKC = scoreOKC * 100;
	
	// turn classic question score into match percentage
	//score = getPercentage(score, getComparer().getMinFidelityScore(matchQuestions.length), getComparer().getMaxFidelityScore(matchQuestions.length));
	score = scoreOKC
	
	candidateScore["score"] = score;
	candidateScore["scoreOKC"] = scoreOKC;
	
	//var perc_classic_q = (matchQuestions.length / (matchQuestions.length + matchOKCQuestions.length));
	//var perc_okc_q = (matchOKCQuestions.length / (matchQuestions.length + matchOKCQuestions.length));
	//candidateScore["combinedScore"] = (score * perc_classic_q) + (scoreOKC * perc_okc_q);
	candidateScore["combinedScore"] = scoreOKC;
	
	//alert(candidate.name + " classic: " + score + ", okc: " + scoreOKC + ", combined: " + candidateScore["combinedScore"]);
	
	return candidateScore;
}

var theComparer = null;

function getComparer() {
	if(theComparer == null)
		theComparer = new TraditionalCompareClass();
		
	return theComparer;
}

// iterate over all relevant candidates and questions 
// to determine their fidelity score
function makeMatches() {
	var mycomparer = getComparer();
	
	var allMatches = [];
	// for each value in the matchCandidates array...
	for(var i = 0; i < matchCandidates.length; i++) {
		// match this candidate to the user
		var match = matchCandidate(matchUser, mycomparer, matchCandidates[i]);

		allMatches.push(match);
	}
	
	allMatches.sort(sortCandidateArray);
	
	return allMatches;
}

// we store matches that we've made here, for cases where we need to redraw the table, 
// but not need to recalculate matches
var madeMatches;

// sort function, people with a higher score will be sorted ahead of those with a lower score
function sortCandidateArray(a,b) {
	// sort 0 score candidates randomly
	// this makes simply loading compare.php fairer since candidates are shuffled randomly
	if(b["combinedScore"] == 0 && a["combinedScore"] == 0) {
		var rand = Math.random();

		rand = rand * 2;
		rand = rand - 1;

		return Math.round(rand);
	}
	
	return (b["combinedScore"] - a["combinedScore"]);
}

//===========================================
// Computational functions end here
// Next are presentational functions
//===========================================
function printResults(matches) {
	var html = "";
	
	html = html + makeTableHeader(matches);
	
	for(var i = 0; i < matchQuestions.length; i++) {
		html = html + makeRow(matches, i);
	}
	
	// do we have an offset to determine even/uneven rows?
	evenOffset = matchQuestions.length % 2;
	for(var i = 0; i < matchOKCQuestions.length; i++) {
		html = html + makeOKCRow(matches, i, evenOffset);
	}
	
	html = html + makeTableFooter(matches);
		
	$("#contentholder").html(html);
	$("#showexcess").html("Show all candidates &raquo;");
	
	window.setTimeout(refreshComments,50);
}

function refreshComments() {
	Opentip.findElements();
}

function makeRow(matches, row) {
	
	var html = "<tr class=\"" + getEvenRow(row) + "\">";
	var tclass = "";
	var question = matchQuestions[row];
	
	html = html + makeQuestion(row, language, false);
	
	for(var i = 0; i < matches.length; i++) {
		tclass = getClass(i);
		
		background = getBackground( ((matches[i]).classic_score[getQuestionKey(question)])["fidelity"], ((candidates[(matches[i])["candidate"]]).classic_answers[getQuestionKey(question)])["comment"] );
		
		html = html + "<td class=\"answer " + tclass + " " + background + "\">" + getCellContents( ((candidates[(matches[i])["candidate"]]).classic_answers[getQuestionKey(question)])["answer"], ((candidates[(matches[i])["candidate"]]).classic_answers[getQuestionKey(question)])["weight"], ((candidates[(matches[i])["candidate"]]).classic_answers[getQuestionKey(question)])["comment"], (candidates[(matches[i])["candidate"]])["name"]  ) + "</td>";
	}
	
	html = html + "</tr>";
	
	return html;
}

function makeOKCRow(matches, row, offset) {
	var html = "<tr class=\"" + getEvenRow(row + offset) + "\">";
	var tclass = "";
	var question = okcQuestionIds[matchOKCQuestions[row]];
	
	html = html + makeQuestion(row, language, true);
	
	for(var i = 0; i < matches.length; i++) {
		tclass = getClass(i);
		
		var thecomment = "";
		if(typeof (candidates[(matches[i])["candidate"]]).okc_answers[getQuestionKey(question)] != 'undefined')
			thecomment = (candidates[(matches[i])["candidate"]]).okc_answers[getQuestionKey(question)]["comment"];
		
		background = getBackgroundOKC( (matches[i]).okc_score[getQuestionKey(question)].userScore, (matches[i]).okc_score[getQuestionKey(question)].maxUserScore , (matches[i]).okc_score[getQuestionKey(question)].candidateScore , (matches[i]).okc_score[getQuestionKey(question)].maxCandidateScore, thecomment );
		var theanswer = [];
		
		if(typeof (candidates[(matches[i])["candidate"]]).okc_answers[getQuestionKey(question)] != 'undefined')
			theanswer = (candidates[(matches[i])["candidate"]]).okc_answers[getQuestionKey(question)]["answer"][0];
			
		html = html + "<td class=\"answer " + tclass + " " + background + "\">" + getOKCCellContents( question, theanswer, (matches[i]), (matches[i])["candidate"]) + "</td>";
	}
	
	html = html + "</tr>";
	
	return html;
}

function makeQuestion(qIndex, lIndex, isOKC) {
	var html = "<td class=\"question\">";
	
	if(isOKC) {
		html = html + "<label><input type=\"checkbox\" value=\"" + matchOKCQuestions[qIndex] + "\" name=\"okc\" /> ";
		html = html + okc_questions[matchOKCQuestions[qIndex]].question[lIndex] + "</label></td>";
	} else {
		html = html + "<input type=\"checkbox\" value=\"" + matchQuestions[qIndex] + "\" name=\"q\" /> ";
		html = html + questions[matchQuestions[qIndex]][lIndex] + "</td>";
	}
	return html;
}

function makeTableHeader(matches) {
	var html = "";
	var tclass = "";
	
	html = "<table><tr class=\"header\"><th>";
	html = html + "<div class=\"flags span2\"><img src=\"img/gb.png\" onclick=\"changeLanguage(0);\"/> <img src=\"img/de.png\" onclick=\"changeLanguage(1);\"/> <img src=\"img/ru.png\" onclick=\"changeLanguage(2);\"/> <img src=\"img/it.png\" onclick=\"changeLanguage(3);\"/></div>";
	html = html + "</th>";
	
	for(var i = 0; i < matches.length; i++) {
		tclass = getClass(i);
		html = html + "<th class=\"answer " + tclass + "\">";
		html = html + "<div class=\"check\"><input type=\"checkbox\" value=\"" + (matches[i])["candidate"] + "\" name=\"c\" /></div>";
		html = html + "<img src=\"https://image.eveonline.com/Character/" + (candidates[(matches[i])["candidate"]])["cid"] + "_64.jpg\" class=\"rounded\" /><br><a href=\"candidate.php?cid=" + (candidates[(matches[i])["candidate"]])["cid"] +"\">" + (candidates[(matches[i])["candidate"]])["name"] + " (" + Math.round((matches[i])["combinedScore"]) + "% match)</a>";
		html = html + "</th>";
	}
	
	html = html + "</tr>";
	
	return html;
}

function getPercentage(score, min, max) { 
	var scale = max - min; 
	
	score = score + Math.abs(min);
	
	return Math.min( (score / scale) * 100, 100);
}

function getClass(column) {
	var c = "";
		
	if(column > 8)
			c = "excess";
			
	if(column % 2 == 0)
			c = c + " even";
	else
		c = c + " uneven";
		
	return c;
}

function getBackground(fidelity, comment) {
	var html = "";
	
	if(fidelity <= -2)
		html = "verybad";
	else if(fidelity < 0)
		html = "bad";
	else if(fidelity == 0)
		html = "neutral";
	else if(fidelity >= 2)
		html = "verygood";
	else if(fidelity > 0)
		html = "good";
		
	if(comment != "")
		html += " comment";
		
	return html;
}

function getBackgroundOKC(userScore, maxUserScore, candidateScore, maxCandidateScore, comment) {

	var html = "";
	
	if(comment != "")
		html = "comment ";
	
	if(maxUserScore == 0)
		return html + "neutral";
	
	var score = Math.sqrt(maxUserScore * maxCandidateScore);
	
	// negative match
	if(userScore == 0) {
		if(score > 8.0)
			return html + "verybad";
		else
			return html + "bad";
	} else { // positive match	
		if(score > 8.0)
			return html + "verygood";
		else
			return html + "good";
	}
}

function getCellContents(vote, weight, comment, name) {
	var html = "";
	
	if(comment != "")
		html += '<div data-ot="' + comment + '" data-ot-title="' + name + '" data-ot-containInViewport="true" data-ot-tip-joint="bottom left" data-ot-fixed="true" data-ot-target="true" data-ot-close-button-radius="11" data-ot-close-button-cross-size="10" data-ot-close-button-cross-line-width="3" >';
		
	switch(vote) {
		case -2:
			html += '<img src="img/doublethumbsdown.png" title="Strongly disagree" />';
			break;
		case -1:
			html += '<img src="img/thumbsdown.png" title="Disagree" />';
			break;
		case 0:
			html += '<img src="img/noopinion.png" title="No opinion" />';
			break;
		case 1:
			html += '<img src="img/thumbsup.png" title="Agree" />';
			break;
		case 2:
			html += '<img src="img/doublethumbsup.png"  title="Strongly agree"/>';
			break;
	}
	
	if(weight > 1)
		html = html + '<img src="img/comment.png" title="" />';
		
	html = html + '</div>';
		
	return html;
}

function getOKCCellContents(questionId, optionId, match, c_index) {
	//return optionId + " " + match.okc_score[getQuestionKey(questionId)].maxUserScore + " " + match.okc_score[getQuestionKey(questionId)].userScore+ " " + match.okc_score[getQuestionKey(questionId)].maxCandidateScore + " " + match.okc_score[getQuestionKey(questionId)].candidateScore;
	
	var html = "";
	var comment = "";
	
	if(typeof candidates[c_index].okc_answers[getQuestionKey(questionId)] != 'undefined')
		comment = candidates[c_index].okc_answers[getQuestionKey(questionId)]["comment"];
		
	var name = candidates[c_index].name;
	var answer = "Not answered";
	if(typeof candidates[c_index].okc_answers[getQuestionKey(questionId)] != 'undefined') {
		//var answerid = candidates[c_index].okc_answers[getQuestionKey(questionId)]["answer"];
		
		answer = getOptionString(questionId, optionId);
	}
		
	var importance = "Irrelevant";
	if(typeof candidates[c_index].okc_answers[getQuestionKey(questionId)] != 'undefined')
		importance = importanceString(candidates[c_index].okc_answers[getQuestionKey(questionId)]["weight"]);
		
	var fullcomment = '<b>Answer: </b>' + answer + '</br></br><b>Importance: </b>' + importance;
	
	if(comment != "")
		fullcomment += '</br></br><b>Comment: </b>' + comment;
	

	html += '<div data-ot="' + fullcomment + '" data-ot-title="' + name + '" data-ot-containInViewport="true" data-ot-tip-joint="bottom left" data-ot-fixed="true" data-ot-target="true" data-ot-close-button-radius="11" data-ot-close-button-cross-size="10" data-ot-close-button-cross-line-width="3" >';
	html += getImageForWeight(importance);	
	html += '</div>';
		
	return html;
}

function getImageForWeight(weight) {
	switch(weight) {
		case "A little important":
			return '<img src="img/littleimp.png" title="A little important" />';
		case "Somewhat important":
			return '<img src="img/somewhatimp.png" title="Somewhat important" />';
		case "Very important":
			return '<img src="img/veryimp.png" title="Very important" />';
		case "Mandatory":
			return '<img src="img/mandatory.png" title="Mandatory" />';
	}

	return '<img src="img/irrelevant.png" title="Irrelevant" />'; 
}

function getOptionString(questionId, optionId) {

	for(var i = 0; i < okc_questions.length; i++) {
		if(okc_questions[i].id == questionId) {
			var options = okc_questions[i].options;
			for(var j = 0; j < options.length; j++) {
				if(options[j].id == optionId)
					return options[j].strings[0];
			}
		}
	}
	
	return "";
}

function importanceString(value) {
	switch(value) {
		case 0:
			return "Irrelevant";
			break;
		case 1: 
			return "A little important";
			break;
		case 5: 
			return "Somewhat important";
			break;
		case 10: 
			return "Very important";
			break;
		case 50:
			return "Mandatory";
			break;
	}
	
	return "Irrelevant";
}

function getEvenRow(row) {
	var e = "uneven qrow";
	
	if(row % 2 == 0)
		e = "even qrow";
		
	return e;
}

function makeTableFooter() {
	return "</table>";
}

//=============================================
// Presentational functions end here
// Next are scripts for page behaviour
//=============================================

function toggleCandidates() {
	if($(".excess").is(':hidden')) {
		$(".excess").show(1000);
		$("#showexcess").html("&laquo; Hide candidates");
	} else {
		$(".excess").hide(1000);
		$("#showexcess").html("Show all candidates &raquo;");
	}
}

function changeLanguage(lang) {
	language = lang;
	printResults(madeMatches);
}

function toggleButtonPanel(panel) {
	var show = "";
	var hide = "";
	
	if(panel == "questionbuttons") {
		show = "questionbuttons";
		hide = "candidatebuttons";
	} else {
		show = "candidatebuttons";
		hide = "questionbuttons";
	}
	
	if($("."+show).is(':hidden')) {
		if($("."+hide).is(':visible'))
			$("."+hide).hide();
			
		$("."+show).show(500);
	} else {
		$("."+show).hide(500);
	}
}

//===============================================
// Next are the functions dealing with checking
// and unchecking questions and candidates
//===============================================
function resetMatchQuestions() {
	for(var i = 0; i < questions.length; i++)
		matchQuestions[i] = i;
}

function resetOkcQuestions() {
	for(var i = 0; i < okc_questions.length; i++)
		matchOKCQuestions[i] = i;
}

function resetQuestions() {
	resetMatchQuestions();
	resetOkcQuestions();
		
	printNewGrid();
}

function resetMatchCandidates() {
	// not 0 based, since 0 is the user
	for(var i = 1; i < candidates.length; i++)
		matchCandidates[i-1] = i;
}

function resetCandidates() {
	resetMatchCandidates();
		
	// since we exclude the user
	$('#showuser').html("Show my answers");
		
	printNewGrid();
}

function includeCandidates() {
	matchCandidates = [];
	
	$('input').each(function(index, element){
		if(element.checked && element.name == "c") {
			matchCandidates.push(parseInt(element.value));
		}
	});
	
	// recalculate and draw
	printNewGrid();
}

function excludeCandidates() {
	var newCandidates = [];
	var excluding = [];
	
	// add all checked candidates to exclude list
	$('input').each(function(index, element){
		if(element.checked && element.name == "c") {
			excluding.push(parseInt(element.value));
		}
	});
	
	// build match list of all candidates not in the exclude list
	for(var i = 0; i < matchCandidates.length; i++) {
		if(jQuery.inArray(matchCandidates[i], excluding) == -1)
			newCandidates.push(matchCandidates[i]);
	}
	
	matchCandidates = newCandidates;
	
	// recalculate and draw
	printNewGrid();
}

function compareCandidatesWith() {
	var candidate = null;
	var bMultiple = false;
	
	$('input').each(function(index, element){
		if(element.checked && element.name == "c") {
			if(candidate != null)
				bMultiple = true;
				
			candidate = (parseInt(element.value));
		}
	});
	
	if(bMultiple)
		alert("Notify: you had selected multiple candidates. Candidates will be compared to " + (candidates[candidate])["name"] + ".");
		
	if(candidate != null)
		matchUser = candidates[candidate]
	else
		alert("No candidate selected.");
		
	// recalculate and draw
	printNewGrid();
}

function includeQuestions() {
	matchQuestions = [];
	
	$('input').each(function(index, element){
		if(element.checked && element.name == "q") {
			matchQuestions.push(parseInt(element.value));
		}
	});
	
	matchOKCQuestions = [];
	
	$('input').each(function(index, element){
		if(element.checked && element.name == "okc") {
			matchOKCQuestions.push(parseInt(element.value));
		}
	});
	
	// recalculate and draw
	printNewGrid();
}

function excludeQuestions() {
	var excluding = [];
	var newQuestions = [];
	var excluding_okc = [];
	var newQuestions_okc = [];
	
	// add all checked questions to exclude list
	$('input').each(function(index, element){
		if(element.checked && element.name == "q") {
			excluding.push(parseInt(element.value));
		}
		
		if(element.checked && element.name == "okc") {
			excluding_okc.push(parseInt(element.value));
		}
	});
	
	// build match list of all questions not in the exclude list
	for(var i = 0; i < matchQuestions.length; i++) {
		if(jQuery.inArray(matchQuestions[i], excluding) == -1)
			newQuestions.push(matchQuestions[i]);
	}
	
	matchQuestions = newQuestions;
		
	// build match list of all okc questions not in the exclude list
	for(var i = 0; i < matchOKCQuestions.length; i++) {
		if(jQuery.inArray(matchOKCQuestions[i], excluding_okc) == -1)
			newQuestions_okc.push(matchOKCQuestions[i]);
	}
	
	matchOKCQuestions = newQuestions_okc;
	
	// recalculate and draw
	printNewGrid();
}

function toggleUser() {
	// if the matchCandidates array contains a 0
	if(jQuery.inArray(0, matchCandidates) != -1) {
		$('#showuser').html("Show my answers");
		
		var newArray = [];
		
		// make a new array with all elements except 0
		for(var i = 0; i < matchCandidates.length; i++) {
			if(matchCandidates[i] != 0)
				newArray.push(matchCandidates[i]);
		}
		
		matchCandidates = newArray;
	} else {
		$('#showuser').html("Hide my answers");
		matchCandidates.push(0);
	}
	
	printNewGrid();
}

// Entry point of our script!
resetMatchQuestions();
resetOkcQuestions();
resetMatchCandidates();
printNewGrid();

function printNewGrid() {
	madeMatches = makeMatches();
	printResults(madeMatches);
}

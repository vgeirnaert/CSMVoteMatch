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
		score = 0; // neutral fidelity
	else if(answerA == answerB) // if both are exactly the same 
		score = 2;	// strong positive fidelity
	else if( ((answerA == 1 || answerA == 2) && (answerB == 1 || answerB == 2)) || ((answerA == -1 || answerA == -2) && (answerB == -1 || answerB == -2)) ) // if both have 'agree' and 'strongly agree', or both have 'disagree' and 'strongly disagree'
		score = 1; // weak positive fidelity
	else {
		var difference = Math.min(answerA, answerB) - Math.max(answerA, answerB); // get relative distance between answer A and B
		if(difference >= -2) // if the distance is -2 or less (0 or -1)
			score = -1; // weak negative fidelity
		else // if the distance is more than -2 (-3 or -4)
			score = -2; // strong negative fidelity
	}
	
	var weight = this.getWeight(weightA, weightB);
	
	// return weighted score
	return (score * weight);
}

// return the combined weight of two weights
TraditionalCompareClass.prototype.getWeight = function(weightA, weightB) {
	// set the weight as average of both weights
	return (weightA + weightB) / 2;
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

// transform question array position integer to key string for question answer
function getAnswerKey(intQuestion) {
	return getQuestionKey(intQuestion) + "_answer";
}

// transform question array position integer to key string for question weight
function getWeightKey(intQuestion) {
	return getQuestionKey(intQuestion) + "_weight";
}

function getScoreKey(intQuestion) {
	return getQuestionKey(intQuestion) + "_score";
}

function getQuestionKey(intQuestion) {
	return "q" + (intQuestion + 1);
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
function matchCandidate(user, candidate, comparer, index) {
	var score = 0;
	
	var candidateScore = [];
	candidateScore["candidate"] = index;
	
	for(var i = 0; i < matchQuestions.length; i++) {
		// first, get the answers and weights from our user and candidate
		var answerA = user[getAnswerKey(matchQuestions[i])];
		var weightA = user[getWeightKey(matchQuestions[i])];
		var answerB = candidate[getAnswerKey(matchQuestions[i])];
		var weightB = candidate[getWeightKey(matchQuestions[i])];
		
		// then calculate a fidelity score and add it to the tally
		var questionFidelity = comparer.scoreQuestion(answerA, weightA, answerB, weightB);
		score += questionFidelity;
		
		var questionScore = {fidelity:questionFidelity, weight:comparer.getWeight(weightA, weightB)};
		candidateScore[getQuestionKey(matchQuestions[i])] = questionScore;
	}
	candidateScore["score"] = score;
	
	return candidateScore;
}

// iterate over all relevant candidates and questions 
// to determine their fidelity score
function makeMatches() {
	var comparer = new TraditionalCompareClass();
	
	var allMatches = [];
	// for each value in the matchCandidates array...
	for(var i = 0; i < matchCandidates.length; i++) {
		// match this candidate to the user
		var match = matchCandidate(matchUser, candidates[matchCandidates[i]], comparer, matchCandidates[i]);
		allMatches.push(match);
	}
	
	allMatches.sort(sortCandidateArray);
	
	return allMatches;
}

// sort function, people with a higher score will be sorted ahead of those with a lower score
function sortCandidateArray(a,b) {
	return (b["score"] - a["score"]);
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
	
	html = html + makeTableFooter(matches);
		
	$("#contentholder").html(html);
}

function makeRow(matches, row) {
	
	var html = "<tr class=\"" + getEvenRow(row) + "\">";
	var style = "";
	var tclass = "";
	
	html = html + makeQuestion(row, language);
	
	for(var i = 0; i < matches.length; i++) {
		style = getStyle(i);
		tclass = getClass(i);
		html = html + "<td class=\"answer " + tclass + "\" " + style + ">" + ((matches[i])[getQuestionKey(matchQuestions[row])])["fidelity"] + "</td>";
	}
	
	html = html + "</tr>";
	
	return html;
}

function makeQuestion(qIndex, lIndex) {
	return "<td class=\"question\">" + questions[matchQuestions[qIndex]][lIndex] + "</td>";
}

function makeTableHeader(matches) {
	var html = "";
	var style = "";
	var tclass = "";
	
	html = "<table><tr class=\"header\"><th></th>";
	
	for(var i = 0; i < matches.length; i++) {
		style = getStyle(i);
		tclass = getClass(i);
		html = html + "<th class=\"answer " + tclass + "\" " + style + " onmouseover=\"toggleCheckbox();\">";
		html = html + "<div class=\"check\"><input type=\"checkbox\" /></div>";
		html = html + "<a href=\"candidate.php?cid=" + (candidates[(matches[i])["candidate"]])["cid"] +"\"><img src=\"https://image.eveonline.com/Character/" + (candidates[(matches[i])["candidate"]])["cid"] + "_64.jpg\" class=\"rounded\" /><br>" + (candidates[(matches[i])["candidate"]])["name"] + " (" + (matches[i])["score"] + ")</a>";

		html = html + "</th>";
	}
	
	html = html + "</tr>";
	
	return html;
}

function getStyle(column) {
	var style = "";
		
	if(column > 8)
			style = "style=\"display:none;\"";
			
	return style;
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

function toggleCheckbox() {
	if($(".check").is(':hidden'))
		$(".check").show(300);
	else
		$(".check").hide(300);
}

// Entry point of our script!
printResults(makeMatches());

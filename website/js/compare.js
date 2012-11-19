// Javascript does not allow for proper OOP.
// So we define a base 'class' that has two methods 
// that always throw an exception unless overriden.
function CompareClassBase() {
}

// getMaxFidelityScore should return the maximum fidelty score
// obtainable in a perfect match
CompareClassBase.prototype.getMaxFidelityScore = function(totalQuestions) {
	throw 'You must implement this method';
}

// getMinFidelityScore should return the lowest fidelty score
// obtainable in case of the worst possible match
CompareClassBase.prototype.getMinFidelityScore = function(totalQuestions) {
	throw 'You must implement this method';
}

// scoreQuestion takes the answer to a question from person A and compares them to the 
// answer of personB, then returns a fidelity score for this question. The answers
// also include weights, indicating how important this issue is to each person.
CompareClassBase.prototype.scoreQuestion = function(answerA, weightA, answerB, weightB) {
	throw 'You must implement this method';
}

var object = new CompareClassBase;

// Traditional vote match compare object
object.getMaxFidelityScore = function(totalQuestions) {
	return 100;
}

object.getMinFidelityScore = function(totalQuestions) {
	return -100;
}

object.scoreQuestion = function(answerA, weightA, answerB, weightB) {
	var score = 0;
	
	if(answerA == 0) // if person A doesn't care about this question
		score = 0; // neutral fidelity
	else if(answerA == answerB) // if both are exactly the same 
		score = 2;	// strong positive fidelity
	else if( (answerA == 1 || answerA == 2) && (answerB == 1 || answerB == 2) || (answerA == -1 || answerA == -2) && (answerB == -1 || answerB == -2) ) // if both have 'agree' or 'strongly agree', or both have 'disagree' or 'strongly disagree'
		score = 1; // weak positive fidelity
	else {
		var difference = Math.min(answerA, answerB) - Math.max(answerA, answerB); // get relative distance between answer A and B
		if(difference <= -2) // if the distance is -2 or less (0 or -1)
			score = -1; // weak negative fidelity
		else // if the distance is more than -2 (-3 or -4)
			score = -2; // strong negative fidelity
	}
	
	// set the weight as average of both weights
	var weight = (weightA + weightB) / 2;
	
	// return weighted score
	return (score * weight);
}



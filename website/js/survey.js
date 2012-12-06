function changeLanguage(lang) {
	language = lang;
	
	changeDisplayLanguage();
}

function changeDisplayLanguage() {
	$('.question').each(function(index, element){
		element.innerHTML = (questions[index])[language];
	});
	
	$('th.answer').each(function(index, element){
		element.innerHTML = (opinions[index])[language];
	});
	
	$('#explanation').html(explanations[language]);
}

function changeWeightValue(index, change) {
	if(change <= freePoints) {
		if(weights[index] + change >= 0) {
			// multiple and devide by 10 to round to one decimal point
			weights[index] = round1S(weights[index] + change);
			freePoints = round1S(freePoints - change);
		}
	}
}

function updateCounters() {
	for(var i = 0; i < weights.length; i++) {
		updateCounter(i);
	}
	
	changeCounter();
}

function updateCounter(index) {
	var element = $('input[name="q' + index + '_weight"]');
	element.val(weights[index]);
}

function incrementWeight(index) {
	changeWeightValue(index, 0.1);
	updateCounter(index);
	changeCounter();
}

function decrementWeight(index) {
	changeWeightValue(index, -0.1);
	updateCounter(index);
	changeCounter();
}

function changeAllValues(amount) {
	for(var i = 0; i < weights.length; i++) {
		changeWeightValue(i, amount);
	}
	
	updateCounters();
}

function changeCounter() {
	$('#counter').html(freePoints.toFixed(1) + " of " + weights.length);
}

function changeValue(index) {
	var newvalue = parseFloat($('input[name="q' + index + '_weight"]').val());
	newvalue = round1S(newvalue);
	
	difference = round1S(newvalue - weights[index]);
	
	changeWeightValue(index, difference);
	updateCounter(index);
	changeCounter();
	
}

function round1S(number) {
	return (Math.round(number * 10) / 10);
}


function start() {
	$('.noEnterSubmit').keypress(function(e){
		if ( e.which == 13 )
			return false;
	});
	changeCounter();
	changeDisplayLanguage();
}

function validateForm() {
	if(freePoints == 0)
		return true;
	
	alert('You must allocate all your importance points! You currently have ' + freePoints.toFixed(1) + ' left.');
	return false;
}
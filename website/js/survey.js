function changeLanguage(lang) {
	language = lang;
	
	changeDisplayLanguage();
}

function changeDisplayLanguage() {
	// change classic style statements
	$('.question').each(function(index, element){
		element.innerHTML = (questions[index])[language];
	});
	
	// change table headers for classic style statements
	$('th.answer').each(function(index, element){
		element.innerHTML = (opinions[index])[language];
	});
	
	// change page explanation
	$('#explanation').html(explanations[language]);
	
	// reset carousel
	//$("#carousel").trigger("slideTo", [0, {duration: 0}]);
	$("#carousel").trigger("slideToPage", [0, {duration: 0}]);
	
	// change OKC style questions
	$('.okcquestion').each(function(index, element){
		element.innerHTML = ((okc_questions[index])["question"])[language];
	});
	
	for(var i = 0; i < okc_questions.length; i++) {
		$('.option_' + i).each(function(index, element){
			element.innerHTML = (((okc_questions[i])["options"])[index]).strings[language];
		});
	}
	
	$('.okc_imp').each(function(index, element){
		element.innerHTML = okc_imp_translations[language];
	});
	
	$('.okc_ans').each(function(index, element){
		element.innerHTML = okc_ans_translations[language];
	});
	
	$('.okc_imp_ni').each(function(index, element){
		element.innerHTML = okc_imp_ni_translations[language];
	});
	
	$('.okc_imp_li').each(function(index, element){
		element.innerHTML = okc_imp_li_translations[language];
	});
	
	$('.okc_imp_si').each(function(index, element){
		element.innerHTML = okc_imp_si_translations[language];
	});
	
	$('.okc_imp_vi').each(function(index, element){
		element.innerHTML = okc_imp_vi_translations[language];
	});
	
	$('.okc_imp_ma').each(function(index, element){
		element.innerHTML = okc_imp_ma_translations[language];
	});
	
	// TODO: change calculate match button text
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
	if(freePoints != 0) {
		alert('You must allocate all your importance points! You currently have ' + freePoints.toFixed(1) + ' left.');
		return false;
	}	
	
	// TODO: add checks that all okc questions are filled in 
	
	
	return true;
}

function onImportanceChanged(name, element, bNoBrackets) {
	var radioname = "ans_" + name + "[]";
	
	if(bNoBrackets)
		radioname = "ans_" + name;
		
	if(element.value == "ni") {
		$('[name="' + radioname + '"]').prop('disabled', true);
		$('[name="okc_c' + name + '"]').prop('disabled', true);
	} else {
		$('[name="' + radioname + '"]').prop('disabled', false);
		$('[name="okc_c' + name + '"]').prop('disabled', false);
		
		var selected = $('[name="' + radioname + '"]:checked');
		
		if(selected.length == 0) {
			alert('Please select an answer before setting it\'s importance');
			element.selectedIndex = 0;
		}
	}
}
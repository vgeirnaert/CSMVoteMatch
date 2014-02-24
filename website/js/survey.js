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
	changeDisplayLanguage();
}

function validateForm() {
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
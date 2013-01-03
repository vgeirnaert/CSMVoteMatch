<?php 
require_once 'database.php';

class Questions {
	private static $number_of_questions = NULL;
	private static $question_string = NULL;
	private static $okc_question_string = NULL;
	private static $okc_html_string = NULL;

	static function getClassicQuestionsArray() {	
		return self::$question_string;
	}

	static function initClassicQuestions() {		
		$mysqli = VotematchDB::getConnection();

		if (mysqli_connect_errno()) {
			echo '<p><h2>Error connecting to database:</h2>' . mysqli_connect_error() . '</p>';
		} else {
			$stmt = $mysqli->prepare("SELECT id, question_en, question_rus, question_ger, question_jp FROM classic_questions AS q WHERE q.election_id = ? ORDER BY q.id ASC");
			$election = Config::active_election;
			$stmt->bind_param("i", $election);
			$stmt->execute();

			$stmt->bind_result($id, $en, $rus, $ger, $jp);

			self::$question_string = 'var questions = [';

			$comma = "";
			$num_questions = 0;
			while($stmt->fetch()) {
				self::$question_string = self::$question_string . "$comma [\"$en\", \"$ger\", \"$rus\", \"$jp\"]";
				$comma = ",\n";
				$num_questions++;
			}
			
			self::$number_of_questions = $num_questions;

			self::$question_string = self::$question_string . '];';

			$stmt->close();
		}
	}
	
	static function getNumClassicQuestions() {
		return self::$number_of_questions;
	}
	
	static function printClassicQuestionTable() {
		for($i = 0; $i < Questions::getNumClassicQuestions(); $i++) {
			$even = $i % 2;
			
			$tr_class = "qrow ";
			
			if($even)
				$tr_class = $tr_class . "even";
			else
				$tr_class = $tr_class . "uneven";
			
			echo '<tr class="' . $tr_class . '"><td class="question"></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="SD" /></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="D" /></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="NO" checked /></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="A" /></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="SA" /></td>' .
			 '<td class="answer"><a href="#" onclick="decrementWeight(' . $i . '); return false;" class="btn btnsmall">-</a><input type="text" name="q' . $i . '_weight" value="1" width="2" onchange="changeValue(' . $i . ');" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(' . $i . '); return false;" class="btn btnsmall">+</a></td></tr>';
		}
	}
	
	static function printOKCQuestions() {
		
	}
	
	static function initOKCQuestions() {
		$mysqli = VotematchDB::getConnection();
		
		if (mysqli_connect_errno()) {
			echo '<p><h2>Error connecting to database:</h2>' . mysqli_connect_error() . '</p>';
		} else {
			$stmt = $mysqli->prepare("SELECT q.id, q.question_en, q.question_rus, q.question_ger, q.question_jp, o.option_en, o.option_rus, o.option_ger, o.option_jp, o.question_id, o.id FROM okc_questions AS q LEFT JOIN okc_options AS o ON o.question_id = q.id WHERE q.election_id = ? ORDER BY q.id ASC");
			$election = Config::active_election;
			$stmt->bind_param("i", $election);
			$stmt->execute();

			$stmt->bind_result($id, $q_en, $q_rus, $q_ger, $q_jp, $o_en, $o_rus, $o_ger, $o_jp, $qid, $optionid);
			
			$okc_js_array = "[";
			$okc_html = "";
			
			$current_id = "-1";
			$count = -1;
			while($stmt->fetch()) {
				if($current_id != $qid)
					$count++;
					
				$okc_js_array .= self::addToJsArray($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp);
				$okc_html .= self::addToHtml($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp, $count, $optionid);
				$current_id = $qid;
			}
			
			// we're finished, add closing brackets for last object and final array closing bracket
			$okc_js_array .= " ]\n\t}\n];";
			$okc_html .= self::completeHtmlDiv($qid);
		
			self::$okc_question_string = $okc_js_array;
			self::$okc_html_string = $okc_html;
		}
		
		VotematchDB::close();
	}
	
	static function addToJsArray($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp) {
		$okc_js_array = "";
		
		// check if we're looking at options belonging to the same question that we worked on previous iteration
		if($current_id != $qid) {
			// if it is a new question so, check if this isn't the first ever object in the array, and add closing brackets for last array item
			if($current_id != -1)
				$okc_js_array .=  " ]\n\t },";
				
			// since this is a new question, add a new question object
			$okc_js_array .= "\n\t" . '{"question":["' . $q_en . '", "' . $q_ger . '", "' . $q_rus . '", "' . $q_jp . '"],' . "\n\t" . '"options":[';
			
		} else
			$okc_js_array .= ", "; // it's not a new question, just append a comma to seperate option arrays
		
		// append this iteration's option values
		$okc_js_array .= "\n\t\t" . '["' . $o_en . '", "' . $o_ger . '", "' . $o_rus . '", "' . $o_jp . '"]' ;
		
		return $okc_js_array;
	}
	
	static function addToHtml($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp, $i, $optionid) {
		$html = "";
		if($current_id != $qid) {
			// complete previous div unless this is the very first div in the series
			if($current_id != -1) {
				$html .= self::completeHtmlDiv($current_id);
			}
			$html .= "<div class=\"okcdiv\"><h3 class=\"okcquestion\">$q_en</h3><span class=\"okc_ans\">Answers I will accept from a candidate:</span><br>";
		}
		$html .= '<input type="checkbox" name="ans_' . $qid .'[]" value="' . $optionid . '" /> <span class="option_' . $i . '">' . $o_en . '</span><br>';
		
		return $html;
	}
	
	static function completeHtmlDiv($question) {
		$html = "<br><span class=\"okc_imp\">How important is this issue to you?</span><br>
				<select name=\"imp_$question\">
					<option class=\"okc_imp_ni\" value=\"ni\">Not important at all</option>
					<option class=\"okc_imp_li\" value=\"li\">A little important</option>
					<option class=\"okc_imp_si\" value=\"si\">Somewhat important</option>
					<option class=\"okc_imp_vi\" value=\"vi\">Very important</option>
					<option class=\"okc_imp_ma\" value=\"ma\">Mandatory</option>
				</select></div>";
				
		return $html;
	}
	
	static function getOKCQuestionsArray() {
		return "var okc_questions = " . self::$okc_question_string;
	}
	
	static function getOKCHTML() {
		return self::$okc_html_string;
	}
}
?>
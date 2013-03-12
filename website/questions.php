<?php 
require_once 'database.php';

class Questions {
	private $number_of_questions = NULL;
	private $number_of_okc_questions = NULL;
	private $question_string = NULL;
	private $okc_question_string = NULL;
	private $okc_html_string = NULL;
	private $question_ids = array();
	private $classic_questions = array();
	private $okc_data = array();

	function getClassicQuestionsArray() {	
		return $this->question_string;
	}

	 function initClassicQuestions() {		
	
		if($this->question_string == NULL) {
			$mysqli = VotematchDB::getConnection();

			if (mysqli_connect_errno()) {
				echo '<p><h2>Error connecting to database:</h2>' . mysqli_connect_error() . '</p>';
			} else {
				$stmt = $mysqli->prepare("SELECT id, question_en, question_rus, question_ger, question_jp FROM classic_questions AS q WHERE q.election_id = ? ORDER BY q.id ASC");
				$election = Config::active_election;
				$stmt->bind_param("i", $election);
				$stmt->execute();

				$stmt->bind_result($id, $en, $rus, $ger, $jp);

				$this->question_string = 'var questions = [';

				$comma = "";
				$num_questions = 0;
				while($stmt->fetch()) {
					$this->question_string = $this->question_string . "$comma [\"$en\", \"$ger\", \"$rus\", \"$jp\"]";
					$comma = ",\n";
					$this->classic_questions[$num_questions] = $id;
					$num_questions++;
					
				}
				
				$this->number_of_questions = $num_questions;

				$this->question_string = $this->question_string . '];';

				$stmt->close();
			}
		}
	}
	
	 function getIdForQuestion($i) {
		$this->initClassicQuestions();
		
		return $this->classic_questions[$i];
	}
	
	 function getNumClassicQuestions() {
		$this->initClassicQuestions();
		
		return $this->number_of_questions;
	}
	
	 function printClassicQuestionTable($showComments, $answers) {
		for($i = 0; $i < Questions::getNumClassicQuestions(); $i++) {
			$answer = $answers[$i];
			
			$even = $i % 2;
			
			$tr_class = "qrow ";
			
			if($even)
				$tr_class = $tr_class . "even";
			else
				$tr_class = $tr_class . "uneven";
				
			$answer_value = 0;
			if($answer != null)
				$answer_value = $answer->getAnswer();
				
			$weight_value = 1.0;
			if($answer != null)
				$weight_value = $answer->getWeight();
			
			echo '<tr class="' . $tr_class . '" data-toggle="collapse" data-target="#r' . $i . '"><td class="question"></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="SD" ' . $this->getChecked($answer_value, -2) . ' /></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="D" ' . $this->getChecked($answer_value, -1) . ' /></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="NO" ' . $this->getChecked($answer_value, 0) . ' /></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="A" ' . $this->getChecked($answer_value, 1) . ' /></td>' .
			 '<td class="answer"><input type="radio" name="q' . $i . '" value="SA" ' . $this->getChecked($answer_value, 2) . ' /></td>' .
			 '<td class="answer"><a href="#" onclick="decrementWeight(' . $i . '); return false;" class="btn btnsmall">-</a><input type="text" class="tiny" name="q' . $i . '_weight" value="' . $weight_value . '" width="2" onchange="changeValue(' . $i . ');" class="noEnterSubmit" /><a href="#" onclick="incrementWeight(' . $i . '); return false;" class="btn btnsmall">+</a></td></tr>';
			 
			if($showComments)
				echo '<tr><td colspan="7"><div class="collapse" id="r' . $i . '"><input type="text" class="span9" name="c' . $i . '" placeholder="You can explain your answer here" value="' . $answer->getComment() . '" /></div></td></tr>';
		}
	}
	
	function getChecked($answer, $value) {
		if($answer == $value)
			return 'checked';
			
		return '';
	}
	
	function getAnswerForQuestion($id, $answers) {
		for($i = 0; $i < count($answers); $i++) {
			$answer = $answers[$i];
			
			if($answer->getId() == $id) {
				return $answer;
			}
		}
		
		return null;
	}
	
	function printOKCQuestions($answers) {
		$html = "";
		
		$qid = 0;
		$showComments = false;
		$answer = null;
		for($i = 0; $i < count($this->okc_data); $i++) {
			$answer = $this->getAnswerForQuestion($this->okc_data[$i]["qid"], $answers);
			$currentAnswer = $this->getAnswerForQuestion($this->okc_data[$i]["current_id"], $answers);	
			$html .= $this->addToHtml($this->okc_data[$i]["current_id"], $this->okc_data[$i]["qid"], $this->okc_data[$i]["q_en"], $this->okc_data[$i]["q_ger"], 
										$this->okc_data[$i]["q_rus"], $this->okc_data[$i]["q_jp"], $this->okc_data[$i]["o_en"], $this->okc_data[$i]["o_ger"], 
										$this->okc_data[$i]["o_rus"], $this->okc_data[$i]["o_jp"], $this->okc_data[$i]["count"], 
										$this->okc_data[$i]["optionid"], $this->okc_data[$i]["showComments"], $answer, $currentAnswer);
										
			$qid =  $this->okc_data[$i]["qid"];
			$showComments =  $this->okc_data[$i]["showComments"];
		}
		
		$html .= $this->completeHtmlDiv($qid, $showComments, $answer);
		
		return $html;
	}
	
	 function initOKCQuestions($showComments) {
		if($this->okc_html_string == NULL) {
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
					if($current_id != $qid) {
						array_push($this->question_ids, $qid);
						$count++;
					}
						
					$okc_js_array .= $this->addToJsArray($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp);
					$this->addOkcData($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp, $count, $optionid, $showComments);
					$current_id = $qid;
				}
				
				// we're finished, add closing brackets for last object and final array closing bracket
				$okc_js_array .= " ]\n\t}\n];";
			
				$this->okc_question_string = $okc_js_array;
				$this->okc_html_string = $okc_html;
				$this->number_of_okc_questions = $count;
				$stmt->close();
			}
		}
	}
	
	function closeDB() {
		VotematchDB::close();
	}
	
	function addOkcData($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp, $count, $optionid, $showComments) {
		$i = count($this->okc_data);
		
		$this->okc_data[$i]["current_id"] = $current_id;
		$this->okc_data[$i]["qid"] = $qid;
		$this->okc_data[$i]["q_en"] = $q_en;
		$this->okc_data[$i]["q_ger"] = $q_ger;
		$this->okc_data[$i]["q_rus"] = $q_rus;
		$this->okc_data[$i]["q_jp"] = $q_jp;
		$this->okc_data[$i]["o_en"] = $o_en;
		$this->okc_data[$i]["o_ger"] = $o_ger;
		$this->okc_data[$i]["o_rus"] = $o_rus;
		$this->okc_data[$i]["o_jp"] = $o_jp;
		$this->okc_data[$i]["count"] = $count;
		$this->okc_data[$i]["optionid"] = $optionid;
		$this->okc_data[$i]["showComments"] = $showComments;
	}
	
	function addToJsArray($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp) {
		$okc_js_array = "";
		
		// check if we're looking at options belonging to the same question that we worked on previous iteration
		if($current_id != $qid) {
			// if it is a new question so, check if this isn't the first ever object in the array, and add closing brackets for last array item
			if($current_id != -1)
				$okc_js_array .=  " ]\n\t },";
				
			// since this is a new question, add a new question object
			$okc_js_array .= "\n\t" . '{"id": ' . $qid . ', "question":["' . $q_en . '", "' . $q_ger . '", "' . $q_rus . '", "' . $q_jp . '"],' . "\n\t" . '"options":[';
			
		} else
			$okc_js_array .= ", "; // it's not a new question, just append a comma to seperate option arrays
		
		// append this iteration's option values
		$okc_js_array .= "\n\t\t" . '["' . $o_en . '", "' . $o_ger . '", "' . $o_rus . '", "' . $o_jp . '"]' ;
		
		return $okc_js_array;
	}
	
	function addToHtml($current_id, $qid, $q_en, $q_ger, $q_rus, $q_jp, $o_en, $o_ger, $o_rus, $o_jp, $i, $optionid, $showComments, $answer, $currentAnswer) {
		$html = "";
		if($current_id != $qid) {
			// complete previous div unless this is the very first div in the series
			if($current_id != -1) {
				$html .= $this->completeHtmlDiv($current_id, $showComments, $currentAnswer);
			}
			$html .= "<div class=\"okcdiv\"><h3 class=\"okcquestion\">$q_en</h3>";
			
			if(!$showComments)
				$html .= "<span class=\"okc_ans\">Answers I will accept from a candidate:</span><br>";
		}
		if($showComments) {
			$answervalue = 0;
			
			if($answer != null)
				$answervalue = $answer->getAnswer();
				
			$html .= '<input type="radio" name="ans_' . $qid .'" value="' . $optionid . '" ' . $this->getChecked($optionid, $answervalue) . ' />' . $o_en . '<br>';
		} else
			$html .= '<input type="checkbox" name="ans_' . $qid .'[]" value="' . $optionid . '" /> <span class="option_' . $i . '">' . $o_en . '</span><br>';
		
		return $html;
	}
	
	function getSelected($answer, $value) {
		if($answer == $value)
			return "selected";
			
		return "";
	}
	
	function completeHtmlDiv($question, $showComments, $answer) {
		$name = 'ans_' . $question . '[]';
		if($showComments)
			$name = "ans_$question";
		
		$answer_value = 0;
		if($answer != null)
			$answer_value = $answer->getWeight();
			
		$html = "<br><span class=\"okc_imp\">How important is this issue to you?</span><br>
				<select name=\"imp_$question\" onchange=\"onImportanceChanged('$name', this)\">
					<option class=\"okc_imp_ni\" value=\"ni\" " . $this->getSelected($answer_value, 0) . " >Irrelevant</option>
					<option class=\"okc_imp_li\" value=\"li\" " . $this->getSelected($answer_value, 1) . " >A little important</option>
					<option class=\"okc_imp_si\" value=\"si\" " . $this->getSelected($answer_value, 5) . " >Somewhat important</option>
					<option class=\"okc_imp_vi\" value=\"vi\" " . $this->getSelected($answer_value, 10) . " >Very important</option>
					<option class=\"okc_imp_ma\" value=\"ma\" " . $this->getSelected($answer_value, 50) . " >Mandatory</option>
				</select>";
				
		if($showComments) {
			$comment = "";
			
			if($answer != null)
				$comment = $answer->getComment();
				
			$html .= '<input type="text" name="okc_c' . $question . '" class="span10" placeholder="You can explain your answer here" value="' . $comment . '" />';
		}
			
		$html .= "</div>";
				
		return $html;
	}
	
	 function getOKCQuestionsArray() {
		return "var okc_questions = " . $this->okc_question_string;
	}
	
	 function getOKCHTML() {
		return $this->okc_html_string;
	}
	
	 function getOKCIds() {
		return '<input type="hidden" name="ids" value="' . serialize($this->question_ids) . '" />';
	}
}
?>
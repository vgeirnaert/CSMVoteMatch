<?php
class Candidate {
	private $classic_answers = array();
	private $okc_answers = array();
	private $name;
	private $id;
	
	public function __construct($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getClassicAnswers() {
		return $this->classic_answers;
	}
	
	public function getOkcAnswers() {
		return $this->okc_answers;
	}
	
	public function addClassicAnswer($answer) {
		array_push($this->classic_answers, $answer);
	}
	
	public function addOkcAnswer($answer) {
		array_push($this->okc_answers, $answer);
	}
}
?>
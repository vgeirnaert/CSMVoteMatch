<?php
class Answer {
	private $id;
	private $answer;
	private $weight;
	private $comment;
	
	public function __construct($id, $answer = 0, $weight = 0, $comment = "") {
		$this->id = $id;
		$this->answer = $answer;
		$this->weight = $weight;
		$this->comment = $comment;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getAnswer() {
		return $this->answer;
	}
	
	public function getWeight() {
		return $this->weight;
	}
	
	public function getComment() {
		return $this->comment;
	}
}
?>
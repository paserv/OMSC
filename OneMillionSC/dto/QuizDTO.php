<?php
class QuizDTO {
	
	public $id;
	public $name;
	public $threshold;
	public $counter;
	public $solution;
	
	function __construct($id, $name, $threshold, $counter, $solution) {
		$this->id = $id;
		$this->name = $name;
		$this->threshold = $threshold;
		$this->counter = $counter;
		$this->solution = $solution;
	}
	
}
?>
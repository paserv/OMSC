<?php
class CustomException {
	public $error_code;
	public $private_message;
	public $existProblem;
	
	function __construct() {
		$this->existProblem = false;
	}
	
	function setError($ec, $pm) {
		$this->existProblem = true;
		$this->error_code = $ec;
		$this->private_message = $pm;
	}
	
}
?>
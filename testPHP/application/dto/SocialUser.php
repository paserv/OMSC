<?php
class SocialUser {
	public $socialId;
	public $name;
	public $email;
	
	function __construct($socialId, $name, $email) {
		$this->socialId = $socialId;
		$this->name = $name;
		$this->email = $email;
	}
	
}
?>
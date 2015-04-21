<?php
class SocialUser {
	public $socialId;
	public $name;
	public $email;
	public $socialNetwork;
	
		
	function setId($socialId){
		$this->socialId = $socialId;
	}
	
	function setName($name){
		$this->name = $name;
	}
	
	function setEmail($email){
		$this->email = $email;
	}
	
	function setSocialNetwork($socialNetwork){
		$this->socialNetwork = $socialNetwork;
	}
	
	
}
?>
<?php
#require_once 'SocialUser.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/application/dto/SocialUser.php';

class DBUser extends SocialUser {
	public $latitude;
	public $longitude;
	public $description;
	public $timestamp;
	
	function __construct($id, $name, $email, $latitude, $longitude, $description, $socialPageUrl, $avatarUrl, $timestamp, $socialNetwork) {
		
		$this->socialId = $id;
		$this->name = $name;
		$this->email = $email;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->description = $description;
		$this->socialPageUrl = $socialPageUrl;
		$this->avatarUrl = $avatarUrl;
		$this->timestamp = $timestamp;
		$this->socialNetwork = $socialNetwork;
	}
	
}
?>
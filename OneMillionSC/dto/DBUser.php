<?php
require_once 'autoload.php';
DBUser_autoload();

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
	
	static function createDBUser(SocialUser $socialUser) {
		return new DBUser($socialUser->socialId, $socialUser->name, $socialUser->email, null, null, null, $socialUser->socialPageUrl, $socialUser->avatarUrl, null, null);
	}
	
	function isRegistered() {
		if ($this->latitude != null && $this->longitude != null) return true;
		return false;
	}
	
	function stringify() {
		echo "Social ID: " . $this->socialId ."<br>" . 
		"Name: " . $this->name ."<br>" .
		"Email: " . $this->email ."<br>" .
		"longitude: " . $this->longitude ."<br>" .
		"latitude: " . $this->latitude ."<br>" .
		"description: " . $this->description ."<br>" .
		"socialPageUrl: " . $this->socialPageUrl ."<br>" .
		"avatarUrl: " . $this->avatarUrl ."<br>" .
		"timestamp: " . $this->timestamp ."<br>" .
		"socialNetwork: " . $this->socialNetwork ."<br>";
	}
	
}
?>
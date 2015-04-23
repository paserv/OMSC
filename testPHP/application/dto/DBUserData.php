<?php
class DBUserData {
	public $socialId;
	public $name;
	public $email;
	public $socialNetwork;
	public $latitude;
	public $longitude;
	public $description;
	public $timestamp;
	public $socialPageUrl;
	public $avatarUrl;
	
	function __construct($id, $name, $email, $latitude, $longitude, $description, $socialPageUrl, $avatarUrl, $timestamp, $socialNetwork) {
		$this->id = $id;
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
<?php
class DBUserData {
	public $id;
	public $name;
	public $email;
	public $longitude;
	public $latitude;
	public $description;
	public $socialPageUrl;
	public $avatarUrl;
	
	function __construct($id, $name, $email, $latitude, $longitude, $description, $socialPageUrl, $avatarUrl) {
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->description = $description;
		$this->socialPageUrl = $socialPageUrl;
		$this->avatarUrl = $avatarUrl;
	}
}
?>
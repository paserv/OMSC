<?php
class SocialUser {
	public $socialId;
	public $name;
	public $email;
	public $socialNetwork;
	public $socialPageUrl;
	public $avatarUrl;
	public $loginUrl;
	
	function __construct($id, $name, $email, $socialPageUrl, $avatarUrl, $socialNetwork) {
		$this->socialId = $id;
		$this->name = $name;
		$this->email = $email;
		$this->socialPageUrl = $socialPageUrl;
		$this->avatarUrl = $avatarUrl;
		$this->socialNetwork = $socialNetwork;
	}
	
	static function createLoginUrl($loginUrl) {
		$user = new SocialUser(null, null, null, null, null, null);
		$user->loginUrl = $loginUrl;
		return $user;
	}
	
}
?>
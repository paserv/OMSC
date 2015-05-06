<?php
require_once 'autoload.php';
DummyModel_autoload();

class DummyModel extends AbstractSocialModel {
	public function getUser() {
		$user = new SocialUser();
		$user->setId(0);
		$user->setName("DummyName");
		$user->setEmail("DummyMail");
		return $user;
	}
}

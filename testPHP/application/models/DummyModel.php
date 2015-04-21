<?php
include_once '../models/AbstractSocialModel.php';
include_once '../dto/SocialUser.php';

class DummyModel extends AbstractSocialModel {
	public function getUser() {
		$user = new SocialUser();
		$user->setId(0);
		$user->setName("DummyName");
		$user->setEmail("DummyMail");
		return $user;
	}
}

<?php
#require_once '../models/AbstractSocialModel.php';
#require_once '../dto/SocialUser.php';

require_once $_SERVER["DOCUMENT_ROOT"] . '/application/models/AbstractSocialModel.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/application/dto/SocialUser.php';

class DummyModel extends AbstractSocialModel {
	public function getUser() {
		$user = new SocialUser();
		$user->setId(0);
		$user->setName("DummyName");
		$user->setEmail("DummyMail");
		return $user;
	}
}

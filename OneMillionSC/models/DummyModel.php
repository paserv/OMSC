<?php
require_once 'autoload.php';
DummyModel_autoload();

class DummyModel extends AbstractSocialModel {
	public function getUser() {
		$randId = rand ( 1000000 , 10000000 );
		$user = new SocialUser($randId, "DummyName", "DummyMail", "http://www.aoapao.com", "http://www.aoapao.com/public/img/dummy.png", "socialNetwork");
		return $user;
	}
}

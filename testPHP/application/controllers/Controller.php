<?php
include_once '../models/FBModel.php';
include_once '../models/DBModel.php';
include_once '../models/FusionModel.php';
include_once '../models/DummyModel.php';
include_once '../dto/SocialUser.php';
include_once '../dto/DBUser.php';

class Controller {
	function getLoggedUser($socialNetwork) {
		switch ($socialNetwork) {
			case "FB" :
				$model = new FBModel ();
				break;
			case "TW" :
				echo "TWITTER NOT PRESENT";
				$model = new DummyModel();
				break;
			case "PL" :
				echo "PLUS NOT PRESENT";
				$model = new DummyModel();
				break;
			case "LI" :
				echo "LINKEDIN NOT PRESENT";
				$model = new DummyModel();
				break;
			case "PI" :
				echo "PINTEREST NOT PRESENT";
				$model = new DummyModel();
				break;
			case "TU" :
				echo "TUMBLR NOT PRESENT";
				$model = new DummyModel();
				break;
			case "YT" :
				echo "YOUTUBE NOT PRESENT";
				$model = new DummyModel();
				break;
			case "IN" :
				echo "INSTAGRAM NOT PRESENT";
				$model = new DummyModel();
				break;
		}
		
		$user = $model->getUser();
		$user->socialNetwork = $socialNetwork;
		return $user;
	}
	function registerUserIntoDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->insertUser ( $dbData );
	}
	function registerUserIntoFusionTable(SocialUser $dbData) {
		$model = new FusionModel ();
		$model->insertUser ( $dbData );
	}
	function registerFakeUserIntoFusionTable(SocialUser $dbData) {
		$model = new FusionModel ();
		$model->insertUserFake ( $dbData );
	}
}
?>
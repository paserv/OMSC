<?php

include_once '../models/FBmodel.php';
include_once '../models/DBmodel.php';
include_once '../models/Fusionmodel.php';
include_once '../dto/DBUserData.php';
include_once '../dto/SocialUser.php';

class Controller {
	
	function getLoggedUser() {
		$model = new FBModel();
		return $model->getUser();
	}
	
	
	function registerUserIntoDB(DBUserData $dbData) {
		$model = new DBModel();
		$model->insertUser($dbData);
	}
	
	function registerUserIntoFusionTable(DBUserData $dbData) {
		$model = new FusionModel();
		$model->insertUser($dbData);
	}
	
	function registerFakeUserIntoFusionTable(DBUserData $dbData) {
		$model = new FusionModel();
		$model->insertUserFake($dbData);
	}
	
}
?>
<?php
require_once 'autoload.php';
controller_autoload();

class Controller {
	function getLoggedUser($socialNetwork) {
		switch ($socialNetwork) {
			case "FB" :
				$model = new FBModel ();
				break;
			case "TW" :
				$model = new DummyModel ();
				break;
			case "PL" :
				$model = new DummyModel ();
				break;
		}
		
		$user = $model->getUser ();
		$user->socialNetwork = $socialNetwork;
		return $user;				
	}
	
	function register(DBUser $dbData) {
		$this->registerUserIntoDB ( $dbData );
		try {
			//$this->registerUserIntoFusionTable ( $dbData );
			//$this->registerFakeUserIntoFusionTable ( $dbData );
		} catch ( Exception $e ) {
			$this->deleteUserFromDB($dbData);
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}
	
	function delete(DBUser $dbData) {
		$this->deleteUserFromDB($dbData);
		try {
			//$this->deleteUserFromFusionTable($dbData);
		} catch ( Exception $e ) {
			$this->registerUserIntoDB($dbData);
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}
	
	function update(DBUser $dbData) {
		$oldUser = $this->search($dbData->socialId);
		$this->updateUserIntoDB($dbData);
		try {
			//$this->updateUserIntoFusionTable($dbData);
		} catch ( Exception $e ) {
			$this->updateUserIntoDB($oldUser);
			throw new Exception($e->getMessage(), $e->getCode());
		}
		
	}
	
	function search($socialId) {
		$model = new DBModel();
		$result = $model->searchById($socialId);
		return $result;
	}
	
	function count() {
		$model = new DBModel();
		$result = $model->countUsers();
		return $result;
	}
	
	function isUserRegistered($socialId) {
		$model = new DBModel ();
		return $model->isUserRegistered($socialId);
	}
	
	function searchByName($name) {
		$model = new DBModel();
		$result = $model->searchByName($name);
		return $result;
	}
	
	function searchByNameAndCoords ($name, $lat, $lng, $ray) {
		$model = new DBModel();
		$result = $model->searchByNameAndCoords($name, $lat, $lng, $ray);
		return $result;
	}
	
	function searchByCoords ($lat, $lng, $ray) {
		$model = new DBModel ();
		$result = $model->searchByCoords($lat, $lng, $ray);
		return $result;
	}
	
	function registerUserIntoDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->insertUser ( $dbData );
	}
	function registerUserIntoFusionTable(SocialUser $dbData) {
		$model = new FusionModel ();
		$model->insertUser ( $dbData );
	}
	function registerFakeUserIntoFusionTable(DBUser $dbData) {
		$model = new FusionModel ();
		$model->insertUserFake ( $dbData );
	}
	
	function deleteUserFromDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->deleteUser($dbData->socialId);
	}
	function deleteUserFromFusionTable(DBUser $dbData) {
		$model = new FusionModel ();
		$model->deleteUser ( $dbData );
	}
	
	function updateUserIntoDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->updateUser($dbData);
	}
	
	function updateUserIntoFusionTable(DBUser $dbData) {
		$model = new FusionModel();
		$model->updateUser($dbData);
	}
	
}
?>
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
				echo "TWITTER NOT PRESENT";
				$model = new DummyModel ();
				break;
			case "PL" :
				echo "PLUS NOT PRESENT";
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
			$this->registerUserIntoFusionTable ( $dbData );
			//$this->registerFakeUserIntoFusionTable ( $dbData );
		} catch ( Exception $e ) {
			$model = new DBModel ();
			$model->deleteUser($dbData->socialId);
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}
	
	function delete(DBUser $dbData) {
		$this->deleteUserFromDB($dbData);
		$this->deleteUserFromFusionTable($dbData);
	}
	
	function update(DBUser $dbData) {
		$this->updateUserToDB($dbData);
		$this->updateUserToFusionTable($dbData);
	}
	
	function search($socialId) {
		$model = new DBModel();
		$result = $model->searchById($socialId);
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
	
	
	function updateUserToDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->updateUser($dbData);
	}
	function updateUserToFusionTable(DBUser $dbData) {
		$model = new FusionModel ();
		$model->updateUser ( $dbData );
	}
	
	
	
	function sendMail($errno, $errstr) {
		echo "<b>Error:</b> [$errno] $errstr<br>";
		echo "Webmaster has been notified";
		error_log("Error: [$errno] $errstr",1,
		"someone@example.com","From: webmaster@example.com");
	}
}
?>
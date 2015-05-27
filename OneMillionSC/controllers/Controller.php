<?php
require_once 'autoload.php';
controller_autoload();

class Controller {
	function logout() {
		$_SESSION ["id"] = null;
		$_SESSION ["name"] =null;
		$_SESSION ["mail"] = null;
		$_SESSION ["avatarUrl"] = null;
		$_SESSION ["socialPageUrl"] = null;
		$_SESSION ["sn"] = null;
		$_SESSION ["isRegistered"] = null;
	}
	function getLoggedUser($socialNetwork) {
		$_SESSION ["sn"] = $socialNetwork;
		if (isset ($_SESSION ["id"]) && $_SESSION ["id"] !== null ) {
			$_SESSION ["isRegistered"] = $this->isUserRegistered($_SESSION ["id"]);
			return new SocialUser($_SESSION ["id"], $_SESSION ["name"], $_SESSION ["mail"], $_SESSION ["socialPageUrl"], $_SESSION ["avatarUrl"], $_SESSION ["sn"]);
		} else {
			switch ($socialNetwork) {
				case "FB" :
					$model = new FBModel ();
					break;
				case "TW" :
					$model = new DummyModel ();
					break;
				case "PL" :
					$model = new PLModel ();
					break;
			}
			$user = $model->getUser();
			if ($user->socialId !== null) {
				$user->socialNetwork = $socialNetwork;
				$_SESSION ["id"] = $user->socialId;
				$_SESSION ["name"] = $user->name;
				$_SESSION ["mail"] = $user->email;
				$_SESSION ["avatarUrl"] = $user->avatarUrl;
				$_SESSION ["socialPageUrl"] = $user->socialPageUrl;
				$_SESSION ["isRegistered"] = $this->isUserRegistered($_SESSION ["id"]);
			}
			
			return $user;
		}
	}
	
	function register(DBUser $dbData) {
		$this->registerUserIntoDB ( $dbData );
		try {
// 			$this->registerUserIntoFusionTable ( $dbData );
			$_SESSION ["id"] = $dbData->socialId;
			$_SESSION ["name"] = $dbData->name;
			$_SESSION ["mail"] = $dbData->email;
			$_SESSION ["avatarUrl"] = $dbData->avatarUrl;
			$_SESSION ["socialPageUrl"] = $dbData->socialPageUrl;
			$_SESSION ["sn"] = $dbData->socialNetwork;
			$_SESSION ["isRegistered"] = true;
		} catch ( Exception $e ) {
			$this->deleteUserFromDB($dbData);
			throw new Exception($e->getMessage(), 300);
		}
	}
	
	function delete(DBUser $dbData) {
		$this->deleteUserFromDB($dbData);
		try {
// 			$this->deleteUserFromFusionTable($dbData);
			$_SESSION ["id"] = null;
			$_SESSION ["name"] =null;
			$_SESSION ["mail"] = null;
			$_SESSION ["avatarUrl"] = null;
			$_SESSION ["socialPageUrl"] = null;
			$_SESSION ["sn"] = null;
			$_SESSION ["isRegistered"] = null;
		} catch ( Exception $e ) {
			$this->registerUserIntoDB($dbData);
			throw new Exception($e->getMessage(), 301);
		}
	}
	
	function update(DBUser $dbData) {
		$oldUser = $this->search($dbData->socialId);
		$this->updateUserIntoDB($dbData);
		try {
// 			$this->updateUserIntoFusionTable($dbData);
		} catch ( Exception $e ) {
			$this->updateUserIntoDB($oldUser);
			throw new Exception($e->getMessage(), 302);
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
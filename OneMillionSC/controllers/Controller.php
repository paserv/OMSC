<?php
require_once 'autoload.php';
controller_autoload();

use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

class Controller {
	
	/**
	 * SITE CONTROLS
	 */
	function getUser($socialNetwork) {
		if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) {
			$user = $this->getUserFromSession();
			$registeredUser = $this->search($user->socialId);
			if ($registeredUser != null) {
				$user->latitude = $registeredUser->latitude;
				$user->longitude = $registeredUser->longitude;
				$user->description = $registeredUser->description;
				$_SESSION ["latitude"] = $user->latitude;
				$_SESSION ["longitude"] = $user->longitude;
				$_SESSION ["aboutme"] = $user->description;
			}
			return $user;
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
				$user = DBUser::createDBUser($user);
				$user->socialNetwork = $socialNetwork;
				$_SESSION ["id"] = $user->socialId;
				$_SESSION ["name"] = $user->name;
				$_SESSION ["mail"] = $user->email;
				$_SESSION ["avatarUrl"] = $user->avatarUrl;
				$_SESSION ["socialPageUrl"] = $user->socialPageUrl;
				$_SESSION ["isLogged"] = true;
				$registeredUser = $this->search($user->socialId);
				if ($registeredUser != null) {
					$user->latitude = $registeredUser->latitude;
					$user->longitude = $registeredUser->longitude;
					$user->description = $registeredUser->description;
					$_SESSION ["latitude"] = $user->latitude;
					$_SESSION ["longitude"] = $user->longitude;
					$_SESSION ["aboutme"] = $user->description;
				}
			}
			return $user;
		}
	}
	
	function getUserFromSession() {
		$socialId = $_SESSION["id"];
		$name = $_SESSION["name"];
		$mail = $_SESSION["mail"];
		$socialNetwork = $_SESSION["sn"];
		$avatarUrl = $_SESSION["avatarUrl"];
		$socialPageUrl = $_SESSION["socialPageUrl"];
		$user = new DBUser($socialId, $name, $mail, null, null, null, $socialPageUrl, $avatarUrl, null, $socialNetwork);
		if (isset($_SESSION ["latitude"]) && isset($_SESSION ["longitude"]) && isset($_SESSION ["aboutme"])) {
			$user->latitude = $_SESSION ["latitude"];
			$user->longitude = $_SESSION ["longitude"];
			$user->description = $_SESSION ["aboutme"];
		}
		return $user;
	}
	
	function isUserLoggedAndRegistered() {
		if ($_SESSION ["latitude"] && $_SESSION ["longitude"] && $_SESSION ["aboutme"]) {
			return true;
		}
		return false;
	}
	
	function logout() {
		$_SESSION ["id"] = null;
		$_SESSION ["name"] =null;
		$_SESSION ["mail"] = null;
		$_SESSION ["avatarUrl"] = null;
		$_SESSION ["socialPageUrl"] = null;
		$_SESSION ["sn"] = null;
		$_SESSION ["isLogged"] = null;
		$_SESSION ["latitude"] = null;
		$_SESSION ["longitude"] = null;
		$_SESSION ["aboutme"] = null;
	}
	
	function register(DBUser $dbData, $paymentId, $payerID) {
		try {
			$this->registerUserIntoDB ( $dbData );
		}  catch ( Exception $e ) {
			throw new Exception($e->getMessage(), 300);
		}
		try {
			//$this->registerUserIntoFusionTable ( $dbData );
		} catch ( Exception $e ) {
			$this->deleteUserFromDB($dbData);
			throw new Exception($e->getMessage(), 300);
		}
		if (IS_PAYPAL_ENABLED) {
			try {
				$this->executePayment($paymentId, $payerID);
			}  catch ( Exception $e ) {
				$this->deleteUserFromDB($dbData);
				//$this->deleteUserFromFusionTable($dbData);
				throw new Exception($e->getMessage(), 300);
			}
		}
		$this->incrementMembers();
	}
	
	function delete(DBUser $dbData) {
		$this->deleteUserFromDB($dbData);
		try {
			//$this->deleteUserFromFusionTable($dbData);
			$this->logout();
		} catch ( Exception $e ) {
			$this->registerUserIntoDB($dbData);
			throw new Exception($e->getMessage(), 301);
		}
		$this->decrementMembers();
	}
	
	function update(DBUser $dbData) {
		$oldUser = $this->search($dbData->socialId);
		$this->updateUserIntoDB($dbData);
		try {
			//$this->updateUserIntoFusionTable($dbData);
		} catch ( Exception $e ) {
			$this->updateUserIntoDB($oldUser);
			throw new Exception($e->getMessage(), 302);
		}
	
	}
	
	function setSocialLogRequest () {
		if(isset($_REQUEST['sn'])){
			if ($_SESSION['sn'] !== $_REQUEST['sn']) {
				$this->logout();
			}
			$_SESSION['sn'] = $_REQUEST['sn'];
		}
		
		if (!isset($_SESSION ["sn"])) {
			die("<script>location.href = 'index.php'</script>");
		}
	}
	/**
	 * PAYPAL CONTROLS 
	 */
	function redirectToPayPal() {
		$payPalUrl = $this->getPayPalUrl();
		header("Location: " . $payPalUrl);
		die();
	}
	
	function getPayPalUrl() {
		$model = new PayPalModel();
		return $model->createPaymentUrl();
	}
	
	function executePayment($paymentId, $payerID) {
		$model = new PayPalModel();
		$payment = Payment::get ( $paymentId, $model->apiContext );
		
		$execution = new PaymentExecution ();
		$execution->setPayerId ( $payerID );
		
		try {
			$result = $payment->execute ( $execution, $model->apiContext );
			try {
				$payment = Payment::get ( $paymentId, $model->apiContext );
			} catch ( Exception $ex ) {
				throw new Exception($ex->getMessage(), 300);
			}
		} catch ( Exception $ex ) {
			throw new Exception($ex->getMessage(), 300);
		}
		
		return $payment;
		
	}
	
	
	/**
	 * DB CONTROLS
	 */

	function incrementMembers() {
		$model = new DBModel ();
		$total_users = $model->addUsers(1);
		$_SESSION ["total_users"] = $total_users;
	}
	
	function decrementMembers() {
		$model = new DBModel ();
		$total_users = $model->addUsers(-1);
		$_SESSION ["total_users"] = $total_users;
	}
	
	function countMembers() {
		$model = new DBModel ();
		$total_users = $model->countUsers();
		$_SESSION ["total_users"] = $total_users;
	}
	
	function registerUserIntoDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->insertUser ( $dbData );
	}
	
	function deleteUserFromDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->deleteUser($dbData->socialId);
	}
	
	function updateUserIntoDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->updateUser($dbData);
	}
	
	function search($socialId) {
		$model = new DBModel();
		$result = $model->searchById($socialId);
		return $result;
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
	
	/**
	 * FUSION CONTROLS
	 */
	function registerUserIntoFusionTable(SocialUser $dbData) {
		$model = new FusionModel ();
		$model->insertUser ( $dbData );
	}
	function registerFakeUserIntoFusionTable(DBUser $dbData) {
		$model = new FusionModel ();
		$model->insertUserFake ( $dbData );
	}
	
	function deleteUserFromFusionTable(DBUser $dbData) {
		$model = new FusionModel ();
		$model->deleteUser ( $dbData );
	}
	
	function updateUserIntoFusionTable(DBUser $dbData) {
		$model = new FusionModel();
		$model->updateUser($dbData);
	}
	
	
// 	function getLoggedUser($socialNetwork) {
// 		$_SESSION ["sn"] = $socialNetwork;
// 		if (isset ($_SESSION ["id"]) && $_SESSION ["id"] !== null ) {
// 			$_SESSION ["isRegistered"] = $this->isUserRegistered($_SESSION ["id"]);
// 			return new SocialUser($_SESSION ["id"], $_SESSION ["name"], $_SESSION ["mail"], $_SESSION ["socialPageUrl"], $_SESSION ["avatarUrl"], $_SESSION ["sn"]);
// 		} else {
// 			switch ($socialNetwork) {
// 				case "FB" :
// 					$model = new FBModel ();
// 					break;
// 				case "TW" :
// 					$model = new DummyModel ();
// 					break;
// 				case "PL" :
// 					$model = new PLModel ();
// 					break;
// 			}
// 			$user = $model->getUser();
// 			if ($user->socialId !== null) {
// 				$user->socialNetwork = $socialNetwork;
// 				$_SESSION ["id"] = $user->socialId;
// 				$_SESSION ["name"] = $user->name;
// 				$_SESSION ["mail"] = $user->email;
// 				$_SESSION ["avatarUrl"] = $user->avatarUrl;
// 				$_SESSION ["socialPageUrl"] = $user->socialPageUrl;
// 				$_SESSION ["isRegistered"] = $this->isUserRegistered($_SESSION ["id"]);
// 			}
				
// 			return $user;
// 		}
// 	}

// 	function getUserFromSession() {
// 		$socialId = $_SESSION["id"];
// 		$name = $_SESSION["name"];
// 		$mail = $_SESSION["mail"];
// 		$socialNetwork = $_SESSION["sn"];
// 		$avatarUrl = $_SESSION["avatarUrl"];
// 		$socialPageUrl = $_SESSION["socialPageUrl"];
	
// 		$timestamp = date("Y-m-d H:i:s");
	
// 		$latitude = "";
// 		$longitude = "";
// 		if (isset($_SESSION["latitude"]) && isset($_SESSION["longitude"])) {
// 			$latitude = $_SESSION["latitude"];
// 			$longitude = $_SESSION["longitude"];
// 		}
	
// 		$aboutme = "";
// 		if (isset($_SESSION["aboutme"])) {
// 			$aboutme = $_SESSION["aboutme"];
// 		}
	
// 		$user = new DBUser($socialId, $name, $mail, $latitude, $longitude, $aboutme, $socialPageUrl, $avatarUrl, $timestamp, $socialNetwork);
// 		return $user;
// 	}

// 	function count() {
// 		$model = new DBModel();
// 		$result = $model->countUsers();
// 		return $result;
// 	}
	
// 	function isUserRegistered($socialId) {
// 		$model = new DBModel ();
// 		return $model->isUserRegistered($socialId);
// 	}
}
?>
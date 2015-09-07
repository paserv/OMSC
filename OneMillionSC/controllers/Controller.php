<?php
require_once 'autoload.php';
controller_autoload();
ReCaptcha_autoload();

class Controller {
	
	/**
	 * SITE CONTROLS
	 */
	function getUser($socialNetwork) {
		if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) {
			$user = $this->getUserFromSession();
			$registeredUser = $this->search($user->socialId, $socialNetwork);
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
					$model = new TWModel ();
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
				$registeredUser = $this->search($user->socialId, $socialNetwork);
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
		if (isset ($_SESSION ["latitude"]) && isset($_SESSION ["longitude"]) && isset($_SESSION ["aboutme"])) {
			return true;
		}
		return false;
	}
	
	function logout() {
// 		$_SESSION ["id"] = null;
// 		$_SESSION ["name"] = null;
// 		$_SESSION ["mail"] = null;
// 		$_SESSION ["avatarUrl"] = null;
// 		$_SESSION ["socialPageUrl"] = null;
// 		$_SESSION ["isLogged"] = null;
// 		$_SESSION ["latitude"] = null;
// 		$_SESSION ["longitude"] = null;
// 		$_SESSION ["aboutme"] = null;
// 		$_SESSION['oauth_token'] = null;
// 		$_SESSION['oauth_token_secret'] = null;
// 		$_SESSION ["sn"] = null;
// 		$_SESSION ["isLogged"] = false;
// 		$_SESSION ["total_users"] = null;
 		session_unset();
	}
	
	function registerFree(DBUser $dbData) {
		$this->register($dbData, 'fake', 'fake', true, false);
	}
	
	function registerQuiz(DBUser $dbData) {
		$this->register($dbData, 'fake', 'fake', true, true);
	}
	
	function register(DBUser $dbData, $paymentId, $payerID, $free, $quiz) {
		try {
			$this->registerUserIntoDB ( $dbData );
			$this->logInfo("User Registered into DB -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork); 
		}  catch ( Exception $e ) {
			$this->logout();
			$this->logError("Unable to register User into DB -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
			throw new Exception($e->getMessage(), 800);
		}
		try {
//  			$this->registerUserIntoFusionTable ( $dbData );
 			$this->logInfo("User Registered into FUSION Table -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
		} catch ( Exception $e ) {
			$this->logout();
			$this->deleteUserFromDB($dbData);
			$this->logError("Unable to register User into FUSIOn Table -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
			throw new Exception($e->getMessage(), 801);
		}
		if (!$free) {
			try {
				$this->executePayment($paymentId, $payerID);
				$this->logInfo("Payment executed for User -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
			}  catch ( Exception $e ) {
				$this->logout();
				$this->deleteUserFromDB($dbData);
				$this->deleteUserFromFusionTable($dbData);
				$this->logError("Unable to execute Payment for User -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
				throw new Exception($e->getMessage(), 802);
			}
		} elseif ($quiz) {
			$this->logInfo("Quiz counter incremented for User registration -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
			$this->incrementQuizCounter(QUIZ_ID);
		}
// 		$this->incrementMembers();
		$tot_usres = $this->updateMembersCount();
		$this->logInfo("Registered new User -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork . " Total Users: " . $tot_usres);
		$this->sendEmail("Administrator OMSC", "administrator@omsc.com", "Registered new User -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork . " Total Users: " . $tot_usres);
	}

	function delete(DBUser $dbData) {
		$this->deleteUserFromDB($dbData);
		$this->logInfo("Deleted User from DB -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
		try {
//  			$this->deleteUserFromFusionTable($dbData);
 			$this->logInfo("Deleted User FUSION Table -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
			$this->logout();
		} catch ( Exception $e ) {
			$this->registerUserIntoDB($dbData);
			throw new Exception($e->getMessage(), 803);
		}
// 		$this->decrementMembers();
		$tot_usres = $this->updateMembersCount();
		$this->logInfo("Deleted User -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork . " Total Users: " . $tot_usres);
		$this->sendEmail("Administrator OMSC", "administrator@omsc.com", "Deleted new User -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork . "Total Users: " . $tot_usres);
	}
	
	function update(DBUser $dbData) {
		$oldUser = $this->search($dbData->socialId, $dbData->socialNetwork);
		$this->updateUserIntoDB($dbData);
		$this->logInfo("Updated User Info into DB -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
		try {
//  			$this->updateUserIntoFusionTable($dbData);
 			$this->logInfo("Updated User Info into FUSION Table -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
		} catch ( Exception $e ) {
			$this->updateUserIntoDB($oldUser);
			throw new Exception($e->getMessage(), 804);
		}
		$this->logInfo("Updated User Info -> ID: " . $dbData->socialId . " Name: " . $dbData->name . " SN: " . $dbData->socialNetwork);
	}
	
	function checkQuizSolution($quizId, $givenSolution) {
		$model = new DBModel();
		$result = $model->getQuizData($quizId);
		if ($result->solution === $givenSolution) {
			if ($result->counter < $result->threshold) {
				$this->logInfo("Quiz try OK for QUIZ_ID: " . $quizId . " and SOLUTION: " . $givenSolution);
				return true;
			} else {
				$this->logInfo("Limit for free quiz subscription: (" . $result->threshold . ") reached");
				throw new Exception('Limit for free quiz subscription (' . $result->threshold . ') reached', 901);
			}
		} else {
			$this->logInfo("Quiz try NOT OK for QUIZ_ID: " . $quizId . " and SOLUTION: " . $givenSolution);
			throw new Exception('Incorrect Solution ' . $givenSolution, 900);
		}
		return false;
	}
	
	/**
	 * PAYPAL CONTROLS 
	 */
	function redirectToPayPal() {
		$payPalUrl = $this->getPayPalUrl();
// 		echo '<script type="text/javascript">window.location.replace("' . $payPalUrl . '");';
		header("Location: " . $payPalUrl);
		die();
	}
	
	function getPayPalUrl() {
		$model = new PayPalModel();
		return $model->createPaymentUrl();
	}
	
	function executePayment($paymentId, $payerID) {
		$model = new PayPalModel();
		return $model->executePayment($paymentId, $payerID);
// 		$payment = Payment::get ( $paymentId, $model->apiContext );
		
// 		$execution = new PaymentExecution ();
// 		$execution->setPayerId ( $payerID );
		
// 		try {
// 			$result = $payment->execute ( $execution, $model->apiContext );
// 			try {
// 				$payment = Payment::get ( $paymentId, $model->apiContext );
// 			} catch ( Exception $ex ) {
// 				throw new Exception($ex->getMessage(), 300);
// 			}
// 		} catch ( Exception $ex ) {
// 			throw new Exception($ex->getMessage(), 300);
// 		}
		
// 		return $payment;
		
	}
	
	
	/**
	 * DB CONTROLS
	 */
	function updateMembersCount() {
		$model = new DBModel ();
		$total_users = $model->countUsers();
		$myfile = fopen("members.omsc", "w");
		fwrite($myfile, $total_users);
		fclose($myfile);
		$_SESSION ["total_users"] = $total_users;
		return $total_users;
	}
	
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
		return $total_users;
	}
	
	function isFreeUser($id) {
		$model = new DBModel ();
		$result = $model->isFreeUser($id);
		return $result;
	}
	
	function countMembersFromFile() {
		try {
			$myfile = fopen("members.omsc", "r");
			$result = fgets($myfile);
			fclose($myfile);
		} catch (Exception $ex) {
			throw new Exception ( "Error Count Users", 200 );
		}
		return $result;
	}
	
	function registerUserIntoDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->insertUser ( $dbData );
	}
	
	function deleteUserFromDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->deleteUser($dbData->socialId, $dbData->socialNetwork);
	}
	
	function updateUserIntoDB(DBUser $dbData) {
		$model = new DBModel ();
		$model->updateUser($dbData);
	}
	
	function search($socialId, $sn) {
		$model = new DBModel();
		$result = $model->searchById($socialId, $sn);
		return $result;
	}
	
	function searchByName($name) {
		$this->logInfo("Search By Name: " . $name);
		$model = new DBModel();
		$result = $model->searchByName($name);
		return $result;
	}
	
	function searchByNameAndCoords ($name, $lat, $lng, $ray) {
		$this->logInfo("Search By Name and Coords: " . $name . " " . $lat . " " . $lng . " " . $ray);
		$model = new DBModel();
		$result = $model->searchByNameAndCoords($name, $lat, $lng, $ray);
		return $result;
	}
	
	function searchByNameAndCoordsSpatial ($name, $lat, $lng, $ray) {
		$this->logInfo("Search By Name and Coords: " . $name . " " . $lat . " " . $lng . " " . $ray);
		$model = new DBModel();
		$result = $model->searchByNameAndCoordsSpatial($name, $lat, $lng, $ray);
		return $result;
	}
	
	function searchByCoords ($lat, $lng, $ray) {
		$this->logInfo("Search By Coords: " . $lat . " " . $lng . " " . $ray);
		$model = new DBModel ();
		$result = $model->searchByCoords($lat, $lng, $ray);
		return $result;
	}
	
	function searchByCoordsSpatial ($lat, $lng, $ray) {
		$this->logInfo("Search By Coords: " . $lat . " " . $lng . " " . $ray);
		$model = new DBModel ();
		$result = $model->searchByCoordsSpatial($lat, $lng, $ray);
		return $result;
	}
	
	function incrementQuizCounter($id) {
		$model = new DBModel ();
		$model->incrementQuizCounter($id);
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
	
	
	/**
	 * CAPTCHA CONTROLS
	 */
	function checkIsRobot($recaptcha_response) {
		//$recaptcha = new \ReCaptcha\ReCaptcha(RC_SECRET_KEY);
		$recaptcha = new \ReCaptcha\ReCaptcha(RC_SECRET_KEY, new \ReCaptcha\RequestMethod\Curl());
		$resp = $recaptcha->verify($recaptcha_response, $_SERVER['REMOTE_ADDR']);
// 		echo var_export($resp);
		if ($resp->isSuccess()) {
			return false;
		} else {
			return true;
		}
	}
	
	
	/**
	 * MAIL
	 */
	function sendEmail($name, $email, $message) {
		$subject = "OMSC Form submission";
		$msg = wordwrap($name . " wrote the following:" . "\n\n" . $message, 70, "\r\n");
		$headers = "From:" . $email;
		return mail(WEBMASTER_MAIL, $subject, $msg, $headers);
	}
	
	/**
	 * LOG
	 */
	function logError($message) {
		error_log("Timestamp: " . date('YmdHis') . " " . $message . "\r", 3, "log/error_" . date("Ymd") . ".log");
	}
	
	function logInfo($message) {
		error_log("Timestamp: " . date('YmdHis') . " " . $message . "\r", 3, "log/info_" . date("Ymd") . ".log");
	}
	
	function logSearch($message) {
		error_log(date('YmdHis') . ";" . $message . "\r", 3, "log/search_" . date("Ymd") . ".log");
	}
	
	/*TO DELETE*/
	// 	function setSocialLogRequest () {
	// 		if(isset($_REQUEST['sn'])){
	// 			if ($_SESSION['sn'] !== $_REQUEST['sn']) {
	// 				$this->logout();
	// 			}
	// 			$_SESSION['sn'] = $_REQUEST['sn'];
	// 		}
	
	// 		if (!isset($_SESSION ["sn"])) {
	// 			die("<script>location.href = 'index.php'</script>");
	// 		}
	// 	}
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
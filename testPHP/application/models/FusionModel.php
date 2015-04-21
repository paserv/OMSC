<?php
set_include_path ( get_include_path () . PATH_SEPARATOR . '../../library/google-api-php-client' );
require_once 'src\Google\autoload.php';

include_once '../configuration/FusionConfig.php';
include_once '../dto/DBUserData.php';

class FusionModel {
	
	function getService() {
		$client = new Google_Client ();
		$client->setApplicationName ( "omsc" );
		
		$key = file_get_contents ( FUSION_KEY_FILE );
		$client->setAssertionCredentials ( new Google_Auth_AssertionCredentials (FUSION_SERVICE_ACCOUNT_NAME, array (
				'https://www.googleapis.com/auth/fusiontables' 
		), $key ) );
		$client->setClientId ( FUSION_CLIENT_ID );
		$service = new Google_Service_Fusiontables ( $client );
		return $service;
	}
	
	function insertUser(DBUserData $dbData) {
		$service = $this->getService();
		$insQuery = "INSERT INTO " . FUSION_TABLE_ID . " (id, name, location, description, timestamp) VALUES ( '$dbData->id', '$dbData->name', '$dbData->latitude,$dbData->longitude', '$dbData->description', '$dbData->timestamp')";
		$res = $service->query->sql ($insQuery);
	}
	
	function insertUserFake(DBUserData $dbData) {
		$dbModel = new DBModel();
		$dbModel->insertFakeFusionUser($dbData);
	}
	
}

?>

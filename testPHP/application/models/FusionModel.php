<?php
//set_include_path ( get_include_path () . PATH_SEPARATOR . '../../library/google-php-api' );
require_once '../../library/google-php-api/autoload.php';

require_once '../configuration/FusionConfig.php';
require_once '../dto/SocialUser.php';
require_once '../dto/DBUser.php';

#require_once $_SERVER["DOCUMENT_ROOT"] . '/application/configuration/FusionConfig.php';
#require_once $_SERVER["DOCUMENT_ROOT"] . '/application/dto/SocialUser.php';
#require_once $_SERVER["DOCUMENT_ROOT"] . '/application/dto/DBUser.php';

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
	
	function insertUser(SocialUser $dbData) {
		$tableID = $this->getTableId();
		if (!$tableID) {
			throw new Exception("OMSC is full");
		}
		$service = $this->getService();
		//Insert Address???
		//Insert link to image URL and social page url
		$imgSocial = $this->getImgSocial($dbData->socialNetwork);
		$insQuery = "INSERT INTO " . $tableID . " (socialId, name, avatarUrl, description, socialPageUrl, location, socialNetwork, imgSocial) VALUES ( '$dbData->socialId', '$dbData->name', '$dbData->avatarUrl', '$dbData->description', '$dbData->socialPageUrl', '$dbData->latitude,$dbData->longitude', '$dbData->socialNetwork', '$imgSocial')";
		$res = $service->query->sql ($insQuery);
	}
	
	function getImgSocial($socialNetwork) {
		switch ($socialNetwork) {
			case "FB" :
				return "blu_circle";
				break;
			case "TW" :
				return "ltblu_circle";
				break;
			case "PL" :
				return "red_circle";
				break;
		}
	}
	
	function getTableId() {
		if ($this->countRows(FUSION_TABLE_ID1) < 100000) {
			return FUSION_TABLE_ID1;
		} else if ($this->countRows(FUSION_TABLE_ID2) < 100000) {
			return FUSION_TABLE_ID2;
		} else if ($this->countRows(FUSION_TABLE_ID3) < 100000) {
			return FUSION_TABLE_ID3;
		} else if ($this->countRows(FUSION_TABLE_ID4) < 100000) {
			return FUSION_TABLE_ID4;
		} else if ($this->countRows(FUSION_TABLE_ID5) < 100000) {
			return FUSION_TABLE_ID5;
		}
		return false;
	}
	
	function countRows($tableId) {
		$service = $this->getService();
		$countQuery = "SELECT COUNT () FROM " . $tableId;
		$res = $service->query->sql ($countQuery);
		$result = $res->rows[0];
		return $result[0];
	}
	
	function insertUserFake(DBUSer $dbData) {
		$dbModel = new DBModel();
		$dbModel->insertFakeFusionUser($dbData);
	}
	
}

?>

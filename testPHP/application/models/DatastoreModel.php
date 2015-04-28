<?php
set_include_path ( get_include_path () . PATH_SEPARATOR . '../../library/google-api-php-client' );
require_once 'src\Google\autoload.php';

include_once '../configuration/FusionConfig.php';
include_once '../dto/DBUser.php';

class DatastoreModel {
	function getService() {
		$client = new Google_Client ();
		$client->setApplicationName ( "omsc" );
		
		$key = file_get_contents ( FUSION_KEY_FILE );
		$client->setAssertionCredentials ( new Google_Auth_AssertionCredentials (FUSION_SERVICE_ACCOUNT_NAME, array (
				'https://www.googleapis.com/auth/datastore' 
		), $key ) );
		$client->setClientId ( FUSION_CLIENT_ID );
		$service = new Google_Service_Datastore ( $client );
		return $service;
	}
	function insertUser(DBUser $dbData) {
		$service = $this->getService();
		$service_dataset = $service->datasets;
		$dataset_id = 'test';
		
		try { 
			$req = $this->create_test_request();
			$service_dataset->commit($dataset_id, $req, []);
		} catch (Google_Exception $ex) {
 			syslog(LOG_WARNING, 'Commit to Cloud Datastore exception: ' . $ex->getMessage());
 			echo "There was an issue -- check the logs.";
 			return;
		}
		
		
		
		
	}
	
	function create_test_request() {
		$entity = $this->create_entity();
		$mutation = new Google_Service_Datastore_Mutation();
		$mutation->setUpsert([$entity]);
		$req = new Google_Service_Datastore_CommitRequest();
		$req->setMode('NON_TRANSACTIONAL');
		$req->setMutation($mutation);
		return $req;
	}
	function create_entity() {
		$entity = new Google_Service_Datastore_Entity();
		$entity->setKey($this->createKeyForTestItem());
		$string_prop = new Google_Service_Datastore_Property();
		$string_prop->setStringValue("test field string value");
		$property_map = [];
		$property_map["test"] = $string_prop;
		$entity->setProperties($property_map);
		return $entity;
	}
	
	function createKeyForTestItem() {
		$path = new Google_Service_Datastore_KeyPathElement();
		$path->setKind("test");
		$path->setName("testkeyname");
		$key = new Google_Service_Datastore_Key();
		$key->setPath([$path]);
		return $key;
	}

	
}

?>

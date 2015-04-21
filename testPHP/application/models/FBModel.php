<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../../library/facebook-php-sdk-v4-4.0-dev');
require_once 'autoload.php';

include_once '../configuration/FBconfig.php';
include_once '../dto/SocialUser.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookJavaScriptLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

class FBModel {
	
	function login() {
		FacebookSession::setDefaultApplication (FB_APP_ID, FB_APP_SECRET);
		$helper = new FacebookRedirectLoginHelper (FB_REDIRECT_URL);
		try {
			$session = $helper->getSessionFromRedirect();
		} catch ( FacebookRequestException $ex ) {
			echo $ex;
		} catch (Exception $ex) {
			echo $ex;
		}
		
		if (isset ( $session )) {
			return $session;
		} else {
			$loginUrl = $helper->getLoginUrl ( array (
					'scope' => FB_REQUIRED_SCOPE
			) );
			header ("Location: " . $loginUrl);
		}
		
	}
	
	function getUser() {
		$fbSession = $this->login(); 
		$request = new FacebookRequest ($fbSession, 'GET', '/me');
		$response = $request->execute ();
		// get response
		$graphObject = $response->getGraphObject ();
		$fbid = $graphObject->getProperty('id'); // To Get Facebook ID
		$fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
		$femail = $graphObject->getProperty ('email'); // To Get Facebook email ID
		$user = new SocialUser($fbid, $fbfullname, $femail);
		return $user;
	}
}

?>

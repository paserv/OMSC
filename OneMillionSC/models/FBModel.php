<?php
require_once 'autoload.php';
FB_API_autoload();

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

class FBModel extends AbstractSocialModel {
	
	function getUser() {
		FacebookSession::setDefaultApplication (FB_APP_ID, FB_APP_SECRET);
		$helper = new FacebookRedirectLoginHelper (FB_REDIRECT_URL);
		try {
			$session = $helper->getSessionFromRedirect();
		} catch ( FacebookRequestException $ex ) {
			throw new Exception($ex->getMessage(), 300);
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(), 301);
		}
		
		if (isset ( $session )) {
		$request = new FacebookRequest ($session, 'GET', '/me');
		$response = $request->execute ();
		// get response
		$graphObject = $response->getGraphObject ();
		$fbid = $graphObject->getProperty('id'); // To Get Facebook ID
		$fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
		$femail = $graphObject->getProperty ('email'); // To Get Facebook email ID
		$socialPageUrl = FB_ROOT_URL . $fbid;
		$avatarUrl = FB_GRAPH_URL . $fbid . "/picture";
		$user = new SocialUser($fbid, $fbfullname, $femail, $socialPageUrl, $avatarUrl, FB_ID);
		return $user;
		} else {
			$loginUrl = $helper->getLoginUrl ( array (
					'scope' => FB_REQUIRED_SCOPE
			) );
			return SocialUser::createLoginUrl($loginUrl);
		}
		
	}
	
	function postLink($link, $description) {
		FacebookSession::setDefaultApplication (FB_APP_ID, FB_APP_SECRET);
		$helper = new FacebookRedirectLoginHelper ("http://localhost.com/OMSC/OneMillionSC/testPostWall.php");
		try {
			$session = $helper->getSessionFromRedirect();
		} catch ( FacebookRequestException $ex ) {
			throw new Exception($ex->getMessage(), 300);
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(), 301);
		}
		if (isset ( $session )) {
			try {
				$response = (new FacebookRequest(
						$session, 'POST', '/me/feed', array(
								'link' => $link,
								'message' => $description
						)
				))->execute()->getGraphObject();
				echo "Posted with id: " . $response->getProperty('id');
			} catch(FacebookRequestException $e) {
				echo "Exception occured, code: " . $e->getCode();
				echo " with message: " . $e->getMessage();
			}
		} else {
			$loginUrl = $helper->getLoginUrl ( array (
					'scope' => "publish_actions"
			) );
			echo "<script type='text/javascript'>window.location.href = '" . $loginUrl . "'</script>";
		}
	}
	
	function sendNotification($recipient, $link, $description) {
		FacebookSession::setDefaultApplication (FB_APP_ID, FB_APP_SECRET);
		$app_token = FB_APP_ID . '|' . FB_APP_SECRET;
		$access_token = new AccessToken($app_token);
// 		$session = FacebookSession::newAppSession(FB_APP_ID, FB_APP_SECRET);
 		$session = new FacebookSession($access_token);
// 		$session = FacebookSession::newAppSession(FB_APP_ID, FB_APP_SECRET);
		$request = new FacebookRequest(
				$session,
				'POST',
				'/' . $recipient . '/notifications',
				array (
						'href' => '' . $link . '',
						'template' => '' . $description . '',
				)
		);
		$response = $request->execute();
		$graphObject = $response->getGraphObject();
		echo var_dump($graphObject);
	}
}
?>

<?php
session_start ();

set_include_path(get_include_path() . PATH_SEPARATOR . '../facebook-php-sdk-v4-4.0-dev');
//define ( 'FACEBOOK_SDK_V4_SRC_DIR', '../facebook-php-sdk-v4-4.0-dev\src\Facebook/' );
require_once 'autoload.php';
require '../inscription_pipeline.php';

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

// init app with app id and secret
FacebookSession::setDefaultApplication ( '1629515017282874', 'acb244e348547db2889fb9995d36d3a4' );
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper ( 'http://localhost/testPHP/fb/fb_login.php' );
// $helper = new FacebookJavaScriptLoginHelper();
try {
	$session = $helper->getSessionFromRedirect ();
	// $session = $helper->getSession();
} catch ( FacebookRequestException $ex ) {
	echo $ex;
} catch ( Exception $ex ) {
	echo $ex;
}
// see if we have a session
if (isset ( $session )) {
	// graph api request for user data
	$request = new FacebookRequest ( $session, 'GET', '/me' );
	$response = $request->execute ();
	// get response
	$graphObject = $response->getGraphObject ();
	$fbid = $graphObject->getProperty ( 'id' ); // To Get Facebook ID
	$fbfullname = $graphObject->getProperty ( 'name' ); // To Get Facebook full name
	$femail = $graphObject->getProperty ( 'email' ); // To Get Facebook email ID
	/* ---- Session Variables ----- */
	$_SESSION ['access_token'] = $session->getToken ();
	$_SESSION ['FBID'] = $fbid;
	$_SESSION ['FULLNAME'] = $fbfullname;
	$_SESSION ['EMAIL'] = $femail;
	/* ---- header location after session ---- */
	
	run_pipeline($fbid, $fbfullname, $femail);
	
	header ( "Location: ../test_fb.php" );
} else {
	$loginUrl = $helper->getLoginUrl ( array (
			'scope' => 'public_profile,email' 
	) );
	//echo '<a href="' . $loginUrl . '">Login</a>';
	header ( "Location: " . $loginUrl );
}
?>
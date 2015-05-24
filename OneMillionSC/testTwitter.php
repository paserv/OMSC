<?php
session_start();
require("library/twitter-php-api/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;

if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
	$request_token = [];
	$request_token['oauth_token'] = $_SESSION['oauth_token'];
	$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
	$twitteroauth = new TwitterOAuth('9bdho2YXjpDYRheYAlYeStb3E', 'vXC4WTdPuxVZ8uBmK6I48UOJuWNnSw5AL30uMjKuygI2EEOkvK', $request_token['oauth_token'], $request_token['oauth_token_secret']);
	$access_token = $twitteroauth->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
	$twitteroauth = new TwitterOAuth('9bdho2YXjpDYRheYAlYeStb3E', 'vXC4WTdPuxVZ8uBmK6I48UOJuWNnSw5AL30uMjKuygI2EEOkvK', $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user_info = $twitteroauth->get('account/verify_credentials');
	print_r($user_info);
} else {
	$twitteroauth = new TwitterOAuth('9bdho2YXjpDYRheYAlYeStb3E', 'vXC4WTdPuxVZ8uBmK6I48UOJuWNnSw5AL30uMjKuygI2EEOkvK');
	$request_token = $twitteroauth->oauth('oauth/request_token', array('oauth_callback' =>  'http://localhost.com/OMSC/OneMillionSC/testTwitter.php'));
	
 	$_SESSION['oauth_token'] = $request_token['oauth_token'];
 	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	if($twitteroauth->getLastHttpCode()==200){
		$url = $twitteroauth->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
		header('Location: '. $url);
	} else {
		die('Something wrong happened.');
	}
}

?>
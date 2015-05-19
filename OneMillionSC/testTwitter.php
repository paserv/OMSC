<?php
session_start();
require("library/twitter-php-api/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;

if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
	$twitteroauth = new TwitterOAuth('9bdho2YXjpDYRheYAlYeStb3E', 'vXC4WTdPuxVZ8uBmK6I48UOJuWNnSw5AL30uMjKuygI2EEOkvK', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
	$_SESSION['access_token'] = $access_token;
	$user_info = $twitteroauth->get('account/verify_credentials');
	print_r($user_info);
} else {
	$twitteroauth = new TwitterOAuth('9bdho2YXjpDYRheYAlYeStb3E', 'vXC4WTdPuxVZ8uBmK6I48UOJuWNnSw5AL30uMjKuygI2EEOkvK');
	$request_token = $twitteroauth->getRequestToken('http://localhost.com/twitter_oauth.php');
	
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	if($twitteroauth->http_code==200){
		$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
		header('Location: '. $url);
	} else {
		die('Something wrong happened.');
	}
}

?>
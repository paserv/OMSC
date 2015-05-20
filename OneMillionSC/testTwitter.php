<?php
session_start();
require("library/twitter-php-api/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;

if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
	$twitteroauth = new TwitterOAuth('9bdho2YXjpDYRheYAlYeStb3E', 'vXC4WTdPuxVZ8uBmK6I48UOJuWNnSw5AL30uMjKuygI2EEOkvK', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$twitteroauth->setProxy(array(
			'CURLOPT_PROXY' => '127.0.0.1',
			'CURLOPT_PROXYUSERPWD' => '',
			'CURLOPT_PROXYPORT' => 3128,
	));
	$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
	$_SESSION['access_token'] = $access_token;
	$user_info = $twitteroauth->get('account/verify_credentials');
	print_r($user_info);
} else {
	$twitteroauth = new TwitterOAuth('9bdho2YXjpDYRheYAlYeStb3E', 'vXC4WTdPuxVZ8uBmK6I48UOJuWNnSw5AL30uMjKuygI2EEOkvK');
	$twitteroauth->setProxy(array(
			'CURLOPT_PROXY' => '127.0.0.1',
			'CURLOPT_PROXYUSERPWD' => '',
			'CURLOPT_PROXYPORT' => 3128,
	));
	$request_token = $twitteroauth->oauth2('oauth/request_token', array('oauth_callback' =>  'http://localhost.com/OMSC/OneMillionSC/testTwittew.php'));
	
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
<?php
require_once 'autoload.php';
Twitter_API_autoload();
use Abraham\TwitterOAuth\TwitterOAuth;

class TWModel extends AbstractSocialModel {
	
	function getUser() {
		if(!empty($_REQUEST['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
			if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
				throw new Exception('Something Wrong', 500);
			}
			$twitteroauth = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
			$access_token = $twitteroauth->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
			$twitteroauth = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$user_info = $twitteroauth->get('account/verify_credentials');
			$socialId = $user_info->id;
			$name = $user_info->name;
			$email = 'not available';
			$socialPageUrl = 'https://twitter.com/' . $user_info->screen_name;
			$avatarUrl = $user_info->profile_image_url;
			$user = new SocialUser($socialId, $name, $email, $socialPageUrl, $avatarUrl, TW_ID);
			return $user;
		} else {
			$twitteroauth = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET);
			$request_token = $twitteroauth->oauth('oauth/request_token', array('oauth_callback' =>  TW_REDIRECT_URL));
		
			$_SESSION['oauth_token'] = $request_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
			if($twitteroauth->getLastHttpCode()==200){
				$url = $twitteroauth->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
				return SocialUser::createLoginUrl($url);
			} else {
				throw new Exception('Something Wrong', 500);
			}
		}	
	}
}
?>

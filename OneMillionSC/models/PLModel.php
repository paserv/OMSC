<?php
require_once 'autoload.php';
Google_API_autoload();

class PLModel extends AbstractSocialModel {
	
	function getUser() {
		$client = new Google_Client ();
		$client->setClientId(PL_CLIENT_ID);
		$client->setClientSecret(PL_CLIENT_SECRET);
		$client->setRedirectUri(PL_REDIRECT_URL);
		$client->addScope(PL_REQUIRED_SCOPE1);
		$client->addScope(PL_REQUIRED_SCOPE2);
		
		$service = new Google_Service_Plus ( $client );
		
		if (isset($_GET['code'])) {
			$client->authenticate($_GET['code']);
			$me = $service->people->get("me");
			$socialId = $me['id'];
			$name = $me['displayName'];
			$emails = $me->getEmails();
			$email = $emails[0]['value'];
			$socialPageUrl = $me['url'];
			$avatarUrl = $me['image']['url'];
			$user = new SocialUser($socialId, $name, $email, $socialPageUrl, $avatarUrl, PL_ID);
			return $user;
		} else {
			$authUrl = $client->createAuthUrl();
			return SocialUser::createLoginUrl($authUrl);
		}
	}
}
?>

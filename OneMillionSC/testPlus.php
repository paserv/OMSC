<?php
require_once 'autoload.php';
FusionModel_autoload();

$client_id = '217190497352-m61b2h642osrunjqbfhv7tsl3h7p697u.apps.googleusercontent.com';
$client_secret = 'TBKtpO4s1mNBDsUUwa-O0oKd';
$redirect_uri = 'http://localhost/OMSC/OneMillionSC/testPlus.php';

$client = new Google_Client ();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
$client->addScope("https://www.googleapis.com/auth/userinfo.email");

$service = new Google_Service_Plus ( $client );

if (isset($_REQUEST['logout'])) {
	unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));

}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
	$_SESSION['token'] = $client->getAccessToken();

} else {
	$authUrl = $client->createAuthUrl();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Pruebas</title></head>
<body>
<?php if (isset($authUrl)) {
    print "<a class='login' href='$authUrl'>Login</a>";
} else {
    print "<a class='logout' href='pruebas.php?logout'>Cerrar:</a>";
}

if (isset($_SESSION['access_token'])) {
    $me = $plus->people->get("me");
	
    print "<br>ID: {$me['id']}\n<br>";
    print "Display Name: {$me['displayName']}\n<br>";
    print "Image Url: {$me['image']['url']}\n<br>";
    print "Url: {$me['url']}\n<br>";
    $name3 = $me['name']['givenName'];
    echo "Nombre: $name3 <br>"; //Everything works fine until I try to get the email
    $correo = ($me['emails'][0]['value']);
    echo $correo;
    }
?>
</body>
</html>
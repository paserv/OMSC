<html>
 <head>
  <title>Test PHP</title>
 </head>
 <body>
 
 <?php   
 	session_start();
 	set_include_path(get_include_path() . PATH_SEPARATOR . 'google-api-php-client');
 	require_once 'src\Google\autoload.php';
 	require_once 'src\Google\Service\Fusiontables.php';

 	const CLIENT_ID = '217190497352-qijsqgp3hjl88ir2q3c3nafcp9349tps.apps.googleusercontent.com';
 	const SERVICE_ACCOUNT_NAME = '217190497352-qijsqgp3hjl88ir2q3c3nafcp9349tps@developer.gserviceaccount.com';
 	const KEY_FILE = 'omsc-b489a8583341.p12';
 	
	echo "<h1>Hello World!</h1>";
	
 	$client = new Google_Client();
 	$client->getIo()->setOptions(array(
 			CURLOPT_PROXY => 'http://localhost',
 			CURLOPT_PROXYPORT => 5865
 	));
 	
 	$client->setApplicationName("rising-sector-88808");
 	
 	$key = file_get_contents(KEY_FILE);
 	/**
 	$client->setAssertionCredentials(new Google_Auth_AssertionCredentials(
 			SERVICE_ACCOUNT_NAME,
 			array('https://www.googleapis.com/auth/fusiontables'),
 			$key)
 	);
 	*/
 	
 	$client->setClientId(CLIENT_ID);
 	$service = new Google_Service_Fusiontables($client);
 	
 	$insQuery = "INSERT INTO 1smtYhPcYgrZ5LjH8D6Uz5iTH8qsCu6sPxGO3m9sQ (Name, Link, Location) VALUES ('ASSA', 'http://assa', '55.664503,12.59953')";
 	// $selQuery = "select * from 1P8kJGgBvCYHOHWbPJwf8b8TtykociMAyzWq8Pz4 where rowid = '1'";
 	$res = $service->query->sql($insQuery);
 	
	echo "<h1>Hello World!</h1>";
	?>
 
 </body>
</html>
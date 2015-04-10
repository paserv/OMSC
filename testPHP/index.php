<html>
 <head>
  <title>Test PHP</title>
 </head>
 <body>
 
 <?php   
 	ini_set('include_path', 'C:\\Users\servill7\git\google-api-php-client');
 	require_once 'src\Google\autoload.php';
 
 	echo "<h1>Hello World!</h1>";
 	echo "<h1>Hello World!</h1>";
	$client = new Google_Client();
	echo "<h1>Hello World!</h1>";
	?>
 
 </body>
</html>
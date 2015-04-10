<html>
 <head>
  <title>Test PHP</title>
 </head>
 <body>
 
 <?php   
 	set_include_path(get_include_path() . PATH_SEPARATOR . 'C:\\Users\servill7\git\google-api-php-client');
 	require_once 'src\Google\autoload.php';
 
 	echo "<h1>Hello World!</h1>";
 	echo "<h1>Hello World!</h1>";
	$client = new Google_Client();
	echo "<h1>Hello World!</h1>";
	?>
 
 </body>
</html>

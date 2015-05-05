<html>
 <head>
  <title>Test PHP</title>
 </head>
 <body>
 
 <?php   
 	echo $_SERVER["DOCUMENT_ROOT"];
 	echo "<br>";
 	echo dirname(__FILE__);
 	echo "<br>";
 	echo __DIR__;
 	require_once $_SERVER["DOCUMENT_ROOT"] . '/application/configuration/FBConfig.php';
	?>
 
 </body>
</html>

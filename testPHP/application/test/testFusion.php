 <?php
	include_once '../controllers/Controller.php';
	include_once '../dto/SocialUser.php';
	
	$controller = new Controller();
	$dbUser = new DBUserData ( "122", "Polo", "paserv@gmail.com", '41.22', '12.54', "descrizione", "facebook", "asssa" );
	$controller->registerUserIntoFusionTable($dbUser);

	?>
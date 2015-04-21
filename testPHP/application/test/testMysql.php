 <?php
	include_once '../controllers/Controller.php';
	include_once '../dto/DBUserData.php';
	
	$controller = new Controller();
	$date = new DateTime();
	$dbUser = new DBUserData ( 122, "Polo", "paserv@gmail.com", 41.22, 12.54, "descrizione", "https://www.facebook.com/paolo.servillo.7", "https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/c127.37.466.466/s160x160/251418_2230610774145_4988175_n.jpg?oh=c5c77cdcfa899793a17fc03074122eb9&amp;oe=55A25FB0&amp;__gda__=1440954169_14c7675eef1d9dd567ce121e309130c6", $date->getTimestamp(),"FB" );
	$controller->registerUserIntoDB($dbUser);

	?>
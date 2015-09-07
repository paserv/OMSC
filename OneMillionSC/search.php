<?php session_start(); 
require_once 'autoload.php';
autoload (); 
$controller = new Controller ();
$excep = new CustomException(); 

if (isset ( $_SESSION ["numSearch"] )) {
	$_SESSION ["numSearch"] = $_SESSION ["numSearch"] + 1;
} else {
	$_SESSION ["numSearch"] = 1;
	$numSearch = $_SESSION ["numSearch"];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>One Million Social Club - Home Page</title>
		<link type="text/css" rel="stylesheet" href="public/css/materialize.min.css"  media="screen,projection"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link type="text/css" rel="stylesheet" href="public/css/omsc.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<meta property="og:title" content="OMSC">
		<meta property="og:image" content="http://www.aoapao.com/public/img/find.png">
		<meta property="og:site_name" content="One Million Social Club">
		<meta property="og:description" content="Join One Million Social Club">
		<meta property="og:locale" content="en_UK">
		<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
		<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
		<script type="text/javascript" src="public/js/materialize.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.19&libraries=places&language=en"></script>
		<script type="text/javascript" src="public/js/config.js"></script>
		<script type="text/javascript" src="public/js/search.js"></script>
	</head>

<body>

	<?php 
	if ($controller->isUserLoggedAndRegistered() || $_SESSION ["numSearch"] <= MAX_SEARCH) {
	
		try {
	
			if (isset ( $_REQUEST ['name'] ) && $_REQUEST ['name'] != '' && isset ($_REQUEST ['lat']) && $_REQUEST ['lat'] != '' && isset($_REQUEST ['lng']) && $_REQUEST ['lng'] != '' && isset($_REQUEST ['ray']) && $_REQUEST ['ray'] != '') {
// 				$results = $controller->searchByNameAndCoords ( $_REQUEST ['name'], $_REQUEST ['lat'], $_REQUEST ['lng'], $_REQUEST ['ray'] );
				$results = $controller->searchByNameAndCoordsSpatial ( $_REQUEST ['name'], $_REQUEST ['lat'], $_REQUEST ['lng'], $_REQUEST ['ray'] );
				$controller->logSearch("NC;". $_REQUEST ['name'] . ";" . $_REQUEST ['place'] . ";" . $_REQUEST ['lat'] . ";" . $_REQUEST ['lng'] . ";" . $_REQUEST ['ray']);
			} else if (isset ( $_REQUEST ['name'] ) && $_REQUEST ['name'] != '' ) {
				$results = $controller->searchByName ( $_REQUEST ['name'] );
				$controller->logSearch("N;". $_REQUEST ['name'] . ";;;;");
			}
			else if ( isset ($_REQUEST ['lat']) && $_REQUEST ['lat'] != '' && isset($_REQUEST ['lng']) && $_REQUEST ['lng'] != '' && isset($_REQUEST ['ray']) && $_REQUEST ['ray'] != '') {
// 				$results = $controller->searchByCoords ( $_REQUEST ['lat'], $_REQUEST ['lng'], $_REQUEST ['ray'] );
				$results = $controller->searchByCoordsSpatial ( $_REQUEST ['lat'], $_REQUEST ['lng'], $_REQUEST ['ray']);
				$controller->logSearch("C;;" . $_REQUEST ['place'] . ";" . $_REQUEST ['lat'] . ";" . $_REQUEST ['lng'] . ";" . $_REQUEST ['ray']);
			} else {
				$excep->setError(700, "Search parameters not correct");
			}
	
		} catch ( Exception $ex ) {
			$excep->setError($ex->getCode(), $ex->getMessage());
		}
	
		if (!$excep->existProblem) {
			if ($results !== null) {
				$controller->logInfo("Search results: " . count($results));
				foreach ( $results as $currUser ) {
					echo "<script type='text/javascript'>";
					?>
					markers.push({
				        latitude: "<?php echo $currUser->latitude; ?>",
				        longitude: "<?php echo $currUser->longitude; ?>",
				        name: "<?php echo $currUser->name; ?>",
				        description: "<?php echo $currUser->description; ?>",
				        timestamp: "<?php echo $currUser->timestamp; ?>",
				        socialId: "<?php echo $currUser->socialId; ?>",
				        email: "<?php echo $currUser->email; ?>",
				        socialPageUrl: "<?php echo $currUser->socialPageUrl; ?>",
				        avatarUrl: "<?php echo $currUser->avatarUrl; ?>",
				        socialNetwork: "<?php echo $currUser->socialNetwork; ?>",
					    });
		    <?php
		    echo "</script>";
					}
				if (count($results) == DB_SEARCH_LIMIT ) {
					echo "<script>Materialize.toast('Search is limited to a maximum of " . DB_SEARCH_LIMIT . " people', 5000, 'rounded')</script>";
					$controller->logInfo("Search result more than " . DB_SEARCH_LIMIT);
				}
			} else {
					$excep->setError(700, "No results for this search");
					$controller->logInfo("No results for this search");
				}
		}
	} else {
			$excep->setError(701, "You are a Fox");
		}
	?>

	<?php include 'header.php'; if ($excep->existProblem) { include 'error.php'; } else {	?>
	<div id="map-canvas"></div>
	<?php } include 'footer.php'; ?>
</body>

</html>
<?php session_start(); ?>
<!doctype html>
<head>
<title>One Million Social Club - Search People</title>
<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="public/js/config.js"></script>
<script type="text/javascript" src="public/js/search.js"></script>
<script type="text/javascript"
	src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="public/css/omsc.css" rel="stylesheet">
</head>
<script type="text/javascript">
var markers = [];
<?php
require_once 'autoload.php';
autoload();
$controller = new Controller ();
$excep = new CustomException();

if (isset ( $_SESSION ["numSearch"] )) {
	$_SESSION ["numSearch"] = $_SESSION ["numSearch"] + 1;
} else {
	$_SESSION ["numSearch"] = 1;
	$numSearch = $_SESSION ["numSearch"];
}

if ($controller->isUserLoggedAndRegistered() || $_SESSION ["numSearch"] <= MAX_SEARCH) {
	
	try {
	
		if (isset ( $_GET ['name'] ) && $_GET ['name'] != '' && isset ($_GET ['lat']) && $_GET ['lat'] != '' && isset($_GET ['lng']) && $_GET ['lng'] != '' && isset($_GET ['ray']) && $_GET ['ray'] != '') {
			$results = $controller->searchByNameAndCoords ( $_GET ['name'], $_GET ['lat'], $_GET ['lng'], $_GET ['ray'] );
		} else if (isset ( $_GET ['name'] ) && $_GET ['name'] != '' ) {
				$results = $controller->searchByName ( $_GET ['name'] );
			}
		else if ( isset ($_GET ['lat']) && $_GET ['lat'] != '' && isset($_GET ['lng']) && $_GET ['lng'] != '' && isset($_GET ['ray']) && $_GET ['ray'] != '') {
			$results = $controller->searchByCoords ( $_GET ['lat'], $_GET ['lng'], $_GET ['ray'], $_GET ['ray'] );
		} else {
			$excep->setError(700, "Write here");
			}
		
		} catch ( Exception $ex ) {
			$excep->setError(700, "Write here");
		}
		
	if (!$excep->existProblem) {
		if ($results !== null) {
			foreach ( $results as $currUser ) {
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
				}
			} else {
				$excep->setError(702, "Write here");
			}
	}
} else {
		$excep->setError(700, "Write here");
	}
?>
</script>
<body>
<?php include 'header.php'; ?>
<!-- 
<div id="headerseparator"></div>
 -->
<?php
if ($excep->existProblem) {
	include 'error.php';
} else { ?>
	<div id="map-canvas"></div>
<?php } include 'footer.php'; ?>
</body>
</html>
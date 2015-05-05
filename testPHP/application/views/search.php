<!doctype html>
<head>
<title>One Million Social Club - Search People</title>
<script type="text/javascript" src="../../public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="../../public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="../../public/js/config.js"></script>
<script type="text/javascript" src="../../public/js/search.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<link href="../../public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="../../public/css/omsc.css" rel="stylesheet">
<script type="text/javascript">
var markers = [];
<?php
#require_once '../controllers/Controller.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/application/controllers/Controller.php';
if(isset($_GET['query'])){
	$controller = new Controller();
	$results = $controller->searchByName($_GET['query']);
	if ($results !== null) {
		foreach ($results as $currUser) {
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
		echo "No results found";
		}
	}
?>
</script>

</head>
<body>
<?php include 'header.php'; ?>
	
		<div id="map-canvas" class="corpo"></div>
<?php include 'footer.php'; ?>
</body>
</html>
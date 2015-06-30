<?php session_start(); ?>
<!doctype html>
<head>
<title>One Million Social Club - Title Here</title>
<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="public/js/config.js"></script>
<script type="text/javascript" src="public/js/search.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="public/css/omsc.css" rel="stylesheet">
</head>
<?php
require_once 'autoload.php';
autoload();
$controller = new Controller ();
$excep = new CustomException();
?>

<body>
	<?php include 'header.php'; ?>
	<div id="corpo">
		<?php
		if ($excep->existProblem) {
			include 'error.php';
		} else { 
			$model = new FBModel();
			$model->postLink("http://www.stackoverflow.com", "Stackoverflow");
		?>
	</div>
<?php } include 'footer.php'; ?>
</body>
</html>
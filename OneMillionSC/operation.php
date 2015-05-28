<?php session_start(); ?>
 
<?php
	require_once 'autoload.php';
	autoload();
	
	$excep = new CustomException();
	
	$controller = new Controller();
	$user = $controller->getUserFromSession();
	
	/**
	 * If it comes from paypal store page
	 */
	if (isset ( $_GET ['success'] ) && $_GET ['success'] == 'true') {
		$controller->executePayment($_GET ['paymentId'], $_GET ['PayerID']);
	} elseif (isset ( $_GET ['success'] ) && $_GET ['success'] == 'false') {
		$excep->setError(700, "User Cancelled the Approval");
	} else {
		/**
		 * If it comes from account.php
		 */
		# If "Register" button OR "Modify" button -> save latitude, longitude and about me in SESSION #
		if(isset($_POST['modify_button']) || isset($_POST['register_button'])) {
			$_SESSION["latitude"] = $_POST['latitude'];
			$_SESSION["longitude"] = $_POST['longitude'];
			$_SESSION["aboutme"] = $_POST['aboutme'];
		}
		
		$user = $controller->getUserFromSession();
		
		try {
			if (isset($_POST['delete_button'])) {
				$controller->delete($user);
				$user->latitude = "";
				$user->longitude = "";
			} else if (isset($_POST['modify_button'])) {
				$controller->update($user);
			} else if (isset($_POST['register_button'])){
				$controller->register($user);
			} else if (isset($_POST['logout_button'])){
				$controller->logout();
				$user->latitude = "";
				$user->longitude = "";
			}
		} catch (Exception $e) {
			$excep->setError($e->getCode(), $e->getMessage());
		}
	}
?>

<!doctype html>
<head>
<title>One Million Social Club - Registration</title>
<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="public/js/config.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="public/css/omsc.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

	<div id="headerseparator"></div>
	<br>
	<br>
	<div class="corpo">
	<br>
	<br>
	<br>
	<br>
	<?php
		if ($excep->existProblem) {
			include 'error.php';
		} else {
	?>
	Operation Success!
	<div><a href="index.php<?php echo "?latitude=" . $user->latitude . "&longitude=" . $user->longitude ?>">Come Back Home</a></div>
	</div>
	<?php } ?>
<?php include 'footer.php'; ?>
</body>
</html>
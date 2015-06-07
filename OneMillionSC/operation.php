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
	if (isset ( $_REQUEST ['success'] ) && $_REQUEST ['success'] == 'true') {
		try {
			$controller->register($user, $_REQUEST ['paymentId'], $_REQUEST ['PayerID']);
		} catch (Exception $ex) {
			$excep->setError($ex->getCode(), $ex->getMessage());
		}
	} elseif (isset ( $_REQUEST ['success'] ) && $_REQUEST ['success'] == 'false') {
		$_SESSION["latitude"] = null;
		$_SESSION["longitude"] = null;
		$_SESSION["aboutme"] = null;
		$excep->setError(700, "User Cancelled the Approval");
	} else {
		/**
		 * If it comes from account.php
		 */
		# If "Register" button OR "Modify" button -> save latitude, longitude and about me in SESSION #
		if(isset($_REQUEST['modify_button']) || isset($_REQUEST['register_button'])) {
			$_SESSION["latitude"] = $_REQUEST['latitude'];
			$_SESSION["longitude"] = $_REQUEST['longitude'];
			$_SESSION["aboutme"] = $_REQUEST['aboutme'];
		}
		
		$user = $controller->getUserFromSession();
		
		try {
			if (isset($_REQUEST['delete_button'])) {
				$controller->delete($user);
				$user->latitude = "";
				$user->longitude = "";
			} else if (isset($_REQUEST['modify_button'])) {
				$controller->update($user);
			} else if (isset($_REQUEST['register_button'])){
				if (!IS_PAYPAL_ENABLED) {
					$controller->registerFree($user);
				} elseif ($_SESSION["okquiz"] === true) {
					$_SESSION["okquiz"] = false;
					$controller->registerQuiz($user);
				} else {
					$controller->redirectToPaypal();
				}
			} else if (isset($_REQUEST['logout_button'])){
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
	<div id="corpo">
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
<?php } include 'footer.php'; ?>
</body>
</html>
<?php session_start(); 
require_once 'autoload.php';
autoload (); 
$controller = new Controller ();
$excep = new CustomException(); 

$user = null;
if (isset($_SESSION["latitude"])) {
	$user = $controller->getUserFromSession();
}

/**
 * If it comes from paypal store page
 */
if (isset ( $_REQUEST ['success'] ) && $_REQUEST ['success'] == 'true') {
	try {
		$controller->register($user, $_REQUEST ['paymentId'], $_REQUEST ['PayerID'], false, false);
	} catch (Exception $ex) {
		$excep->setError($ex->getCode(), $ex->getMessage());
	}
} elseif (isset ( $_REQUEST ['success'] ) && $_REQUEST ['success'] == 'false') {
	$_SESSION["latitude"] = null;
	$_SESSION["longitude"] = null;
	$_SESSION["aboutme"] = null;
	$excep->setError(400, "User Cancelled the Approval");
} else {
	/**
	 * If it comes from account.php
	 */
	# If "Register" button OR "Modify" button -> save latitude, longitude and about me in SESSION #
	if(isset($_REQUEST['modify_button']) || isset($_REQUEST['register_button'])) {
		$_SESSION["latitude"] = $_REQUEST['latitude'];
		$_SESSION["longitude"] = $_REQUEST['longitude'];
		if (isset($_REQUEST['aboutme'])) {
			$_SESSION["aboutme"] = $_REQUEST['aboutme'];
		}
	}

	if (isset($_SESSION["latitude"])) {
		$user = $controller->getUserFromSession();
	}
	if ($user !== null) {
		try {
			if (isset($_REQUEST['delete_button'])) {
				$controller->delete($user);
				$user->latitude = "";
				$user->longitude = "";
			} else if (isset($_REQUEST['modify_button'])) {
				$controller->update($user);
			} else if (isset($_REQUEST['register_button'])){
				if (!IS_PAYPAL_ENABLED || $_SESSION ["freeuser"]) {
					$controller->registerFree($user);
				} elseif (isset($_SESSION["okquiz"]) && $_SESSION["okquiz"] === true) {
					$_SESSION["okquiz"] = false;
					$controller->registerQuiz($user);
				} else {
					$controller->redirectToPaypal();
				}
			} elseif (isset($_REQUEST['logout_button'])){
				$controller->logout();
				if (isset($_SESSION["latitude"])) {
					$user->latitude = "";
					$user->longitude = "";
				}
	}
		} catch (Exception $e) {
			$excep->setError($e->getCode(), $e->getMessage());
		}
	} 
	if (isset($_REQUEST['logout_button'])){
		$controller->logout();
		if (isset($_SESSION["latitude"])) {
			$user->latitude = "";
			$user->longitude = "";
		}
	}
	
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>One Million Social Club - Home Page</title>
		<link rel="icon" href="favicon.ico" />
		<link type="text/css" rel="stylesheet" href="public/css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link type="text/css" rel="stylesheet" href="public/css/omsc.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<meta property="og:title" content="OMSC">
		<meta property="og:image" content="http://www.aoapao.com/public/img/ico.png">
		<meta property="og:site_name" content="One Million Social Club">
		<meta property="og:description" content="Join One Million Social Club">
		<meta property="og:locale" content="en_UK">
		<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
		<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
		<script type="text/javascript" src="public/js/materialize.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.19&libraries=places&language=en"></script>
		<script type="text/javascript" src="public/js/config.js"></script>
	</head>

<body>
<?php include_once("analyticstracking.php") ?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<div id="fb-root"></div>
<script>
  (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v2.3&appId=1421469004782445";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
	<?php include 'header.php'; if ($excep->existProblem) { include 'error.php'; } else {	?>
	<div class="container">
		<div class="row">
			<div class="col s12"><h5>Operation Result<i class="mdi-action-settings left small"></i></h5></div>
		</div>
		<div class="card-panel">
			<div class="row">
				<div class="col s12"><h5>Success<i class="material-icons left small">done</i></h5></div>
			</div>
			<div class="row">
				<div class="col s12">
					<?php 
						if (SHARE_ENABLED) {
							if (!isset($_REQUEST['logout_button']) && !isset($_REQUEST['delete_button']) && isset($_SESSION['sn'])) {
								if ($_SESSION['sn'] === 'FB') { ?>
								<p>Share on Facebook <div class="fb-share-button" data-href="https://aoapoa.com/" data-layout="button"></div></p>
								<?php } elseif ($_SESSION['sn'] === 'TW') { ?>
								<p>Tweet this <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://aoapoa.com" data-count="none" data-hashtags="omsc">Tweet</a></p>
								<?php } elseif ($_SESSION['sn'] === 'PL') { ?>
								<p>Share on Google Plus <a href="https://plus.google.com/share?url=http://www.aoapao.com" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="public/img/plus_share2.png" alt="Share on Google+"/></a></p>
								<?php } 
							} 
						} ?>
				</div>
			</div>
		</div>
		<div class="row">
				<div class="col s12">
					<?php if ($user !== null) {?>
						<a class="waves-effect waves-light btn blue darken-4 right" href="index.php<?php echo "?latitude=" . $user->latitude . "&longitude=" . $user->longitude ?>"><i class="material-icons right">backspace</i>Come Back Home</a>
					<?php } else { ?>
						<a class="waves-effect waves-light btn blue darken-4 right" href="index.php"><i class="material-icons right">backspace</i>Come Back Home</a>
					<?php } ?>
				</div>
			</div>
	</div>
	<?php } include 'footer.php'; ?>
</body>

</html>
<?php session_start(); 
require_once 'autoload.php';
autoload (); 
$controller = new Controller ();
$excep = new CustomException(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>One Million Social Club - Home Page</title>
		<link type="text/css" rel="stylesheet" href="public/css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link type="text/css" rel="stylesheet" href="public/css/omsc.css" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
		<script type="text/javascript" src="public/js/locationpicker.jquery.min.js"></script>
	</head>

<body>
	<script type="text/javascript">var coordinate = false;</script>
	<?php 
		if (isset($_REQUEST["sn"])) {
			if (isset($_SESSION ["sn"]) && $_SESSION ["sn"] !== $_REQUEST["sn"]) {
				$controller->logout();
			}
			$_SESSION ["sn"] = $_REQUEST["sn"];
		}
		
		if (!isset($_REQUEST["choose"]) && isset($_SESSION["sn"])) {
			try {
				$currentUser = $controller->getUser ( $_SESSION ["sn"] );
				if ($currentUser->isLogged()) {
					if ($currentUser->isRegistered()) {
						?><script type="text/javascript">
							coordinate = {
				    			coords: {
				    				latitude: <?php echo $currentUser->latitude ?> ,
				    		        longitude: <?php echo $currentUser->longitude ?>,
				    				}
								};
							</script>
						<?php
						} else {
							$paypal_url = $controller->getPayPalUrl();
							}
					} else {
						$loginUrl = $currentUser->loginUrl;
						}
				} catch (Exception $se) {
					$excep->setError($se->getCode(), $se->getMessage());
					}
				}
	?>
	<?php include 'header.php'; ?>
	
	<?php if ($excep->existProblem) { include 'error.php'; } else {	?>
				<?php if (!isset($_SESSION["sn"]) || isset($_REQUEST["choose"])) { ?>
					<div class="container">
						<div class="row">
							<div class="col s12"><h5>Sign in with: <i class="mdi-social-person-add left small"></i></h5></div>
						</div>
						<div class="card-panel">
							<div class="row">
							    <div class="col s4 center"><a href="account.php?sn=FB"><img src="public/img/facebook.png"></a></div>
							    <div class="col s4 center"><a href="account.php?sn=TW"><img src="public/img/twitter.png"></a></div>
							    <div class="col s4 center"><a href="account.php?sn=PL"><img src="public/img/gplus.png"></a></div>
						  	</div>
						  	<div class="row">
							    <div class="col s4 center">Facebook</div>
							    <div class="col s4 center">Twitter</div>
							    <div class="col s4 center">Google Plus</div>
						  	</div>
						</div>
					</div>
					<?php } elseif ($currentUser->isLogged()) { ?>
					<div class="container width90 mb100">
						<div class="row">
							<div class="col s12"><h5>My Profile<i class="material-icons left small">face</i></h5></div>
						</div>
						<form name="coordinateForm" action="operation.php" method="post">
							<div class="card-panel">
								<div class="row">
									<div class="col s12 m12 l6">
										<div class="col s6">
											<img src="<?php echo $currentUser->avatarUrl; ?>" />
										</div>
										<div class="col s6">
											<button style="margin-left:10px" class="btn waves-effect waves-light blue darken-3 right" type="submit" name="logout_button">Logout
						    				<i class="material-icons">undo</i>
						    				</button>
										</div>
										<div class="col s12">
											<div class="input-field">
									          <input disabled placeholder=<?php echo $currentUser->name; ?> id="name" type="text" class="validate">
									          <label for="name">Name</label>
									        </div>
										</div>
										<div class="col s12">
											<div class="input-field">
									          <input disabled placeholder=<?php echo $currentUser->email; ?> id="email" type="text" class="validate">
									          <label for="email">Email</label>
									        </div>
										</div>
										<div class="col s12">
											<div class="input-field">
										         <input name="latitude" id="latitude" type="text" class="validate" required>
										         <label for="latitude">Latitude</label>
										    </div>
										</div>
										<div class="col s12">
											<div class="input-field">
											    <input name="longitude" id="longitude" type="text" class="validate" required>
										        <label for="longitude">Longitude</label>
										    </div>
										</div>
										<div class="col s12">
											<div class="input-field">
											    <?php if ($currentUser->isRegistered()) { ?>
											    <textarea id="aboutme" name="aboutme" class="materialize-textarea" maxlength="160" length="160"><?php echo $currentUser->description; ?></textarea>
											    <?php } else { ?>
											    <textarea id="aboutme" name="aboutme" class="materialize-textarea" maxlength="160" length="160"></textarea>
	            								<?php } ?>
	            								<label for="aboutme">Something about me</label>
										    </div>
										</div>
									</div>
									
									<div class="col s12 m12 l6">
										<div class="col s12">
											<div class="input-field">
										         <input id="address" type="text" class="validate" placeholder=" ">
										         <label class="active" for="address">Find Coordinates by Address</label>
										    </div>
										</div>
										<div class="col s12">
											<label class="active">Pick Your Address</label>
										</div>
										<div class="col s12">
											<div id="map" style="width: 100%; height: 380px;"></div>
										</div>
									</div>
								</div>
							</div>
								<div class="row">
								<?php if ($currentUser->isRegistered()) { ?>
									<div class="col s12 m6 right">
										<button style="margin-left:10px;" class="btn waves-effect waves-light blue darken-3 right" type="submit" name="modify_button">Modify
					    				<i class="material-icons">edit</i>
					  					</button>
					  				</div>
				  					<?php if (DELETE_BTN_ENABLED) { ?>
						  					<div class="col s12 m6 right">
							  					<button style="margin-left:10px;" class="btn waves-effect waves-light blue darken-3 right" type="submit" name="delete_button">Delete
							    				<i class="material-icons">delete</i>
							  					</button>
						  					</div>
					  				<?php }	} elseif (isset($_SESSION["okquiz"]) && $_SESSION["okquiz"] === true) { ?>
							  			<div class="col s12 m6 right">	
							  				<button style="margin-left:10px;" class="btn waves-effect waves-light blue darken-3 right" type="submit" name="register_button">Free Registration
						    				<i class="material-icons">done</i>
						  					</button>
						    			</div>
				  					<?php } else { ?>
					  					<div class="card-panel">
							  				<div class="row">
							  					<div class="col s12 m12 l6 center">
								  					<div class="row">
								  						<div class="col s6 blue-grey lighten-4">Description</div>
								  						<div class="col s6 blue-grey lighten-4">Total Amount</div>
								  					</div>
								  					<div class="row">
								  						<div class="col s6">One Million Social Club Subscription</div>
								  						<div class="col s6"><?php echo PP_PRICE;?> EUR</div>
								  					</div>
							  					</div>
							  					<div class="col s12 m12 l6 center">
								  					<button type="submit" name="register_button" style="background:url(public/img/paypal-button.png) no-repeat;width:180px;height:40px;border: none;">
								  					</button>
							  					</div>
							  				</div>
							  			</div>
				  					<?php } ?>
				  				</div>
							</form>
						</div>
						<?php } else if ($loginUrl !== null) { ?>
						<div class="container">
							<div class="row">
								<div class="col s12"><h5>Social Login<i class="material-icons left small">people</i></h5></div>
							</div>
							<div class="card-panel">
								<div class="row">
									<div class="col s12 center"><img src="public/img/login_ico.png"></div>
									<div class="col s12 center"><a href="<?php echo $loginUrl; ?>"><img src="public/img/login_<?php echo $_SESSION ["sn"]; ?>.png"></a></div>
								</div>
							</div>
						</div>
						<?php } ?>
	<?php } include 'footer.php'; ?>
	<script type="text/javascript" src="public/js/location_choose.js"></script>
</body>

</html>
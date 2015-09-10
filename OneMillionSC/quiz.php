<?php session_start(); 
require_once 'autoload.php';
autoload (); 
$controller = new Controller ();
$excep = new CustomException(); 

$_SESSION["okquiz"] = false;

if (isset ( $_REQUEST ['solution'] )) {
	try {
		$quizok = $controller->checkQuizSolution(QUIZ_ID, $_REQUEST ['solution']);
		switch ($quizok) {
			case "ok":
				$_SESSION["okquiz"] = true;
				break;
			case "notok":
				$incorrectsolution = true;
				break;
			case "limit":
				$quizlimit = true;
				break;
		}
	} catch (Exception $ex) {
		$excep->setError($ex->getCode(), $ex->getMessage());
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
	<?php include 'header.php'; if ($excep->existProblem) { include 'error.php'; } else { if (isset ( $_REQUEST ['solution'] ) && isset ($_SESSION["okquiz"]) && $_SESSION["okquiz"]) { ?>
	<div class="container">
		<div class="row">
			<div class="col s12"><h5>Get Free Subscription<i class="material-icons left small">thumb_up</i></h5></div>
		</div>
		<div class="card-panel">
			<div class="row">
				<div class="col s12"><h5>Sign in with: </h5></div>
			</div>
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
		<?php } elseif ((isset ( $_REQUEST ['solution'] ) && isset ($_SESSION["okquiz"]) && !$_SESSION["okquiz"])) { ?>
		<div class="container">
			<div class="row">
				<div class="col s12"><h5>Quiz result<i class="material-icons left small">error</i></h5></div>
			</div>
			<div class="card-panel">
				<div class="row">
					<?php if ( isset ($incorrectsolution) &&  $incorrectsolution) { ?>
					<div class="col s12"><h5>Wrong Response!</h5></div>
					<?php } elseif (isset ($quizlimit) &&  $quizlimit) { ?>
					<div class="col s12"><h5>Limit for free quiz subscription reached!</h5></div>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<a class="waves-effect waves-light btn blue darken-3 right" href="quiz.php"><i class="material-icons right">backspace</i>Come Back to Quiz</a>
			</div>
		</div>
		<?php } elseif (IS_QUIZ_ENABLED) { ?>
		<div class="container">
		<div class="row">
			<div class="col s12"><h5>Quiz<i class="mdi-communication-live-help left small"></i></h5></div>
		</div>
			<div class="card-panel">
				<div class="row">
					 <div class="col s12">33 trentini entrarono a Trento tutti e 33...</div>
					 <form name="quizForm" action="quiz.php" method="post" class="col s12">
					 	<div class="input-field">
							<input name="solution" id="solution" type="text" class="validate" required>
							<label for="name">Solution</label>
						</div>
						<button class="btn waves-effect waves-light blue darken-3 right" type="submit" name="solution_button" value="solution">Try
							<i class="mdi-content-send right"></i>
						</button>
					</form>
				</div>
			</div>
		</div>
	<?php } } include 'footer.php'; ?>
</body>

</html>
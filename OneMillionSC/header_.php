<?php 
	if (!isset($_SESSION ["total_users"])) { 
		$controller = new Controller(); 
		$total = $controller->countMembers(); 
	}
?>
<div class="navbar-fixed">
	<ul id="dropdown1" class="dropdown-content">
	<?php if (isset($_SESSION ["latitude"]) && $_SESSION ["latitude"] != null) { ?>
	  <li><a href="account_.php?sn=<?php echo $_SESSION ["sn"] ?>">My Account</a></li>
	  <li class="divider"></li>
	  <li><a href="operation.php?logout_button=Logout">Logout</a></li>
	<?php } else if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) {?>
	  <li><a href="account_.php?sn=<?php echo $_SESSION ["sn"] ?>">Register</a></li>
	  <li class="divider"></li>
	  <li><a href="operation.php?logout_button=Logout">Logout</a></li>
	<?php } else {?>
	  <li class="blue-text text-darken-4">Sign In With:</li>
	  <li class="divider"></li>
	  <li><a href="account_.php?sn=FB"><img src="public/img/FB_pic.png" /></a></li>
	  <li><a href="account_.php?sn=TW"><img src="public/img/TW_pic.png"></a></li>
	  <li><a href="account_.php?sn=PL"><img src="public/img/PL_pic.png"></a></li>
	<?php } ?>
	</ul>
	<nav>
		<div class="nav-wrapper blue darken-3">
			<ul class="left hide-on-med-and-down">
				<li><a href="index_.php"><i class="mdi-social-public"></i></a></li>
				<li><a href="sass.html"><i class="mdi-action-search"></i></a></li>
				<li><a href="account_.php?choose=yes"><i class="mdi-social-person-add"></i></a></li>
				<?php if (IS_QUIZ_ENABLED) { ?>
					<li><a href="quiz.php"><i class="mdi-communication-live-help"></i></a></li>
				<?php } ?>
			</ul>
			<ul class="right hide-on-med-and-down">
			<?php if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) { ?>
		  		<li><img class="header-img" src="<?php echo $_SESSION ["avatarUrl"]; ?>" /></li>
			<?php } else { ?>
		  		<li><img class="header-img" src="public/img/anonym_user.png" /></li>
			<?php } ?>
				<li><a class="dropdown-button" href="#" data-activates="dropdown1"><i class="mdi-navigation-more-vert right"></i></a></li>
			</ul>
		</div>
	</nav>
</div>
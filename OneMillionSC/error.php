<div id="error">
	<?php
	$codes = array(
			100 => array('Sorry no results found', 'public/img/login_ico.png'),
			101 => array('Please Sign in for unlimited search', 'public/img/login_ico.png'),
			102 => array('No query', 'public/img/login_ico.png'),
			
			200 => array('Connection to database unaivailable', 'public/img/login_ico.png'),
			201 => array('Impossible to delete User', 'public/img/login_ico.png'),
			202 => array('Impossible check User is registered', 'public/img/login_ico.png'),
			203 => array('Impossible search User', 'public/img/login_ico.png'),
			204 => array('Impossible search by ID', 'public/img/login_ico.png'),
			205 => array('User Already Registered', 'public/img/login_ico.png'),
			206 => array('One Million Users already registered', 'public/img/login_ico.png'),
			207 => array('Error insert user', 'public/img/login_ico.png'),
			208 => array('Error User Not Registered', 'public/img/login_ico.png'),
			209 => array('Error update User', 'public/img/login_ico.png'),
			210 => array('Select count error', 'public/img/login_ico.png'),
	);
	
	if(isset($_SESSION ["error_code"]) && $_SESSION ["error_code"] !== false){
		$error_code = $_SESSION ['error_code'];
		$message = $codes[$error_code][0];
		$icon = $codes[$error_code][1];
		if ($message != false) {
			echo '<div style="margin-top:100px, align="center""><img src="' . $icon . '">' . $message . '</div>';
		} else {
			echo "<br><br><br><br><br><h1>No Code for Error found</h1>";
		}
		
	} else {
		echo "<br><br><br><br><br><h1>No Error to Display</h1>";
	}
	?>	
</div>
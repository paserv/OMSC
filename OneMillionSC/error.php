<div id="error">
	<?php
	$codes = array(
			100 => array('Impossible to delete User', 'public/img/login_ico.png'),
			403 => array('403 Forbidden', 'The server has refused to fulfil your request.'),
			404 => array('404 Not Found', 'The page you requested was not found on this server.'),
			405 => array('405 Method Not Allowed', 'The method specified in the request is not allowed for the specified resource.'),
			408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
			500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
			502 => array('502 Bad Gateway', 'The server received an invalid response while trying to carry out the request.'),
			504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
	);
	
	if(isset($_SESSION ["error_code"]) && $_SESSION ["error_code"] !== false){
		$error_code = $_SESSION ['error_code'];
		$title = $codes[$error_code][0];
		$message = $codes[$error_code][1];
		if ($title != false) {
			echo '<br><br><br><br><br><h1>'.$title.'</h1>
			<p>'.$message.'</p>';
		} else {
			echo "No Code for Error found";
		}
		
	} else {
		echo "No Error to Display";
	}
	?>	
</div>
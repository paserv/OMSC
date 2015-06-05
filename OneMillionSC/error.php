<div id="error">
	<?php
	$codes = array(
			#Search Error#
			100 => array('Sorry no results found', 'public/img/login_ico.png'),
			101 => array('Please Register for unlimited search', 'public/img/login_ico.png'),
			102 => array('No query', 'public/img/login_ico.png'),
			
			#DB Error#
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
			211 => array('Impossible search by Coords', 'public/img/login_ico.png'),
			212 => array('No Result found in search by Coords', 'public/img/login_ico.png'),
			212 => array('No Result found in search by Name And Coords', 'public/img/login_ico.png'),
			213 => array('Select count Home error', 'public/img/login_ico.png'),
			
			#Fusion Error#
			300 => array('Impossible Register User Into Fusion Table', 'public/img/login_ico.png'),
			301 => array('Impossible Delete User From Fusion Table', 'public/img/login_ico.png'),
			302 => array('Impossible Update User From Fusion Table', 'public/img/login_ico.png'),
			
			400 => array('Fusion Tables are full', 'public/img/login_ico.png'),
			
			#FB Error#
	
			#TW Error#
	
			#PayPal Error
			701 => array('User Not Approval...', 'public/img/login_ico.png'),
			
			#SEARCH ERROR
			700 => array('ASSA', 'public/img/login_ico.png'),
			702 => array('NOT FOUND', 'public/img/login_ico.png'),
	);
	
	$publicMessage = "No Error to display";
	$icon = "public/img/login_ico.png";
	if($excep->error_code){
		$publicMessage = "Error Code Not Found";
		if (array_key_exists($excep->error_code, $codes)) {
			$publicMessage = $codes[$excep->error_code][0];
			$icon = $codes[$excep->error_code][1];
			echo '<br><br><br><br><div style="margin-left:30px; align=center"><div><img src="' . $icon . '">' . $publicMessage . '</div><div>' . $excep->private_message . '</div></div>';
		} else {
			echo '<br><br><br><br><div style="margin-left:30px; align=center"><img src="' . $icon . '">' . $publicMessage . '</div>';
		}
		//TODO log private message into DB
		//TODO send mail
	} else {
		echo '<br><br><br><br><div style="margin-left:30px; align=center"><img src="' . $icon . '">' . $publicMessage . '</div>';
	}
	?>	
</div>
<div id="error">
	<?php
	$codes = array(
			#Search Error#
			100 => array('No query', 'public/img/login_ico.png'),
			
			#DB Error#
			200 => array('DB Connection Error', 'public/img/login_ico.png'),
// 			201 => array('Impossible find by Quiz ID', 'public/img/login_ico.png'),
// 			202 => array('Error increment quiz counter', 'public/img/login_ico.png'),
// 			203 => array('Impossible to delete User', 'public/img/login_ico.png'),
// 			204 => array('Impossible check User is registered', 'public/img/login_ico.png'),
// 			205 => array('Impossible search User', 'public/img/login_ico.png'),
// 			206 => array('Impossible search by ID', 'public/img/login_ico.png'),
// 			207 => array('Impossible search by Name and Coords', 'public/img/login_ico.png'),
// 			208 => array('No Result found in search by Name And Coords', 'public/img/login_ico.png'),
// 			209 => array('Error insert user', 'public/img/login_ico.png'),
// 			210 => array('Error Count Users', 'public/img/login_ico.png'),
// 			211 => array('Impossible search by Coords', 'public/img/login_ico.png'),
// 			212 => array('No Result found in search by Coords', 'public/img/login_ico.png'),
// 			213 => array('User Already Registered', 'public/img/login_ico.png'),
// 			214 => array('One Million Users already registered', 'public/img/login_ico.png'),
// 			215 => array('Error insert user', 'public/img/login_ico.png'),
// 			216 => array('Error User Not Registered', 'public/img/login_ico.png'),
// 			217 => array('Error update User', 'public/img/login_ico.png'),
// 			218 => array('Select count error', 'public/img/login_ico.png'),
// 			219 => array('Error insert Fake User', 'public/img/login_ico.png'),
			
			#Fusion Error#
			300 => array('Fusion Table Error', 'public/img/login_ico.png'),
			
			#FB Error#
			500 => array('Facebook Error', 'public/img/login_ico.png'),
	
			#TW Error#
			600 => array('Twitter Error', 'public/img/login_ico.png'),
	
			#PayPal Error
			700 => array('Paypal Error', 'public/img/login_ico.png'),
			
			#SEARCH ERROR
			700 => array('Sorry no results found', 'public/img/login_ico.png'),
			701 => array('Please Register for unlimited search', 'public/img/login_ico.png'),
			
			#Controller Error#
			800 => array('Impossible Register User into DB', 'public/img/login_ico.png'),
			801 => array('Impossible Register User into Fusion Table', 'public/img/login_ico.png'),
			802 => array('Impossible Execute Payment', 'public/img/login_ico.png'),
			803 => array('Impossible Delete User into Fusion Table', 'public/img/login_ico.png'),
			804 => array('Impossible Update User into Fusion Table', 'public/img/login_ico.png'),
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
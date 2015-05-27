<?php
require __DIR__ . '/library/paypal-php-sdk/autoload.php';

use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

$apiContext = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
				'AZ7UfpicExpcHhCBcTHrPZ9YSh__HXuO_eXrwqn1pvCl_BPY5z4GyAVymN6CLOjFWffdGvzDLu-HRrtb',     // ClientID
				'ENha4YyzwWm77DEqOawuERHe3GF3wpjEg6rDsTysTK8jof1Vx54ljMSLpWvjpOnKKs0NnpmDTgGgK8Fx'      // ClientSecret
		)
);

if (isset ( $_GET ['success'] ) && $_GET ['success'] == 'true') {
	$paymentId = $_GET ['paymentId'];
	$payment = Payment::get ( $paymentId, $apiContext );
	
	$execution = new PaymentExecution ();
	$execution->setPayerId ( $_GET ['PayerID'] );
	
	try {
		$result = $payment->execute ( $execution, $apiContext );
		echo ("Executed Payment, Payment" . $payment->getId ());
		var_dump("Execution: " . $execution);
		var_dump("Result: " . $result);
// 		ResultPrinter::printResult ( "Executed Payment", "Payment", $payment->getId (), $execution, $result );
		
		try {
			$payment = Payment::get ( $paymentId, $apiContext );
		} catch ( Exception $ex ) {
			echo ("Get Payment, Payment" . $ex->getMessage());
// 			ResultPrinter::printError ( "Get Payment", "Payment", null, null, $ex );
			exit ( 1 );
		}
	} catch ( Exception $ex ) {
		echo ("Executed Payment, Payment" . $ex->getMessage());
// 		ResultPrinter::printError ( "Executed Payment", "Payment", null, null, $ex );
		exit ( 1 );
	}
	
	echo ("Get Payment, Payment" . $payment->getId ());
	var_dump($payment);
// 	ResultPrinter::printResult ( "Get Payment", "Payment", $payment->getId (), null, $payment );
	
	return $payment;
} else {
	echo ("User Cancelled the Approval");
// 	ResultPrinter::printResult ( "User Cancelled the Approval", null );
	exit ();
}

?>


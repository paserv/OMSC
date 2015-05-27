<?php 
require __DIR__  . '/library/paypal-php-sdk/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

$apiContext = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
				'AZ7UfpicExpcHhCBcTHrPZ9YSh__HXuO_eXrwqn1pvCl_BPY5z4GyAVymN6CLOjFWffdGvzDLu-HRrtb',     // ClientID
				'ENha4YyzwWm77DEqOawuERHe3GF3wpjEg6rDsTysTK8jof1Vx54ljMSLpWvjpOnKKs0NnpmDTgGgK8Fx'      // ClientSecret
		)
);

$payer = new Payer();
$payer->setPaymentMethod("paypal");

$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')->setCurrency('USD')->setQuantity(1)->setSku("123123")->setPrice(7.5);

$item2 = new Item();
$item2->setName('Granola bars')->setCurrency('USD')->setQuantity(5)->setSku("321321")->setPrice(2);

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

$details = new Details();
$details->setShipping(1.2)->setTax(1.3)->setSubtotal(17.50);

$amount = new Amount();
$amount->setCurrency("USD")->setTotal(20)->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)->setItemList($itemList)->setDescription("Payment description")->setInvoiceNumber(uniqid());

$baseUrl = "http://localhost/OMSC/OneMillionSC";
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");

$payment = new Payment();
$payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array($transaction));

$request = clone $payment;

try {
	$payment->create($apiContext);
} catch (Exception $ex) {
	ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
	exit(1);
	}
	
	$approvalUrl = $payment->getApprovalLink();
	
	echo "<a href='$approvalUrl' >$approvalUrl</a>";
	
	return $payment;
?>


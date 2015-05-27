<?php
require_once 'autoload.php';
PayPal_API_autoload();

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PayPalModel {
	private $apiContext;
	
	function __construct () {
		$this->apiContext = PayPalModel::getAPIContext();
	}
	
	
	private static function getAPIContext () {
		$apiContext = new \PayPal\Rest\ApiContext(
				new \PayPal\Auth\OAuthTokenCredential(
						PP_CLIENT_ID,
						PP_CLIENT_SECRET
				)
		);
	}
	
	function createPaymentUrl() {
		
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		
		$item = new Item();
		$item->setName('One Million Social Club')->setCurrency('EUR')->setQuantity(1)->setPrice(1);
		
		$itemList = new ItemList();
		$itemList->setItems(array($item));
		
		$details = new Details();
		$details->setShipping(0)->setTax(0)->setSubtotal(1);
		
		$amount = new Amount();
		$amount->setCurrency("EUR")->setTotal(1)->setDetails($details);
		
		$transaction = new Transaction();
		$transaction->setAmount($amount)->setItemList($itemList)->setDescription("Payment for the 'One Million Social Club'")->setInvoiceNumber(uniqid());
		
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl("$baseUrl?success=true")->setCancelUrl("$baseUrl?success=false");
		
		$payment = new Payment();
		$payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array($transaction));
		
		$request = clone $payment;
		
		try {
			$payment->create($this->apiContext);
		} catch (Exception $ex) {
			throw new Exception("Impossible to create PayPal Payment: " . $ex->getMessage(), 600);
		}
		
		$approvalUrl = $payment->getApprovalLink();
		
		return echo $approvalUrl;
		
	}
}
?>

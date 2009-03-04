<?php
class CreditCard extends ECommPayment{
	public function __construct(){
		$this->paymentName = "Credit Card";
		$this->paymentDetails = "When you use a credit card, you will be charged of %10 more.";
	}

	public function getPaymentForm(){
		return "Credit cards can be processed through PayPal itself";
	}
	
	//This method does the actual payment.
	//For example, it will be called when PayPal IPN arrives, or when the credit card is charged
	public function doPayment(){
		return true;
	}
}
?>
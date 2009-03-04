<?php
class NewPaymentMethod extends ECommPayment{
	public function __construct(){
		$this->paymentName = "New Method";
		$this->paymentDetails = "This is the New Method option<br/>
								 This is another alternative to paypal";
	}

	public function getPaymentForm(){
		return "This payment method is coming soon<br>";
	}
	
	//This method does the actual payment.
	//For example, it will be called when PayPal IPN arrives, or when the credit card is charged
	public function doPayment(){
		return true;
	}
}
?>
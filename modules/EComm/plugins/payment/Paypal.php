<?php
class Paypal extends ECommPayment{
	private $hostName;
	private $accountEmail;
	
	public function __construct(){
		$this->paymentName = "Paypal";
		$this->paymentDetails = "PayPal is the safer, easier way to make an online payment or set up a merchant account.<br/>
								 Paypal is the answer";
		$this->hostName = SiteConfig::get('EComm::PaypalHostName');
		$this->accountEmail = SiteConfig::get('EComm::PaypalBusinessEmailAddress');
	}

	public function getPaymentForm(){
		$form = new Form('payment_form', 'payment_form', '/Store/Payment');
		$paypalHost = 'https://' . $this->hostName . '/cgi-bin/webscr';
		$form->updateAttributes(array( 'action' => $paypalHost));
		$form->updateAttributes(array( 'onSubmit' => "return checkBeforePayment()"));
		
		$tid = @$_SESSION['ECommTID'];
		if ($tid){
			$transaction = Transaction::getTransactionBasedOnTID($tid);
			$sessionId = $transaction->getSession();
			$session = Session::getActiveSession($sessionId);
			$cartItems = CartItem::getAll($sessionId);
			
			//$form->setConstants( array ( 'cmd' => '_cart' ) );
			$form->setConstants( array ( 'cmd' => '_xclick' ) );
			$form->addElement( 'hidden', 'cmd' );
			$form->setConstants( array ( 'upload' => 1 ) );
			$form->addElement( 'hidden', 'upload' );
			
			//Set the ID of the transaction for this order
			$form->setConstants( array ( 'custom' => $tid) );
			$form->addElement( 'hidden', 'custom' );
			
			$form->setConstants( array ( 'currency_code' => SiteConfig::get("EComm::Currency") ) );
			$form->addElement( 'hidden', 'currency_code' );
			
			$form->setConstants( array ( 'business' => $this->accountEmail ) );
			$form->addElement( 'hidden', 'business' );
			
			$form->setConstants( array ( 'return' => "http://" . $_SERVER['HTTP_HOST'] . "/Store/IPN/&action=OrderComplete&tid=$tid" ) );
			$form->addElement( 'hidden', 'return' );
			
			$cartDetails = Module_EComm::getCartDetails($sessionId, $cartItems);
			$form->setConstants( array ( 'amount' => $cartDetails["subTotal"]));
			$form->addElement( 'hidden', 'amount');
			$form->setConstants( array ( 'shipping' => $cartDetails["shipping"]));
			$form->addElement( 'hidden', 'shipping');
			$form->setConstants( array ( 'tax' => $cartDetails["tax"] ) );
			$form->addElement( 'hidden', 'tax');
		}
		$form->addElement('image', 'cart_submit', 'https://www.paypal.com/en_US/i/btn/x-click-but23.gif');
		return $form->display();
	}

	public function doPayment(){
		//This method verifies that the user has paid for what has purchased.
		//First, make sure that the request came from Paypal
		//Second, make sure the payment status is "Completed", which means the funds have been added to the merchant's account.
		//Third, check the amount and currency
		$verifyIPN = $this->verifyIPNRequest();//Log the request, and then make sure it is from paypal
		
		$tid = @$_REQUEST["custom"];
		if (!$tid)//There is no transaction ID here. EXIT
			return false;
		$transaction = Transaction::getTransactionBasedOnTID($tid);
		
		if (!$verifyIPN){
			$transaction->setStatus("Not verified, hacking attempt");
			$transaction->save();
			return false;
		}
		
		if (@$_REQUEST["payment_status"] != "Completed"){
			$transaction->setStatus("Status is: " . @$_REQUEST["payment_status"]);
			$transaction->save();
			return false;
		}
		
		$paymentVerification = Module_EComm::verifyPayment(@$_POST["mc_gross"], @$_POST["mc_currency"], $tid);
		if (!$paymentVerification[0]){
			$st  = "The user has not paid for what they ordered. Amont paid is: " . $paymentVerification[1] . " " . $paymentVerification[2];
			$st .= " Amount required is: " . $paymentVerification[3] . " " . $paymentVerification[4];
			$transaction->setStatus($st);
			$transaction->save();
			return false;
		}
		
		$transaction->setStatus("Complete");
		$transaction->save();
		return true;
	}
	
	public function verifyIPNRequest(){
		//The following function checks to see if the IPN request actually came from Paypal, or it is a hacker trying to bypass the payment
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		//post back to PayPal system to validate
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen("ssl://" . $this->hostName, 443, $errno, $errstr, 15);
		$paypalIPN = new PaypalIPN();
		if (!$fp) {
			$paypalIPN->setMemo("HTTP ERROR. $errstr $errno. There was an issue processing your request. Please contact a system administrator.");
			$result = false;
		} 
		else{
			fputs ($fp, $header . $req);
			$res = "";
			while (!feof($fp)){
				$res .= fgets ($fp);
			}
			fclose ($fp);
			$pieces = preg_split("*\r\n\r\n*", $res);
			
			$paypalIPN->setTransaction(@$_REQUEST["custom"]);
			$paypalIPN->setTxnid(@$_REQUEST["txn_id"]);
			$paypalIPN->setPaymentStatus(@$_REQUEST["payment_status"]);
			if ($pieces[1] == "VERIFIED"){
				$paypalIPN->setIsVerified(1);
				$paypalIPN->setMemo("Verified");
				$result = true;
			}
			else{
				$paypalIPN->setIsVerified(0);
				$paypalIPN->setMemo("The IPN couldn't be verified. This could be a potential hack attempt");
				$result = false;
			}
		}
		$postString = "";
		foreach ($_REQUEST as $key => $value) {
			$postString .= "&$key=$value";
		}
		$paypalIPN->setPostString($postString);
		$paypalIPN->save();
		return $result;
	}
}
?>
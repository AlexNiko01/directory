<?php

class AitPaypalListener
{
	
	public $ssl = true;
	public $enviroment = 'real';
	
	private $data = array();
	private $postUri = '';
	private $responseStatus = '';
	private $response = '';

	private function getHost() {
		if ($this->enviroment == 'sandbox') {
			return 'www.sandbox.paypal.com';
		} else {
			return 'www.paypal.com';
		}
	}
	
	private function request($data) {

		$uri = $this->getHost().'/cgi-bin/webscr';
		$uri = ($this->ssl) ? 'https://'.$uri : 'http://'.$uri;
		
		$ch = curl_init();

		curl_setopt($ch, dirname(__FILE__)."/../certificate/cacert.pem");

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		
		$this->response = curl_exec($ch);
		$this->responseStatus = strval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
		
		if ($this->response === false || $this->responseStatus == '0') {
			$errno = curl_errno($ch);
			$errstr = curl_error($ch);
			throw new AitPaypalException("LISTENER: cURL error: [$errno] $errstr");
		}
	}

	public function handle($data = null) {

		// check if request is POST method
		if ($_SERVER['REQUEST_METHOD'] && $_SERVER['REQUEST_METHOD'] != 'POST') {
			header('Allow: POST', true, 405);
			throw new AitPaypalException("LISTENER: Invalid HTTP request method");
		}

		$encodedData = 'cmd=_notify-validate';
		
		if ($data === null) { 
			// use raw POST data 
			if (!empty($_POST)) {
				$this->data = $_POST;
				$encodedData .= '&'.file_get_contents('php://input');
			} else {
				throw new AitPaypalException("LISTENER: No POST data found.");
			}
		} else { 
			// use provided data array
			$this->data = $data;
			
			foreach ($this->data as $key => $value) {
				$encodedData .= "&$key=".urlencode($value);
			}
		}

		// verify if paypal
		$this->request($encodedData);
		
		if (strpos($this->responseStatus, '200') === false) {
			throw new AitPaypalException("LISTENER: Invalid response status: ".$this->responseStatus);
		}
		
		if (strpos($this->response, "VERIFIED") !== false) {

			do_action('ait-paypal-notification', $this->data);

			$this->handleAction();

		} elseif (strpos($this->response, "INVALID") !== false) {
			throw new AitPaypalException("LISTENER: Invalid response");
		} else {
			throw new AitPaypalException("LISTENER: Unexpected response from PayPal");
		}
	}

	private function getTransactionId() {
		if(isset($this->data['txn_id'])) {
			return $this->data['txn_id'];
		} else if(isset($this->data['transaction[0].id'])) {
			$idx = 0;
			do {
				$transId[] =  $this->data["transaction[$idx].id"];
				$idx++;
			} while(isset($this->data["transaction[$idx].id"]));
			return $transId;
		}
	}

	private function checkStatus()
	{
		if ($this->data['payment_status'] == 'Completed') {
			return true;
		} else {
			// throw new AitPaypalException("LISTENER: Transaction isn't completed");
		}
	}

	private function handleAction()
	{
		$transactionId = $this->getTransactionId();

		if ($this->checkStatus()) {
			$payment = get_option('ait-paypal-transaction-'.$transactionId);
			if ($payment) {

				$payment->status = 'Completed';
				
				// run action
				do_action('ait-paypal-payment-completed', $payment);

				// delete cache
				delete_option('ait-paypal-transaction-'.$transactionId);

			} else {
				throw new AitPaypalException("LISTENER: Transaction not found");
			}
		}
		
	}

}

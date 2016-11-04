<?php

class AitPaypalApiSingle extends AitPaypalApi 
{

	public $payment;



	public function initConnection($payment = null)
	{
		if (!isset($payment)) {
			$payment = $this->payment;
		}
		$params = $payment->getInitParams();
		$this->request('SetExpressCheckout',$params);
	}



	public function doPayment()
	{
		if ($this->isUserApprovedPayment()) {

			$params = $this->payment->getDoParams($this->response);

			// notification URL
			$params['PAYMENTREQUEST_0_NOTIFYURL'] = AIT_PAYPAL_LISTENER_URL;

			$this->request('DoExpressCheckoutPayment',$params);
			// get status
			if (isset($this->response['PAYMENTINFO_0_PAYMENTSTATUS'])) {
				$this->payment->status = $this->response['PAYMENTINFO_0_PAYMENTSTATUS'];
			}
			// get payment id
			if (isset($this->response['PAYMENTINFO_0_TRANSACTIONID'])) {
				$this->payment->id = $this->response['PAYMENTINFO_0_TRANSACTIONID'];
				return $this->payment->id;
			}
		} else {
			throw new AitPaypalException("User canceled the payment");
		}
	}



	public function isUserApprovedPayment()
	{
		$this->getConnectionDetails();
		return (!empty($this->response['PAYERID'])) ? 
			$this->response['PAYERID'] :
			false;
	}



}
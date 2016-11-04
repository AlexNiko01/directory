<?php

class AitPaypalPayment
{

	/** variables returned from paypal */
	public $id, $status;

	/** temporary data **/
	public $data;

	/** variables passed to paypal */
	public $name, $description;

	/** variables passed to paypal */
	public $price, $tax, $currencyCode;


	public function __construct(
		$data,
		$name,
		$description,
		$price,
		$tax,
		$currencyCode
	)
	{
		$this->data = $data;
		$this->name = $name;
		$this->description = $description;
		$this->price = $price;
		$this->tax = $tax;
		$this->currencyCode = $currencyCode;
	}

	

	public function getInitParams()
	{
		$order = array(
			'PAYMENTREQUEST_0_CURRENCYCODE' => $this->currencyCode,
			'PAYMENTREQUEST_0_ITEMAMT' => $this->price,
			'PAYMENTREQUEST_0_TAXAMT' => $this->tax,
			'PAYMENTREQUEST_0_AMT' => $this->price + $this->tax,
		);
		$item = array(
			'L_PAYMENTREQUEST_0_NAME0' => substr($this->name, 0, 127),
			'L_PAYMENTREQUEST_0_DESC0' => substr($this->description, 0, 127),
			'L_PAYMENTREQUEST_0_AMT0' => $this->price,
			'L_PAYMENTREQUEST_0_TAXAMT0' => $this->tax,
			'L_PAYMENTREQUEST_0_QTY0' => '1'
		);
		return $order + $item;
	}



	public function getDoParams($response)
	{
		$order = array(
			'PAYMENTACTION' => 'Sale',
			'TOKEN' => $response['TOKEN'],
			'PAYERID' => $response['PAYERID'],
			'PAYMENTREQUEST_0_CURRENCYCODE' => $response['CURRENCYCODE'],
			'PAYMENTREQUEST_0_ITEMAMT' => $response['PAYMENTREQUEST_0_ITEMAMT'],
			'PAYMENTREQUEST_0_TAXAMT' => $response['PAYMENTREQUEST_0_TAXAMT'],
			'PAYMENTREQUEST_0_AMT' => $response['PAYMENTREQUEST_0_AMT']
		);
		$item = array(
			'L_PAYMENTREQUEST_0_NAME0' => $response['L_PAYMENTREQUEST_0_NAME0'],
			'L_PAYMENTREQUEST_0_DESC0' => $response['L_PAYMENTREQUEST_0_DESC0'],
			'L_PAYMENTREQUEST_0_AMT0' => $response['L_PAYMENTREQUEST_0_AMT0'],
			'L_PAYMENTREQUEST_0_TAXAMT0' => $response['L_PAYMENTREQUEST_0_TAXAMT0'],
			'L_PAYMENTREQUEST_0_QTY0' => '1'
		);
		return $order + $item;
	}



	public function request($data)
	{
		if (empty($data)) {
			$data = $this->data;
		} else {
			$this->data = $data;
		}
		$paypal = AitPaypal::getInstance();
		$paypal->requestPayment($data,$this);
	}



}
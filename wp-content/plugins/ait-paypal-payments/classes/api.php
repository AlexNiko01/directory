<?php

class AitPaypalApi
{

	const URL_ENDPOINT_LIVE = 'https://api-3t.paypal.com/nvp';
	const URL_ENDPOINT_SANDBOX = 'https://api-3t.sandbox.paypal.com/nvp';

	const URL_CHECKOUT_LIVE = 'https://www.paypal.com/webscr?cmd=_express-checkout&token=';
	const URL_CHECKOUT_SANDBOX = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=';

	const VERSION = '109';

	/**
	* Use sandbox of live api
	* @var boolean
	*/
	protected $sandbox;

	/**
	* API Credentials
	* Use the correct credentials for the environment in use (Live / Sandbox)
	* @var array
	*/
	protected $credentials = array(
		'USER' => '',
		'PWD' => '',
		'SIGNATURE' => '',
	);

	/**
	* Response
	* @var array
	*/
	protected $response;

	/**
	* Token
	* @var string
	*/
	public $token;

	/**
	* URL to get when communication was successfully established
	* @var string
	*/
	public $urlReturn;

	/**
	* URL to get when communication was canceled
	* @var string
	*/
	public $urlCancel;

	/**
	* Path to certificate file
	* @var string
	*/
	public $fileCertificate;

	/**
	* Parameters
	* @var array
	*/
	protected $params = array(
		// Basic
		'basic' => array(
			'METHOD',
			'VERSION'
		),
		// URLs
		'url' => array( 
			'RETURNURL',
			'CANCELURL'
		),
		// Credentials
		'credentials' => array(
			'USER',
			'PWD',
			'SIGNATURE'
		),
		// Single payments
		'single' => array(
			// Payment details
			'payment' => array(
				'PAYMENTREQUEST_0_AMT',
				'PAYMENTREQUEST_0_SHIPPINGAMT',
				'PAYMENTREQUEST_0_CURRENCYCODE',
				'PAYMENTREQUEST_0_ITEMAMT'
			),
			// Order details
			'order' => array(
				'L_PAYMENTREQUEST_0_NAME0',
				'L_PAYMENTREQUEST_0_DESC0',
				'L_PAYMENTREQUEST_0_AMT0',
				'L_PAYMENTREQUEST_0_QTY0',
			)
		),
		// Recurring payments
		'recurring' => array(
			'L_BILLINGTYPE0',
			'L_BILLINGAGREEMENTDESCRIPTION0',
			'PAYMENTREQUEST_0_AMT'
		)
	);



	/**
	* Constructor
	*/
	public function __construct($config = false) 
	{
		if ((!$config) || (!is_array($config))) {
			throw new AitPaypalException("Missing or bad PayPal config");
		}
		$this->sandbox = (isset($config['useSandbox'])) ? $config['useSandbox'] : true;
		$this->credentials = ($config['useSandbox']) ? $config['api']['sandbox'] : $config['api']['live'];
		if (!isset($config['certificate'])) {
			throw new AitPaypalException("Missing certificate file");
		}
		$this->fileCertificate = $config['certificate'];
	}



	/**
	* Make API request
	*
	* @param string $method string API method to request
	* @param array $params Additional request parameters
	* @return array / boolean Response array / boolean false on failure
	*/
	public function request($method, $params = array()) 
	{
		// Check if API method is not empty
		if(empty($method)) {
			throw new AitPaypalException('API method is missing');
			return false;
		}

		if(!is_array($params)) {
			throw new AitPaypalException('Bad format of parameters');
			return false;
		}

		// Basic parameters
		$params += array(
			'METHOD' => $method,
			'VERSION' => self::VERSION,
		);

		if(!empty($this->urlReturn)) {
			$params['RETURNURL'] = $this->urlReturn;
		}
		if(!empty($this->urlCancel)) {
			$params['CANCELURL'] = $this->urlCancel;
		}

		// Credentials parameters
		$params += $this->credentials;

		// Building our NVP string
		$request = http_build_query($params);

		$endpoint = ($this->sandbox) ? self::URL_ENDPOINT_SANDBOX : self::URL_ENDPOINT_LIVE;
		
		// certificate file
		if (empty($this->fileCertificate)) {
			throw new AitPaypalException("Certificate file not set");	
		}

		// cURL settings
		$curlOptions = array(
			CURLOPT_URL => $endpoint,
			CURLOPT_VERBOSE => 0,
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_CAINFO => $this->fileCertificate,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $request
		);

		// cURL setup
		$ch = curl_init();
		curl_setopt_array($ch,$curlOptions);

		// Sending our request - $response will hold the API response
		$response = curl_exec($ch);

		// Checking for cURL errors
		if (curl_errno($ch)) {
			
			throw new AitPaypalException(curl_error($ch));
			curl_close($ch);
			return false;

		} else {
			curl_close($ch);
			$responseArray = array();
			
			// Break the NVP string to an array
			parse_str($response,$responseArray);
			
			// Set class properties
			$this->response = $responseArray;
			if (isset($responseArray['TOKEN'])) {
				$this->token = $responseArray['TOKEN'];
			}
			// Check repsonse
			$this->checkResponse();

			return true;
		}
	}



	public function checkResponse()
	{
		if (!isset($this->response)) {
			throw new AitPaypalException("Response not set");
		}
		if (!is_array($this->response)) {
			throw new AitPaypalException("Bad response from paypal");
		}
		if ($this->response['ACK'] != 'Success') {
			if (isset($this->response['L_ERRORCODE0'],$this->response['L_LONGMESSAGE0'])) {
				$code = $this->response['L_ERRORCODE0'];
				$message = $this->response['L_LONGMESSAGE0'];
				throw new AitPaypalException($code.' - '.$message, $code);
			}
		}
	}



	public function redirectUserToLogin()
	{
		$url = ($this->sandbox) ? 
			self::URL_CHECKOUT_SANDBOX . $this->token : 
			self::URL_CHECKOUT_LIVE . $this->token ;
		header('Location: '.$url);
		die();
	}



	public function getConnectionDetails()
	{
		if (!isset($this->token)) {
			throw new AitPaypalException("Token not set");
		}
		$this->request('GetExpressCheckoutDetails', array('TOKEN' => $this->token));
	}



}
<?php

class AitPaypal
{

	private static $instance = null;
	private static $logFileInfo = 'paypal-info.log';
	private static $logFileError = 'paypal-error.log';

	private $api;

	public $options;
	public $payments = array();



	protected function __construct() {}

	public static function getInstance()
	{
		if ( null == self::$instance ) {
			self::$instance = new self;
			// construct
			self::$instance->setOptions();
			// logging
			self::$instance->setLogging();
			// payments
			self::$instance->handleReturn();
		}
		return self::$instance;
	}

	private function setOptions()
	{
		if (!function_exists('aitOptions')) {
			throw new AitPaypalException("PayPal plugin is compatible only with AIT framework 2.0");
		}
		$options = aitOptions()->get('theme');
		if (isset($options->paypal)) {
			$this->options = $options->paypal;
		}

	}

	private function setApi()
	{
		if (empty($this->options)) {
			throw new AitPaypalException("Missing theme options for Paypal");
		}

		$config = array(
			'certificate' => dirname(__FILE__).'/../certificate/cacert.pem',
			'useSandbox' => false,
			'api' => array(
				'sandbox' => array(
					'USER' => $this->options->realApiUsername,
					'PWD' => $this->options->realApiPassword,
					'SIGNATURE' => $this->options->realApiSignature
				),
				'live' => array(
					'USER' => $this->options->realApiUsername,
					'PWD' => $this->options->realApiPassword,
					'SIGNATURE' => $this->options->realApiSignature
				)
			)
		);

		$this->api = new AitPaypalApiSingle($config);

		// Redirections
		$urlReturn = (!empty($this->options->returnPage)) ? get_permalink($this->options->returnPage) : home_url('/');
		$urlCancel = (!empty($this->options->cancelPage)) ? get_permalink($this->options->cancelPage) : home_url('/');
		$this->api->urlReturn = add_query_arg('ait-paypal-action', 'return', $urlReturn);
		$this->api->urlCancel = add_query_arg('ait-paypal-action', 'cancel', $urlCancel);
	}

	private function setPayments()
	{
		if (!empty($this->options->payments)) {

			$payments = $this->options->payments;

			foreach ($payments as $payment) {

				$this->payments[] = new AitPaypalPayment(
					array(), // data
					AitLangs::getCurrentLocaleText($payment->name),
					AitLangs::getCurrentLocaleText($payment->description),
					$payment->amount,
					$payment->tax,
					$payment->currencyCode
				);

			}

		}
	}

	public function handleReturn()
	{
		// Success action
		if (isset($_GET['ait-paypal-action']) && $_GET['ait-paypal-action'] == 'return' && isset($_GET['token'])) {

			// find token in DB
			$token = $_GET['token'];
			$payment = get_transient('ait-paypal-token-'.$token);

			if ($payment) {

				$this->setApi();

				$this->api->token = $token;
				$this->api->payment = $payment;

				try {

					// do payment
					$this->api->doPayment();

					// payment confirmed
					do_action('ait-paypal-payment-confirmed', $this->api->payment);

					// write payment (transaction id) and wait for notification (IPN)
					update_option('ait-paypal-transaction-'.$this->api->payment->id, $this->api->payment);

				} catch (AitPaypalException $e) {
					do_action('ait-paypal-payment-error', $e->getMessage());
					self::error($e);
				}

				delete_transient('ait-paypal-token-'.$token);

			}

		}
		// Cancel action
		if (isset($_GET['ait-paypal-action']) && $_GET['ait-paypal-action'] == 'cancel' && isset($_GET['token'])) {
			// find token in DB
			$token = $_GET['token'];
			delete_transient('ait-paypal-'.$token);
		}
	}

	public function requestPayment($data, $payment)
	{
		try {

			$this->setApi();

			$args = func_get_args();
			if (count($args) < 2) {
				throw new AitPaypalException(__METHOD__." Missing payment attributes");
			}
			if (isset($args[1]) && $args[1] instanceof AitPaypalPayment) {

				$payment = $args[1];
				$this->api->payment = $payment;

			} else {

				if (count($args) < 4) {
					throw new AitPaypalException(__METHOD__." Missing payment attributes");
				}
				$data = $args[0];
				$title = $args[1];
				$description = $args[2];
				$amount = $args[3];
				$tax = (!empty($args[4])) ? $args[4] : 0;
				$currencyCode = (!empty($args[5])) ? $args[5] : 'USD';

				$this->api->payment = new AitPaypalPayment(
					$data,
					$title,
					$description,
					$amount,
					$tax,
					$currencyCode
				);

			}

			$this->api->initConnection();

			// save temporary object to WP DB (one week)
			set_transient('ait-paypal-token-'.$this->api->token, $this->api->payment, 60 * 60 * 24 * 7);

			// redirect to paypal login
			$this->api->redirectUserToLogin();

		} catch (AitPaypalException $e) {
			self::error($e);
		}
	}

	public function requestDiffPayment($data, $oldPayment, $newPayment)
	{
		try {

			if ($oldPayment->currencyCode != $newPayment->currencyCode) {
				throw new AitPaypalException(__METHOD__." Payments must have same currency");
			}

			$this->setApi();

			// title
			// $title = __('Upgrade from', 'ait-paypal-payments') . ' ' . $oldPayment->title . ' ' . __('to', 'ait-paypal-payments') . ' ' . $newPayment->title;
			$title = $newPayment->title;
			// description
			// $description = __('Upgrade') . ': ' . $newPayment->description;
			$description = $newPayment->description;
			// calculate price and create payment
			$amount = floatval($newPayment->price) - floatval($oldPayment->price);

			$this->api->payment = new AitPaypalPayment(
				$data,
				$title,
				$description,
				$amount,
				$newPayment->tax,
				$newPayment->currencyCode
			);

			$this->api->initConnection();

			// save temporary object to WP DB (one week)
			set_transient('ait-paypal-'.$this->api->token, $this->api->payment, 60 * 60 * 24 * 7);

			// redirect to paypal login
			$this->api->redirectUserToLogin();

		} catch (AitPaypalException $e) {
			self::error($e);
		}
	}

	private function setLogging()
	{
		if ($this->options->logging) {

			add_action('ait-paypal-payment-confirmed', function($payment){
				AitPaypal::log($payment, __('PAYMENT CONFIRMED', 'ait-paypal-payments'));
			});

			add_action('ait-paypal-payment-completed', function($payment){
				AitPaypal::log($payment, __('PAYMENT COMPLETED', 'ait-paypal-payments'));
			});

			add_action('ait-paypal-notification', function($payment){
				AitPaypal::log($payment, __('NOTIFICATION', 'ait-paypal-payments'));
			});

		}
	}

	public static function log($message, $title = '')
	{
		$message = print_r($message, true);
		$title = (!empty($title)) ? " - " . $title : "";
		$message = date("Y-m-d H:i:s") . $title . "\n\n" . $message . "\n";

		// file
		$file = WP_CONTENT_DIR."/".self::$logFileInfo;

		error_log($message, 3, $file);
	}

	public static function error($message)
	{
		if ($message instanceof Exception) {
			$message = $message->getMessage();
		} else {
			$message = print_r($message, true);
		}
		$message = date("Y-m-d H:i:s") . " - " . $message . "\n";

		// file
		$file = WP_CONTENT_DIR."/".self::$logFileError;

		error_log($message, 3, $file);
	}

}

class AitPaypalException extends Exception
{
}
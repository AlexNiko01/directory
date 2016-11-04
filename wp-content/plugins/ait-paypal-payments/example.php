<?php

/**
 * EXAMPLE OF USAGE
 */

if (isset($_GET['test-paypal'])) {

	$data = array(
		'membership' => 'business'
	);

	$paypal = AitPaypal::getInstance();

	if (isset($paypal->payments[0])) {
		// first payment from admin
		$paypal->payments[0]->request($data);
	} else {
		// OR manually defined payment
		$paypal->requestPayment($data, 'Payment name', 'Payment description', 0.5, 0, 'EUR');
	}

}

add_action('ait-paypal-payment-confirmed','aitPaypalConfirmed');
function aitPaypalConfirmed($payment) {
	AitPaypal::log($payment, 'PAYMENT CONFIRMED');
}

add_action('ait-paypal-payment-completed','aitPaypalCompleted');
function aitPaypalCompleted($payment) {
	AitPaypal::log($payment, 'PAYMENT COMPLETED');
}

add_action('ait-paypal-notification','aitPaypalNotification');
function aitPaypalNotification($payment) {
	AitPaypal::log($payment, 'NOTIFICATION');
}
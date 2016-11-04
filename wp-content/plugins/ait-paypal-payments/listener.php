<?php

// load Wordpress
$path = explode("wp-content", __FILE__);
if (isset($path[0])) {
	include_once($path[0]."wp-load.php");
	try {
		$paypal = AitPaypal::getInstance();
		$listener = new AitPaypalListener();
		$listener->handle();

	} catch (Exception $e) {
		AitPaypal::error($e);
	}
} else {
	echo "Wordpress not found";
}
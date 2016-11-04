<?php

add_filter('ait-theme-config', 'aitPaypalAdminConfig');
function aitPaypalAdminConfig($config) {

	// titles
	$titles = array();
	for ($i=1; $i <= 4; $i++) {
		$titles[$i] = new NNeonEntity;
		$titles[$i]->value = 'section';
	}
	// $titles[1]->attributes = array('title' => __('Credentials for sandbox enviroment','ait-paypal-payments'));
	$titles[2]->attributes = array('title' => __('Credentials','ait-paypal-payments'));
	$titles[3]->attributes = array('title' => __('Redirections','ait-paypal-payments'));
	$titles[4]->attributes = array('title' => __('Logging','ait-paypal-payments'));

	$config['paypal'] = array(
		'title' => 'PayPal',
		'options' => array(

			// 'enviroment' => array(
			// 	'label' => __('Enviroment','ait-paypal-payments'),
			// 	'type' => 'radio',
			// 	'checked' => 'sandbox',
			// 	'default' => array(
			// 		'sandbox' => __('Use sandbox (virtual) enviroment to testing paypal functionality (developer.paypal.com)','ait-paypal-payments'),
			// 		'real' => __('Use live (real) enviroment','ait-paypal-payments')
			// 	)
			// ),

			// 1 => $titles[1],

			// 'sandboxApiUsername' => array(
			// 	'label' => __('API Username','ait-paypal-payments'),
			// 	'type' => 'code',
			// 	'default' => ''
			// ),
			// 'sandboxApiPassword' => array(
			// 	'label' => __('API Password','ait-paypal-payments'),
			// 	'type' => 'code',
			// 	'default' => ''
			// ),
			// 'sandboxApiSignature' => array(
			// 	'label' => __('API Signature','ait-paypal-payments'),
			// 	'type' => 'code',
			// 	'default' => ''
			// ),

			2 => $titles[2],

			'realApiUsername' => array(
				'label' => __('API Username','ait-paypal-payments'),
				'type' => 'code',
				'default' => ''
			),
			'realApiPassword' => array(
				'label' => __('API Password','ait-paypal-payments'),
				'type' => 'code',
				'default' => ''
			),
			'realApiSignature' => array(
				'label' => __('API Signature','ait-paypal-payments'),
				'type' => 'code',
				'default' => ''
			),

			3 => $titles[3],

			'returnPage' => array(
				'label' => __('After approving of payment','ait-paypal-payments'),
				'type' => 'posts',
				'cpt' => 'page',
				'default' => '',
				'help' => __('Visitor is redirected to selected page after successful payment','ait-paypal-payments')
			),
			'cancelPage' => array(
				'label' => __('After cancelling of payment process','ait-paypal-payments'),
				'type' => 'posts',
				'cpt' => 'page',
				'default' => '',
				'help' => __('Visitor is redirected to selected page after cancelled payment','ait-paypal-payments')
			),

			4 => $titles[4],

			'logging' => array(
				'label' => __('Enable logging','ait-paypal-payments'),
				'type' => 'on-off',
				'default' => false,
				'help' => __('Logs are stored in wp-content/paypal-info.log file','ait-paypal-payments')
			)

			// 'payments' => array(
			// 	'label' => __('Payments','ait-paypal-payments'),
			// 	'type' => 'clone',
			// 	'max' => 50,
			// 	'items' => array(
			// 		'name' => array(
			// 			'label' => __('Name','ait-paypal-payments'),
			// 			'type' => 'text',
			// 			'default' => ''
			// 		),
			// 		'description' => array(
			// 			'label' => __('Description','ait-paypal-payments'),
			// 			'type' => 'text',
			// 			'default' => ''
			// 		),
			// 		'amount' => array(
			// 			'label' => __('Amount','ait-paypal-payments'),
			// 			'type' => 'number',
			// 			'default' => '0'
			// 		),
			// 		'tax' => array(
			// 			'label' => __('Tax','ait-paypal-payments'),
			// 			'type' => 'number',
			// 			'default' => '0'
			// 		),
			// 		'currencyCode' => array(
			// 			'label' => __('Currency','ait-paypal-payments'),
			// 			'type' => 'select',
			// 			'selected' => 'USD',
			// 			'default' => array(
			// 				'AUD' => 'Australian Dollar (AUD)',
			// 				'BRL' => 'Brazilian Real (BRL)',
			// 				'CAD' => 'Canadian Dollar (CAD)',
			// 				'CZK' => 'Czech Koruna (CZK)',
			// 				'DKK' => 'Danish Krone (DKK)',
			// 				'EUR' => 'Euro (EUR)',
			// 				'HKD' => 'Hong Kong Dollar (HKD)',
			// 				'HUF' => 'Hungarian Forint (HUF)',
			// 				'ILS' => 'Israeli New Sheqel (ILS)',
			// 				'JPY' => 'Japanese Yen (JPY)',
			// 				'MYR' => 'Malaysian Ringgit (MYR)',
			// 				'MXN' => 'Mexican Peso (MXN)',
			// 				'NOK' => 'Norwegian Krone (NOK)',
			// 				'NZD' => 'New Zealand Dollar (NZD)',
			// 				'PHP' => 'Philippine Peso (PHP)',
			// 				'PLN' => 'Polish Zloty (PLN)',
			// 				'GBP' => 'Pound Sterling (GBP)',
			// 				'RUB' => 'Russian Ruble (RUB)',
			// 				'SGD' => 'Singapore Dollar (SGD)',
			// 				'SEK' => 'Swedish Krona (SEK)',
			// 				'CHF' => 'Swiss Franc (CHF)',
			// 				'TWD' => 'Taiwan New Dollar (TWD)',
			// 				'THB' => 'Thai Baht (THB)',
			// 				'TRY' => 'Turkish Lira (TRY)',
			// 				'USD' => 'U.S. Dollar (USD)'
			// 			)
			// 		)
			// 	),
			// 	'default' => array(),
			// 	'help' => __('Note about currencies: https://developer.paypal.com/docs/classic/api/currency_codes','ait-paypal-payments')
			// )

		)
	);

	return $config;
}
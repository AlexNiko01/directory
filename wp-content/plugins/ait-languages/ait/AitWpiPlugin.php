<?php

use Hyyan\WPI\Tools\FlashMessages;
use Hyyan\WPI\MessagesInterface;


class AitWpiPlugin extends Hyyan\WPI\Plugin
{

	public static function canActivate()
	{
		return defined('WOOCOMMERCE_VERSION');
	}



	public function activate()
	{
		if(static::canActivate()){
			$this->registerCore();
		}
	}

}
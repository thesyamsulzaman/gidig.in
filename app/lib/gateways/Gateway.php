<?php

namespace App\Lib\Gateways;

use App\Lib\Gateways\StripeGateway;
use App\Lib\Gateways\MidtransGateway;

use Core\Helpers;


class Gateway
{

	public static function build($cart_id)
	{
		if (GATEWAY == 'stripe') {
			return new StripeGateway($cart_id);
		} else if (GATEWAY == 'midtrans') {
			return new MidtransGateway($cart_id);
		}
	}
}

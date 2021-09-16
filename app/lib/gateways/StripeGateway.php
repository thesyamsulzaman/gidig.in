<?php

namespace App\Lib\Gateways;

use App\Lib\Gateways\AbstractGateway;

use \Stripe\Stripe;
use \Stripe\Charge;

class StripeGateway extends AbstractGateway
{

	public function getView()
	{
		return 'card_forms/stripe';
	}

	public function processForm($post)
	{
		$data = [
			'amount' => $this->grandTotal * 100,
			'currency' => 'usd',
			'description' => 'GIDIG.IN Purchase: ' . $this->itemCount . ' items. Cart ID : ' . $this->cart_id,
			'source' => $post['stripeToken']
		];

		$charge = $this->charge($data);
	}

	public function charge($data)
	{
		Stripe::setApiKey(STRIPE_PRIVATE);
		$token = $data['stripeToken'];
		$charge = Charge::create($data);

		return $charge;
	}

	public function handleChargeResponse($charge)
	{
	}
	public function createTransaction($charge)
	{
	}
}

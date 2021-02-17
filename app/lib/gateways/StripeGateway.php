<?php 
namespace App\Lib\Gateways;
use App\Lib\Gateways\AbstractGateway;


class StripeGateway extends AbstractGateway {

	public function getView() {

		return 'card_forms/stripe';

	}

	
	public function processForm($post) {}
	public function charge($data) {}
	public function handleChargeResponse($charge) {}
	public function createTransaction($charge) {}

}


?>

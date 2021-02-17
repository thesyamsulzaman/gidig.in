<?php 

namespace App\Lib\Gateways;

use Core\Helpers;

use App\Models\Carts;


abstract class AbstractGateway {

	public $cart_id, $items, $itemCount = 0, $subTotal = 0, $shippingTotal = 0, $grandTotal = 0; 
	public $charged_success = false, $messageToUser = ""; 

	public function __construct($cart_id) {
		$this->cart_id = $cart_id;
		$this->items = Carts::findAllItemsByCartId($cart_id);

		foreach ($this->items as $item) {
			$this->itemCount += $item->quantity; 
			$this->subTotal += ($item->product_price * $item->quantity);
			$this->shippingTotal += ( $item->product_shipping * $item->quantity);
		}
		$this->grandTotal = $this->subTotal + $this->shippingTotal;
	}

	abstract public function getView();
	abstract public function processForm($post);
	abstract public function charge($data);
	abstract public function handleChargeResponse($charge);
	abstract public function createTransaction($charge);


}






?>
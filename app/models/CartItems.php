<?php 


namespace App\Models;

use Core\Model;
use Core\Helpers;

use App\Models\Carts;
use App\Models\Products;


class CartItems extends Model {

	public $id, $created_at, $updated_at, $cart_id, $product_id, $quantity = 0, $deleted = 0; 
	protected static $_table 			= 'cart_items';
	protected static $_softDelete = true;

	public function beforeSave() {
		$this->timeStamps();
	}

	public static function findByProductIdOrCreate($cart_id, $product_id) {
		$item = self::findFirst([
			'condtions' => "cart_id = ? AND product_id = ?",
			'bind' => [$cart_id, $product_id]
		]);


		if (!$item) {
			$item = new self();
			$item->cart_id = $cart_id;
			$item->product_id = $product_id;
      $item->save();
		}


		return $item;
	}

	public static function addProductToCart($cart_id, $product_id) {
		$product = Products::findById((int) $product_id);
		if ($product) {
			$item = self::findByProductIdOrCreate($cart_id, $product_id);
		}

		return $item;

	}



}






 ?>

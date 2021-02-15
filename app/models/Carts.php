<?php 


namespace App\Models;

use Core\Model;
use Core\Cookie;
use Core\Helpers;



class Carts extends Model {

	public $id, $created_at, $updated_at, $purchased = 0, $deleted = 0; 
	protected static $_table 			= 'carts';
	protected static $_softDelete = true;

	public function beforeSave() {
		$this->timeStamps();
	}

	public static function findCurrentCartOrCreateNew() {
		if (!Cookie::exists(CART_COOKIE_NAME)) {
			$cart = new Carts();
			$cart->save();
		} else {
			$cart_id = Cookie::get(CART_COOKIE_NAME);
			$cart = self::findById((int) $cart_id);
		}


		Cookie::set(CART_COOKIE_NAME, $cart->id, CART_COOKIE_EXPIRY);
		return $cart;


	}



}






 ?>

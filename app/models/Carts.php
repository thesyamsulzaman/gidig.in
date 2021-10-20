<?php


namespace App\Models;

use Core\Model;
use Core\Cookie;
use Core\Helpers;
use Core\Database;



class Carts extends Model
{

	public $id, $created_at, $updated_at, $purchased = 0, $deleted = 0;
	protected static $_table 			= 'carts';
	protected static $_softDelete = true;

	public function beforeSave()
	{
		$this->timeStamps();
	}

	public static function findCurrentCartOrCreateNew()
	{
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

	public static function findAllItemsByCartId($cart_id)
	{
		$sql = '
    	SELECT 
        cart_items.*, 
        products.name AS product_name, 
        product_images.url, 
        products.price AS product_price,
        products.shipping AS product_shipping,
        brands.name AS brand_name
    	FROM 
    		cart_items
    	JOIN
    		products ON products.id = cart_items.product_id
      JOIN
        brands ON brands.id = products.brand_id
    	JOIN
    		product_images ON product_images.product_id = products.id
    	WHERE
    		cart_items.cart_id = ? AND cart_items.deleted = 0 AND product_images.sort = 0
      ORDER BY
      	cart_items.created_at DESC
    ';

		$db = Database::getInstance();
		return $db->query($sql, [(int)$cart_id])->results();
	}
}

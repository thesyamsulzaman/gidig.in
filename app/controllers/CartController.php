<?php

  namespace App\Controllers;

  use Core\Controller;
  use Core\Helpers;
  use Core\Cookie;

  use App\Models\Carts;
  use App\Models\CartItems;

  class CartController extends Controller {

    public function indexAction() {
      $cart_id = Cookie::get(CART_COOKIE_NAME);
      $items = Carts::findAllItemsByCartId((int)$cart_id);
      $this->view->items = $items;
      $this->view->render('carts/index');
    }

    public function addToCartAction($product_id) {
      $cart = Carts::findCurrentCartOrCreateNew();
      $item = CartItems::findByProductIdOrCreate($cart->id, $product_id);
      $item->quantity = $item->quantity + 1;
      $item->save();
    	$this->view->render('carts/addToCart');
    }



  }

?>


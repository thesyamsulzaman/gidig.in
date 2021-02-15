<?php

  namespace App\Controllers;

  use Core\Controller;
  use Core\Helpers;
  use Core\Cookie;

  use App\Models\Carts;
  use App\Models\CartItems;

  class CartController extends Controller {

    public function indexAction() {
      $this->view->render('carts/index');
    }

    public function addToCartAction($product_id) {
      $cart = Carts::findCurrentCartOrCreateNew();
      Helpers::dnd($cart);
      $item = CartItems::findByProductIdOrCreate($cart->id, $product_id);
    	$this->view->render('carts/addToCart');
    }



  }

?>


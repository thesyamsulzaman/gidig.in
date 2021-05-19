<?php

  namespace App\Controllers;

  use Core\Controller;
  use Core\Helpers;
  use Core\Cookie;
  use Core\Router;

  use App\Models\Carts;
  use App\Models\CartItems;
  use App\Models\Transactions;

  use App\Lib\Gateways\Gateway;

  use \Stripe\Stripe;
  use \Stripe\Charge;

  class CartController extends Controller {

    public function indexAction() {
      $cart_id = Cookie::get(CART_COOKIE_NAME);

      $itemCount = 0;
      $subTotal = 0;
      $shippingTotal = 0;

      $items = Carts::findAllItemsByCartId((int)$cart_id);

      foreach ($items as $item) {
        $itemCount += $item->quantity;
        $shippingTotal += ($item->quantity * $item->product_shipping);
        $subTotal += ($item->quantity * $item->product_price);
      }

      $this->view->itemCount = $itemCount;
      $this->view->subTotal = number_format($subTotal, 2);
      $this->view->shippingTotal = number_format($shippingTotal, 2);
      $this->view->grandTotal = number_format(($shippingTotal + $subTotal), 2);

      $this->view->items = $items;
      $this->view->cartId = $cart_id;
      $this->view->render('carts/index');
    }

    public function addToCartAction($product_id) {
      $cart = Carts::findCurrentCartOrCreateNew();
      $item = CartItems::findByProductIdOrCreate($cart->id, $product_id);
      $item->quantity = $item->quantity + 1;
      $item->save();
      Router::redirect("cart");
    	$this->view->render('carts/addToCart');
    }

    public function changeQuantityAction($direction, $item_id) {
      $item = CartItems::findById((int) $item_id);
      if ($direction == 'down') {
        $item->quantity -= 1;
      }
      if ($direction == 'up') {
        $item->quantity += 1;
      }
      if ($item->quantity > 0) {
        $item->save();
      } else {
        $item->delete();
      }
      Router::redirect("cart");
    }

    public function checkoutAction($cart_id) {
      $gateway = Gateway::build((int)$cart_id);
      $transaction = new Transactions();

      if ($this->request->isPost()) {
        $whiteList = [
          'name', 'shipping_address1', 
          'shipping_address2', 'shipping_city',
          'shipping_state', 'shipping_zip'
        ];
        $this->request->csrfCheck();
        $transaction->assign($this->request->get(), $whiteList);
        $transaction->validateShipping();
        $step = $this->request->get('step');
        if ($step == '2') {
          $response = "";
        }
        $response = $gateway->processForm($this->request->get());
      }

      $this->view->formErrors = $transaction->getErrorMessages();
      $this->view->transaction = $transaction;
      $this->view->cartId = $cart_id;
      $this->view->render($gateway->getView());



    }



  }
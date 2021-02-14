<?php

  namespace App\Controllers;
  use Core\Controller;
  use Core\Helpers;

  use App\Models\Products;

  class HomeController extends Controller {

    public function indexAction() {

      $ProductsModel = new Products();
      $products = $ProductsModel->findAll();

      $this->view->products = $products;
      $this->view->render('home/index');
    }

    public function apiAction() {
    	$response = [
    		'success' => true,
    		'data' => [
    			'username' => "DennisReynolds",
    			'token' => 'jg63hvdjg73384952h493g',
    			'address' => 'Paddys Pub'
    		]
    	];
    	$this->jsonResponse($response);
    }


  }

?>

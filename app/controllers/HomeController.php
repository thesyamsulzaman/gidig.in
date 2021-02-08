<?php

  namespace App\Controllers;
  use Core\Controller;
  use Core\Helpers;

  class HomeController extends Controller {
    public function __construct($controller, $action) {
      parent::__construct($controller, $action);
    }

    public function indexAction() {
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

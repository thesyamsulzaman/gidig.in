<?php

namespace App\Controllers;

use Core\Controller;
use Core\Helpers;
use Core\Router;

class RestrictedController extends Controller
{
  public function __construct($controller, $action)
  {
    parent::__construct($controller, $action);
  }

  public function indexAction()
  {
    Router::redirect("user/login");
    $this->view->render('restricted/index');
  }

  public function badTokenAction()
  {
    $this->view->render('restricted/badToken');
  }
}

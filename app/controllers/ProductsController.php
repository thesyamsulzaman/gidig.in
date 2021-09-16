<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Helpers;
use Core\Router;

use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Users;
use App\Models\Brands;

use App\Lib\Utilities\Uploads;


class ProductsController extends Controller {

  public function onConstruct() {
		$this->view->setLayout('default');
    $this->currentUser = Users::currentUser();
  }

	public function indexAction() {
    $this->view->products = Products::findByUserId($this->currentUser->id);
		$this->view->render('products/index');
	}

  public function detailAction($id) {
    $product = Products::findById($id);
    if (!$product) Router::redirect("");

    $this->view->product = $product;
    $this->view->images = $product->getImages();
    $this->view->render('products/detail');
  }

  public function categoryAction($category = "") {
    $this->view->category = $category;
		$this->view->render('products/category');
  }

  
}

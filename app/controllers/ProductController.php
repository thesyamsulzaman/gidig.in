<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Helpers;
use Core\Router;

use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Users;

use App\Lib\Utilities\Uploads;


class ProductController extends Controller {

  public function onConstruct() {
		$this->view->setLayout('admin');
    $this->currentUser = Users::currentUser();
  }

	public function indexAction() {
    $this->view->products = Products::findByUserId($this->currentUser->id);
		$this->view->render('product/index');
	}

  public function categoryAction($category = "") {
    $this->view->category = $category;
		$this->view->render('product/category');
  }

  public function editAction($id) {
    $user = $this->currentUser;
    $product = Products::findByIdAndUserId((int) $id, (int) $user->id);
    $productImages = new ProductImages();

    $images = ProductImages::findByProductId($id);
    if ($this->request->isPost()) {

      $this->request->csrfCheck();

      $product->assign($this->request->get());

      $product->isRentable($product->rentable());
      $product->isFeatured($product->featured());
      $product->user_id = $this->currentUser->id;


      $product->validator();


      $uploads = new Uploads($_FILES['images']);
      $uploads->runValidation();
      $imageErrors = $uploads->validates();

      // $uploads = new Uploads($_FILES['images']);
      // $uploads->runValidation();
      // $imageErrors = $uploads->validates();
      
      // if (is_array($imageErrors)) {
      //   $msg = '';
      //   foreach ($imageErrors as $field => $message) {
      //     $msg .= $message . "";
      //   }
      //   $product->addErrorMessage('images[]',  trim($msg));
      // }



      if ($product->save()) {
        // $productImages::uploadProductImages($product->id, $uploads);
        Router::redirect("product"); 
      }


    }

    $this->view->images = $images;
    $this->view->product = $product;
    $this->view->formAction = PROJECT_ROOT . 'product' . DS . 'edit' . DS . $id;
    $this->view->displayErrors = $product->getErrorMessages();
    $this->view->render('product/edit');


  }

  public function addAction() {

    $product = new Products();
    $productImages = new ProductImages();

    if ($this->request->isPost()) {

      $this->request->csrfCheck();


      $product->assign($this->request->get());

      $product->isRentable($product->rentable());
      $product->isFeatured($product->featured());
      $product->user_id = $this->currentUser->id;


      $product->validator();


      $uploads = new Uploads($_FILES['images']);
      $uploads->runValidation();
      $imageErrors = $uploads->validates();


      if (is_array($imageErrors)) {
        $msg = '';
        foreach ($imageErrors as $field => $message) {
          $msg .= $message . "";
        }
        $product->addErrorMessage('images[]',  trim($msg));
      }


      if ($product->save()) {
        $productImages::uploadProductImages($product->id, $uploads);
        Router::redirect("product"); 
      }


    }

    $this->view->product = $product;
    $this->view->productImages = $productImages;
    $this->view->displayErrors = $product->getErrorMessages();
    $this->view->formAction = PROJECT_ROOT . 'product' . DS . 'add';
    $this->view->render('product/add');
  }


  public function deleteAction() { 
     $response = ["success" => false, 'message' => "Terjadi kesalahan ..."];

     if ($this->request->isPost()) {
       $id = $this->request->getAjax('id');
       $product = Products::findByIdAndUserId((int) $id, $this->currentUser->id);
       if ($product) {
         ProductImages::deleteImages($id);
         $product->delete();
         $response = ["success" => true, "message" => "Berhasi dihapus", "product_id" => $id];
       }
     }

     $this->jsonResponse($response);

  }

  public function toggleFeaturedAction() {
     $response = ["success" => false, 'message' => "Terjadi kesalahan ..."];

     if ($this->request->isPost()) {
       $id = $this->request->getAjax('id');
       $product = Products::findByIdAndUserId((int) $id, $this->currentUser->id);
       if ($product) {
        $product->featured = !$product->featured;
        $product->save();
        $response = [
          "success" => true, 
          "message" => ($product->featured == 1) ? "Berubah menjadi Produk Andalan" : "Berubah menjadi Produk biasa" , 
          "product_id" => $id,
          "is_featured" => ($product->featured == 1) ? true : false, 
        ];
       }
     }

     $this->jsonResponse($response);

  }
  
}







 ?>

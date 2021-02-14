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

  public function deleteImageAction() {
    $response = ["success" => false, 'message' => "Terjadi kesalahan ..."];
    if ($this->request->isPost()) {
      $user = $this->currentUser; 
      $image_id = $this->request->getAjax("id");
      $image = ProductImages::findById($image_id);
      $product = Products::findByIdAndUserId($image->product_id,$user->id);
      if ($product && $image) {
        ProductImages::deleteById($image->id);
        $response = ["success" => true, "message" => "Berhasi dihapus", "image_id" => $image->id];
      }
    }
    return $this->jsonResponse($response);

  }

  public function editAction($id) {
    $user = Users::currentUser();
    $product = Products::findByIdAndUserId((int)$id,$user->id);
    if(!$product){
      Router::redirect('product');
    }
    $brands = Brands::getBrandsForForm($user->id);
    $images = ProductImages::findByProductId($product->id);
    if($this->request->isPost()){
      $this->request->csrfCheck();
      $files = $_FILES['images'];
      $isFiles = $files['tmp_name'][0] != '';
      if($isFiles){
        $uploads = new Uploads($files);
        $uploads->runValidation();
        $imagesErrors = $uploads->validates();
        if(is_array($imagesErrors)){
          $msg = "";
          foreach($imagesErrors as $name => $message){
            $msg .= $message . " ";
          }
          $product->addErrorMessage('images[]',trim($msg));
        }
      }
      $product->assign($this->request->get(),Products::blackList);
      $product->isRentable($product->rentable());
      $product->isFeatured($product->featured());
      $product->user_id = $this->currentUser->id;
      $product->brand_id = $this->request->get('brand');
      $product->save();

      if($product->validationPassed()){
        if($isFiles){
          //upload images
          ProductImages::uploadProductImages($product->id,$uploads);
        }
        $sortOrder = json_decode($_POST['images_sorted']);
        ProductImages::updateSortByProductId($product->id,$sortOrder);
        //redirect
        Router::redirect('product');
      }
    }


    $this->view->images = $images;
    $this->view->brands = $brands;
    $this->view->product = $product;
    $this->view->formAction = PROJECT_ROOT . 'product' . DS . 'edit' . DS . $id;
    $this->view->displayErrors = $product->getErrorMessages();
    $this->view->render('product/edit');


  }

  public function addAction() {

    $product = new Products();
    $productImages = new ProductImages();
    $brands = Brands::getBrandsForForm($this->currentUser->id);

    if ($this->request->isPost()) {

      $this->request->csrfCheck();


      $product->assign($this->request->get());

      $product->isRentable($product->rentable());
      $product->isFeatured($product->featured());
      $product->user_id = $this->currentUser->id;
      $product->brand_id = $this->request->get('brand');


      $product->validator();


      $uploads = new Uploads($_FILES['images']);
      $fileEmpty = $uploads->isEmpty();

      if ($fileEmpty) {
        $msg = "File gambar wajib diupload";
        $product->addErrorMessage("images[]", $msg);

      } else {
        $uploads->runValidation();
        $imageErrors = $uploads->validates();

        if (is_array($imageErrors)) {
          $msg = '';
          foreach ($imageErrors as $field => $message) {
            $msg .= $message . "";
          }
          $product->addErrorMessage('images[]',  trim($msg));
        }

      }

      if ($product->save()) {
        $productImages::uploadProductImages($product->id, $uploads);
        Router::redirect("product"); 
      }
    }

    $this->view->product = $product;
    $this->view->brands = $brands;
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

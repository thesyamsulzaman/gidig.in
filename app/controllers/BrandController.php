<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\Helpers;

use App\Models\Brands;

class BrandController extends Controller {

	public function onConstruct() {
		$this->view->setLayout('admin');
	}

	public function indexAction() {
		$this->view->brands = Brands::find();
		$this->view->render('brand/index');
	}

	public function deleteBrandAction() {
    $response = ["success" => false, 'message' => "Terjadi kesalahan ..."];
    if ($this->request->isPost()) {
      $brand_id = $this->request->getAjax("id");
      $brand = Brands::findById($brand_id);
      if ($brand) {
      	$brand->delete();
        $response = ["success" => true, "message" => "Berhasi dihapus", "brand_id" => $brand->id];
      }
    }
    return $this->jsonResponse($response);
	}

	public function editAction($id) {
		$brand = Brands::findById($id);
		if ($this->request->isPost()) {
      $this->request->csrfCheck();
			$brand->assign($this->request->get());
			$brand->save();
			Router::redirect("brand");
		}
		$this->view->formAction = PROJECT_ROOT . 'brand' . DS . 'edit' . DS . $id;
		$this->view->displayErrors = $brand->getErrorMessages();
		$this->view->brand = $brand;
		$this->view->render('brand/edit');
	}

	public function addAction() {
		$brand = new Brands();

		if ($this->request->isPost()) {
			$brand->assign($this->request->get());
			$brand->validator();

			if($brand->save()) {
				Router::redirect("brand");
			}
		}
		$this->view->formAction = PROJECT_ROOT . 'brand' . DS . 'add';
		$this->view->displayErrors = $brand->getErrorMessages();
		$this->view->brand = $brand;
		$this->view->render('brand/add');
	}

}


 ?>
<?php 
namespace App\Models;

use Core\Model;
use Core\Helpers;

use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;

class Brands extends Model {

	public $id, $name, $created_at, $updated_at, $deleted = 0;
	protected static $_table = "brands";
	protected static $_softDelete = false;

	public function beforeSave() {
		$this->timeStamps();
	}

	public function validator() {
		$this->runValidation(new RequiredValidator($this, [ 'field' => 'name', 'message' => 'Nama Wajib diisi']));
		$this->runValidation(new UniqueValidator($this, [ 'field' => ['name', 'deleted'], 'message' => 'Merek sudah ada']));
	}

	public static function findByUserIdAndId($user_id, $id) {
		return self::findFirst([
			'conditions' => "user_id = ? and id = ?",
			'bind' => [$user_id, $id]
		]);
	}

	public static function getBrandsForForm($user_id) {
		$brands = self::find([
			'columns' => 'id, name',
			'conditions' => "user_id = ?",
			'bind' => [$user_id],
			'order' => 'name DESC'
		]);

		$brandsArray = [ 0 => "* Pilih Brand *"]; 

		foreach ($brands as $brand) {
			$brandsArray[$brand->id] = $brand->name;
		}

		return $brandsArray;


	}



	




}


 ?>
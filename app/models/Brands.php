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

	




}


 ?>
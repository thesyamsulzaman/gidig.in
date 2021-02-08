<?php 
namespace App\Models;

use Core\Model;
use Core\Helpers;
use Core\FormHelpers;

use Core\Validators\RequiredValidator;
use Core\Validators\MatchesValidator;

class Products extends Model {

	public $id, $user_id, $name, $price, $category ,$shipping, $description, $featured = 0,$rentable = 0, $deleted = 0, $created_at, $updated_at;
  const blackList = ['id','deleted'];
  protected static $_table = 'products';
  protected static $_softDelete = true;

	public function __construct() {
		$table = "products";
		parent::__construct($table);
	}

	public static function findByUserId($user_id, $params = []) {
		$conditions = [
			"conditions" => "user_id = ? ",
			"bind" => [(int)$user_id],
			"order" => 'name'
		];
		$params = array_merge($params, $conditions);

		return self::find($params);
	}

	public function validator() {

		$requiredFields = [
			'name' => 'Nama produk wajib diisi',
			'price' => 'Harga produk wajib diisi',
			'shipping' => 'Ongkos wajib diisi',
			'description' => 'Deskripsi tidak boleh kosong',
		];

		foreach ($requiredFields as $field => $message) {
			$this->runValidation(new RequiredValidator($this, ['field' => $field, 'message' => $message]));
		}

		if ($this->rentable === 1) {
			$this->runValidation(new MatchesValidator($this, ['field' => 'category', 'rule' => ['peralatan_camping', 'dokumentasi'], 'message' => "Isinya harus dokumentasi atau Peralatan Camping"]));
		} else {
			$this->runValidation(new MatchesValidator($this, ['field' => 'category', 'rule' => 'konsumsi', 'message' => "Hanya bisa diisi oleh konsumsi"]));
		}

	}

	public static function findByIdAndUserId($id, $user_id) {
		$conditions = [
			'conditions' => 'user_id = ? AND id = ?',
			'bind' => [ (int) $user_id, (int) $id ]
		];
		return self::findFirst($conditions);
	}

  public function beforeSave(){
    $this->timeStamps();
  }


	public function rentable() {
		return $this->rentable === "on";
	}

	public function isRentable($rentable = false) {
		if ($rentable) return $this->rentable = 1;
		else return $this->rentable = 0;
	}


}
?>

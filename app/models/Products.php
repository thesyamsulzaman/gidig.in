<?php

namespace App\Models;

use Core\Model;
use Core\Helpers;
use Core\FormHelpers;

use Core\Validators\RequiredValidator;
use Core\Validators\MatchesValidator;

use App\Models\Brands;
use App\Models\ProductImages;

class Products extends Model
{

	public $id, $user_id, $name, $price, $category, $shipping, $brand_id, $description, $featured = 0, $rentable = 0, $deleted = 0, $created_at, $updated_at;
	const blackList = ['id', 'deleted'];
	protected static $_table = 'products';
	protected static $_softDelete = true;

	public function __construct()
	{
		$table = "products";
		parent::__construct($table);
	}

	public static function findByUserId($user_id, $params = [])
	{
		$conditions = [
			"conditions" => "user_id = ? ",
			"bind" => [(int)$user_id],
			"order" => 'created_at DESC'
		];
		$params = array_merge($params, $conditions);

		return self::find($params);
	}

	public function validator()
	{

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

	public function findAll($category = "")
	{
		$sql = '
    	SELECT 
    		products.*, product_images.url
    	FROM 
    		products
    	JOIN
    		product_images ON products.id = product_images.product_id
    	WHERE
    		products.featured = 1 AND products.deleted = 0 AND product_images.sort = 0
    	GROUP BY
    		product_images.product_id';


		return $this->query($sql)->results();
	}

	public static function findByIdAndUserId($id, $user_id)
	{
		$conditions = [
			'conditions' => 'user_id = ? AND id = ?',
			'bind' => [(int) $user_id, (int) $id]
		];
		return self::findFirst($conditions);
	}

	public function getBrandName()
	{
		if (empty($this->brand_id)) return '';
		$brand = Brands::findFirst([
			'conditions' => "id = ?",
			'bind' => [$this->brand_id]
		]);

		return ($brand) ? $brand->name : '';
	}

	public function getImages()
	{
		return ProductImages::find([
			'conditions' => "product_id = ?",
			'bind' => [$this->id],
			'order' => 'sort ASC'
		]);
	}

	public function beforeSave()
	{
		$this->timeStamps();
	}


	public function rentable()
	{
		return ($this->rentable === "on");
	}

	public function featured()
	{
		return ($this->featured === "on");
	}

	public function isRentable($rentable = false)
	{
		if ($rentable) $this->rentable = 1;
		else $this->rentable = 0;
	}

	public function isFeatured($featured = false)
	{
		if ($featured) $this->featured = 1;
		else;
	}
}

<?php 

namespace App\Models;

use Core\Model;
use Core\Helpers;

class ProductImages extends Model {
	public $id, $url, $product_id, $name, $deleted = 0;
  protected static $_table = "product_images";
  protected static $_softDelete = true;

	public static function uploadProductImages($product_id, $uploads) {

		$lastImage = self::findFirst([
			'conditions' => "product_id = ?",
			"bind" => [(int) $product_id],
			'order' => 'sort DESC'
		]);

		$lastSort = (!$lastImage) ? 0 : $lastImage->sort;

		$path = "uploads". DS ."product_images". DS ."product_" . $product_id . "/";
		foreach ($uploads->getFiles() as $file) {
			$parts = explode(".",$file['name']);
			$ext = end($parts);
			$hash = sha1(time() . $product_id . $file['tmp_name']);

			$uploadName = $hash . '.' . $ext;
			$image = new self();
			$image->url = $path . $uploadName;
			$image->name = $uploadName;
			$image->product_id = $product_id;
			$image->sort = $lastSort;
      if($image->save()){
        $uploads->upload($path, $uploadName, $file['tmp_name']);
        $lastSort++;
      }
		}

	}

	public static function deletebyid($id) {
		$image = self::findbyid($id);
		$sort = $image->sort;
		$afterimages = self::find([
			'conditions' => "product_id = ? and sort > ?",
			'bind' => [$image->product_id, $sort]
		]);

		foreach ($afterimages as $afterimage) {
			$afterimage->sort = $afterimage->sort - 1;
			$afterimage->save();
		}
		unlink(UPLOADS_DIR . 'uploads' . DS . 'product_images' . DS . 'product_' . $image->product_id . DS . $image->name);
		return $image->delete();
	}

	public static function deleteImages($product_id, $unlink = false) {
		$images = self::find([
			'conditions' => "product_id = ?",
			"bind" => [ $product_id ]
		]);

    foreach($images as $image){
      $image->delete();
    }
    
    if($unlink){
      $dirname = UPLOADS_DIR . $bucket . $name. DS .'uploads' . DS . 'product_images' . DS . 'product_' . $product_id;
      array_map('unlink', glob("$dirname/*.*"));
      rmdir($dirname);
    }

	}

	public static function findByProductId($product_id) {
		$images = self::find([
			'conditions' => "product_id = ?",
			'bind' => [(int) $product_id],
			'order' => 'sort',
		]);

		return $images;
	}

	public static function updateSortByProductId($product_id, $sortOrder = []) {
		$images = self::findByProductId($product_id);
		$i = 0;
		foreach ($images as $image) {
			$val = 'image_' . $image->id;
			$sort = (in_array($val, $sortOrder)) ? array_search($val, $sortOrder) : $i;
			$image->sort = $sort;
			$image->save();
			$i++;
		}


	}



}
 ?>

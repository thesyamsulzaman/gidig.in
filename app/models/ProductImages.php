<?php 

namespace App\Models;

use Core\Model;
use Core\Helpers;

class ProductImages extends Model {
	public $id, $url, $product_id, $name, $deleted = 0;
  protected static $_table = "product_images";
  protected static $_softDelete = true;

	public static function uploadProductImages($product_id, $uploads) {
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
      if($image->save()){
        $uploads->upload($path, $uploadName, $file['tmp_name']);
      }
		}

	}

	public static function deleteImage($product_id, $unlink = false) {
		$images = self::find([
			'conditions' => "product_id = ?",
			"bind" => [ $product_id ]
		]);

		foreach ($images as $image) {
			$image->delete();
		}

		if ($unlink) {
			unlink(UPLOADS_DIR . 'uploads' . DS . 'product_images' . DS . 'product_' . $product_id);
		}

	}



}
 ?>

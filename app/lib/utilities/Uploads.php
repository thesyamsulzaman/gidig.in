<?php 

namespace App\Lib\Utilities;

use Core\Helpers;

class Uploads {

  private $_errors = [], 
    $_files = [], 
    $_maxAllowedSize = 5000000,
    $_allowedImageType = [
			IMAGETYPE_PNG, 
			IMAGETYPE_GIF, 
			IMAGETYPE_JPEG,
		];

	public function __construct($files) {
		$this->_files = self::restructureFiles($files);
	}

  public function runValidation() {
  	// if ($this->checkFile()) {
			// $msg = "File gambar wajib diupload";
   //    $this->addErrorMessage("files", $msg);
  	// } else {
	    $this->validateImageType();
	    $this->validateImageSize();
  	// }
  }

  public function upload($bucket, $name , $tmp_location) {
    if (!file_exists($bucket)) {
      mkdir($bucket);
    }
    move_uploaded_file($tmp_location, UPLOADS_DIR . $bucket . $name);
  }

  public function validates() {
		return (empty($this->_errors)) ? true : $this->_errors;
  }

  public function getFiles() {
    return $this->_files;
  }

  public function isEmpty() {
  	return ($this->_files[0]["tmp_name"] == "");
  }

	public function validateImageType() {
		foreach ($this->_files as $file) {
		  $name = $file['name'];
			if (!in_array(exif_imagetype($file['tmp_name']), $this->_allowedImageType)) {
				$msg = "format file ". $name ." tidak diizinkan, gunakan file dengan format gif, png dan jpeg, ";
        $this->addErrorMessage($name, $msg);
			}

		}

	}

  public function validateImageSize() {
    foreach($this->_files as $file) {
			$name = $file['name'];
			if ($file['size'] > $this->_maxAllowedSize) {
        $msg = "File ". $name . " terlalu besar. Besar maksimal adalah 5mb";
        $this->addErrorMessage($name, $msg);
			}
    }
  }

	public function addErrorMessage($name, $message) {
    if (array_key_exists($name, $this->_errors)) {
      $this->_errors[$name] .= $this->_errors[$name] . " " . $message;
    } else {
      $this->_errors[$name] = $message;
    }
	}

	public static function restructureFiles($files) {
		$structured = [];
		foreach ($files['tmp_name'] as $key => $value) {
			$structured[$key] = [
				'tmp_name' => $files['tmp_name'][$key],
				'name' => $files['name'][$key], 
				'size' => $files['size'][$key], 
				'type' => $files['type'][$key], 
				'error' => $files['error'][$key], 
			];
		}

		return $structured;

	}

}
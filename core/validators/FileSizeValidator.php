<?php


namespace Core\Validators;

use Core\Helpers;

class FileSizeValidator extends CustomValidator{
	public function runValidation() {
		$fileSize = $_FILES[$this->field]['size'];
	  return ( $fileSize <= 1000000 );
	}

}

 ?>

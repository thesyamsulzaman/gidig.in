<?php


namespace Core\Validators;

use Core\Validators\CustomValidator;
use Core\Helpers;

class fileExtensionValidator extends CustomValidator {

	public function runValidation() {

		$validExtensions = $this->rule;
		
		$fileName = $this->_model->{$this->field};

		$fileNameArray = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameArray));

		if (!empty($fileName)) {
			if (!in_array($fileExtension, $validExtensions)) {
				return false;
			} else {
				return true;
			}
		}
		return true;

	}



}


?>

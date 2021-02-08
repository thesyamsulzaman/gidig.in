<?php

namespace Core\Validators;
use Core\Validators\CustomValidator;
use Core\Helpers;

class RequiredValidator extends CustomValidator {

	public function runValidation() {
		$value = $this->_model->{$this->field};
		$passes = (!empty($value));
		return $passes;
	}

}

 ?>

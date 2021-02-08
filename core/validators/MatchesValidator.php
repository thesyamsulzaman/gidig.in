<?php 

namespace Core\Validators;

use Core\Validators\CustomValidator;
use Core\Helpers;

class MatchesValidator extends CustomValidator {
	public function runValidation() {
		$value = $this->_model->{$this->field};

    return (is_array($this->rule)) ? in_array($value,$this->rule)  : $value == $this->rule;

	}
}
 ?>

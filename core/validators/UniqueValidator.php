<?php 


namespace Core\Validators;
use Core\Validators\CustomValidator;


class UniqueValidator extends CustomValidator {
	public function runValidation() {
		$field = (is_array($this->field)) ? $this->field[0] : $this->field;
		$value = $this->_model->{$field};

		// field = username
		// value = samparker

		$conditions = ["{$field} = ?"];
		$bind = [$value];
 
		// check updating record
		if (!empty($this->_model->id)) {
			$conditions[] = "id = ?";
			$bind[] = $this->_model->id;
		}
		
		// this allows you to check multiple field
		if (is_array($this->field)) {
			array_unshift($this->field);
			foreach ($this->field as $field => $adds) {
				$conditions[] = "${$adds} = ?";
				$bind[] = $this->_model->{$adds};
			}
		}

		$queryParams = ['conditions' => $conditions, 'bind' => $bind];
		$other = $this->_model->findFirst($queryParams);

		return (!$other);


	}
}


 ?>
<?php 

class Validate {
	private $_passed = false, $_errors = [], $_db = null;

	public function __construct(){
		$this->_db = Database::getInstance();
	}

	public function check($source, $items = [], $csrfCheck = false) {
		$this->_errors = [];

		if ($csrfCheck) {
			if (!isset($source['csrf_token']) && !FormHelpers::checkToken($source['csrf_token'])) {
				$this->addError(['Something has gone wrong', 'csrf_token']);
			}
		}

		foreach ($items as $item => $rules) {

			// sanitize the item key
			$item = FormHelpers::sanitize($item);
			$display = $rules['display'];

			foreach ($rules as $rule_key => $rule_value) {
				$value = FormHelpers::sanitize(trim($source[$item]));

				
				if ($rule_key === 'required' && empty($value)) {
					$this->addError(["{$display} is Required", $item]);
				} else if(!empty($value)){
					switch ($rule_key) {
						case 'min':
							if (strlen($value) < $rule_value) {
								$this->addError(["{$display} must be more than {$rule_value} characters", $item]);
							}
							break;
						case 'max':
							if (strlen($value) > $rule_value) {
								$this->addError(["{$display} cannot be more than {$rule_value} characters", $item]);
							}
							break;
						case 'matches':
							if ($value != $source[$rule_value]) {
								$matchDisplay = $items[$rule_value]['display'];
								$this->addError(["{$matchDisplay} and {$display} must match", $item]);
							}
							break;
						case 'unique':
							$check = $this->_db->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = ?",[$value]);
							if ($check->count()) {
								$this->addError(["{$display} already exists. Please choose another {$display} ", $item]);
							}
						  break;
						case 'unique_update':
							$t = explode(',', $rule_value);
							$table = $t[0];
							$id = $t[1];
							$query = $this->_db->query("SELECT * FROM {$table} WHERE id != ? AND {$item} = ?", [$id, $value]);
							if ($query->count()) {
								$this->addError(["{$display} already exists", $item]);
							}
						  break;

						case 'numeric':
							if (!is_numeric($value)) {
								$this->addError(["{$display} has to be a number, Please use a numeric value", $item]);
							}
						  break;

						case 'valid_email':
							if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
								$this->addError(["{$display} must be a valid email adress", $item]);
							}
						  break;
					}

				}
			}
		}
		if (empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}

	public function addError($error) {
		$this->_errors[] = $error;
		if (empty($this->_errors)) {
			$this->_passed = true;
		} else {
			$this->_passed = false;
		}
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}

	public function displayErrors() {
		$html = '<div>';
		foreach ($this->_errors as $error) {
			if (is_array($error)) {
			  $html .= '<div class="alert alert-danger" role="alert">';
	 			$html .=  $error[0];
	   		$html .= '</div>';
			} else {
			  $html .= '<div class="alert alert-danger" role="alert">';
	 			$html .=  $error;
	   		$html .= '</div>';
			}
		}
		$html .= '</div>';
		return $html;
	}


}


 ?>

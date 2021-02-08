<?php 

namespace Core;
use Core\FormHelpers;
use Core\Router;

class Input {

	public function isPost() {
		return $this->getRequestMethod() == 'POST';
	}

	public function isGet() {
		return $this->getRequestMethod() == 'GET';
	}

	public function isPut() {
		return $this->getRequestMethod() == 'PUT';
	}

	public function getRequestMethod() {
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}

	public function getAjax($input = false) {

    $content = file_get_contents('php://input');
    $decoded = json_decode($content, true);

    return (($input) ? $decoded[$input] : $decoded);
	}

	public function get($input = false) {
		if (!$input) {
			// return entire request array and sanitize it
			$data = [];
			foreach ($_REQUEST as $field => $value) {
				$data[$field] = FormHelpers::sanitize($value); 
			}
			return $data;
		}
		return FormHelpers::sanitize($_REQUEST[$input]);
	}

	public function csrfCheck() {
		if (!FormHelpers::checkToken($this->get('csrf_token'))) Router::redirect('restricted/badToken');
		return true;
	}

}
?>
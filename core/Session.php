<?php 

namespace Core;

class Session {

	public static function exists($name) {
		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function get($name) {
		return $_SESSION[$name];
	}

	public static function set($name, $value) {
		return $_SESSION[$name] = $value;
	}

	public static function delete($name) {
		if (self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}

	public static function user_agent_no_version() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$regx = '/\/|[a-zA-Z0-9.]+/';
		$newString = preg_replace($regx, '', $user_agent);
		return $user_agent;
	}

	public static function addDisplayMessage($type, $message) {
    $sessionName = 'alert-'. $type;
    self::set($sessionName, $message);
	}

	public static function displayMessage() {
		$alerts = ['alert-info', 'alert-success', 'alert-warning', 'alert-danger'];
    $html = '';
    foreach($alerts as $alert) {
      if(self::exists($alert)) {
        $html .= '<div class="alert '. $alert .' alert-dismissible fade show" role="alert">';
        $html .= self::get($alert); 
        $html .= '
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        ';
        $html .= '</div>';
        self::delete($alert);
      }
    }

    return $html;

	}

}


?>

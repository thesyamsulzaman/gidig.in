<?php 

  use App\Models\Users;

  use Core\Session;
  use Core\Cookie;
  use Core\Router;
  use Core\Database;

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', dirname(__FILE__));

  // Load default stuff from config file
  require_once(ROOT . DS . 'config' . DS . 'config.php');

  // autoloader wrapper
  function autoload($className) {
    $classArray = explode("\\", $className);
    $class = array_pop($classArray);
    $subPath = strtolower(implode(DS, $classArray));
    $path = ROOT . DS . $subPath . DS . $class. '.php';
    if (file_exists($path)) {
      require_once $path;
    } else {
      echo "File not found";
    }

  }


  // autoloader
  spl_autoload_register('autoload');
	session_start();

	// Parse the url into an array
  // Check if we have the path info
  // if we do, we convert it into an array by spliting it with the "/"
	$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER["PATH_INFO"], "/")) : [];


  // if the Session with the name of "blablablabalb" does not exists
  // and Cookie with the name of "blablabla" exists
  // then we jump to the Users class 
  if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
    Users::loginUserFromCookie();
  }

  // URLs Routes
  // Take the url array and pass it as an argument to the static method of Router
  Router::route($url);
  $database = Database::getInstance();






 ?>

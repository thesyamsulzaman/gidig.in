<?php
  namespace Core;
  use Core\Session;
  use Core\Helpers;
  use App\Models\Users;

  class Router {
    public static function route($url) {
      //Controllers
      // Check if the passed url is not empty. 
      // if so, take the first item item of the array that later is going to be the controller's name
      // if not, use the default controller instead

      $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]).'Controller' : DEFAULT_CONTROLLER;
      $controller_name =  str_replace('Controller', '', $controller) ;
      // delete the first item from beginning of the array
      array_shift($url);


      // Action
      $action = (isset($url[0]) && $url[0] != '') ? $url[0]. "Action" : "IndexAction";
      $action_name = (isset($url[0]) && $url[0] != '')  ? $url[0]  : "index" ;
      array_shift($url);
      
      // ACL Checks
      $grantAccess = self::hasAccess($controller_name, $action_name);

      if (!$grantAccess) {
        $controller = ACCESS_RESTRICTED . "Controller";
        $controller_name = ACCESS_RESTRICTED;
        $action = 'indexAction';
      }
      
      // Params
      $query_params = $url;
      $controller = 'App\Controllers\\' .$controller. '';
      // make a new object with the controller name


      // new Register(Register, loginAction);
      $dispatch = new $controller($controller_name, $action);



      if (method_exists($controller, $action)) {
        call_user_func_array([$dispatch, $action], $query_params);
      } else {
        die('Method does not exist on the controller \"'. $controller_name . '\" ');
      }
    }

    public static function redirect($location) {
      if (!headers_sent()) {
        header('Location: '.PROJECT_ROOT.$location);
        exit();
      } else {
        echo "<script>";
        echo 'window.location.href="'.PROJECT_ROOT.$location.'"';
        echo "</script>";
        echo "<noscript>";
        echo '<meta http-equiv="refresh" content="0;url='.$location.'"/>';
        echo "</noscript>";
        exit();
      }
    }

    public static function hasAccess($controller_name, $action_name = 'index') {
      $acl_file = file_get_contents(ROOT . DS . "app" . DS . 'acl.json');
      $acl = json_decode($acl_file, true);
      $current_user_acls = ["Guest"];
      $grantAccess = false;

      if (Session::exists(CURRENT_USER_SESSION_NAME)) {
        $current_user_acls[] = "LoggedIn";
        foreach (Users::currentUser()->acls() as $a) {
          $current_user_acls[] = $a;
        }
      } 

      foreach($current_user_acls as $level ) {
        if (array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])) {
          if (in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])) {
            $grantAccess = true;
            break;
          }
        } 
      }

      foreach ($current_user_acls as $level) {
        $denied = $acl[$level]['denied'];
        if (!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
          $grantAccess = false;
          break;
        }
      }


      return $grantAccess;
    }

    public static function get_menu($menu) {
      // menu_acl
      $menuArr = [];
      $menuFile = file_get_contents(ROOT . DS . "app" . DS . $menu . '.json');
      $acl = json_decode($menuFile, true);

      foreach($acl as $key => $value) {
        if (is_array($value)) {
          $sub = [];
          foreach($value as $k => $v ) {
            if ($k == 'separator' && !empty($sub)) {
              $sub[$k] = '';
              continue;
            } else if ($finalValue = self::get_link($v)) {
              $sub[$k] = $finalValue;
            }
          }
          if (!empty($sub)) {
            $menuArr[$key] = $sub;
          }
        } else {
          if ($finalValue = self::get_link($value)) {
            $menuArr[$key] = $finalValue;
          }
        }
      }
      return $menuArr;
     }

    private static function get_link($value) {
      // check if its an external link
      if (preg_match('/https?:\/\//', $value) == 1 ) {
        return $value;
      } else {
        $uArray = explode(DS, $value);
        $controller_name = ucwords($uArray[0]);
        $action_name = (isset($uArray[1])) ? $uArray[1] : "";

        if (self::hasAccess($controller_name, $action_name)) {
          return PROJECT_ROOT . $value;
        } 
        return false;
      }
    }



  }

?>


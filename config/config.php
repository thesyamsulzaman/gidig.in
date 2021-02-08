<?php

  define('DEBUG', true);
  define('DEFAULT_LAYOUT', 'default'); // if no layout is set in the controller, use this
  define('PROJECT_ROOT', '/gidig.in/'); // set this to '/' for a live server
  define('STATIC_FILES', '/gidig.in/public/'); // set this to '/' for a live server
  define('SITE_TITLE', 'PHP MVC Boilerplate');


  // Database Config
  define('DB_NAME', 'gidigin');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '');
  define('DB_HOST', '127.0.0.1');

  // Cookie and Session
  define('CURRENT_USER_SESSION_NAME', 'abcdefghaijklmnopqrstuvwxyz');
  define('REMEMBER_ME_COOKIE_NAME', "1234567890");
  define('REMEMBER_ME_COOKIE_EXPIRY', 2592000);

  // Root Folder
  define("UPLOADS_DIR", getcwd() . '/');

  // default Controller
  define('ACCESS_RESTRICTED', 'Restricted'); // controller name for restricted route
  define('DEFAULT_CONTROLLER', 'HomeController'); // default controller if theres isnt one defined by the url


?>

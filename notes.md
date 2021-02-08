## The Flow of the Architecture


### Application.php
  * Methods and Variables

      ``` php
    1. __construct()

    Instanciate the methods
    ```
    
      ``` php
    2. __set_reporting()
      ```
    
      ``` php
    3. __unregister_globals() ```
   
  * Responsible for
    1. Writing the Error Log 
    1. Unregister all the global variables




### Controller.php
  * Methods and Variables

      ``` php
    1. __construct()
    ```
    
      ``` php
    2. $_controller()
      ```
    
      ``` php
    3. $_action()
      ```

      ``` php
    4. $_view()
      ```
   
  * Responsible for
    1. Construct the __Application__ class and Controller all at once
    1. Instanciate The View Object



### Database.php

  * Methods and Variables

      ``` php
    1. __construct()
    ```

      ``` php
    2. __getInstance()
      ```

    
   
  * Responsible for
    1. Construct the __Application__ class and Controller all at once
    1. Instanciate The View Object
### Model.php
### Router.php
### View.php


### config.php
1. Define a constant of the directory separator
1. Define a constant of a root project folder
1. Define some contants of Database data

### index.php
1. Spit out the config files and function 
1. Spit out the helper functions 
1. load all the classes that are inside of core, controllers and models
1. Start the session
1. Parse the url from "$SERVER" into an array
1. Take the url into static method called route from ***Router*** class
1. Instanciate Database instances use static method called getInstance() from
   ***Database*** Class




## Some stuff that i learned along the way




#### 1. Session 
  ``` php
  start_session()
  ```

#### 2. $_SERVER Global Variable 
#### 3. PHP Ternary Operator 
#### 4. explode() function


  ``` php
    explode(new Array())
  ```
  construct new child object and the parent as well

#### 5. ltrim and rtrim Function 
#### 6. require_once function 
#### 7. __autoload function 
#### 8. file_exists function 
#### 9. die() method 
#### 10. method_exist() function 
#### 11. array_shift function 
#### 12. call_user_func_array 
#### 13. Construct Method
  ``` php
    parent::construct()
  ```
  construct new child object and the parent as well
#### 14. htmlentities()
#### 15. $var[ ] = values;
#### 16. $var[ ] = values;


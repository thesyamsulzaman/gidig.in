
<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

use Core\Database;
use Core\Model;
use Core\Helpers;

require_once("../config/config.php");
require_once("../core/Database.php");
require_once("../core/Model.php");



class Students extends Model {

  public $id, $first_name, $last_name, $name, $rate;
  public function __construct() {
    $table = "students";
    parent::__construct($table);
    $this->_softDelete = true;
  }
  

  public function findData() {
    return ["hello" => "World"];
  }

  public function findAllStudents($user_id = '', $params = []) {
    $conditions = [
      'conditions' => 'user_id = ?', 
      'bind' => [$user_id],
    ];

    $conditions = array_merge($conditions, $params);
    var_dump($this->find($conditions));
    //return $this->find($conditions);

    //var_dump($this->query("select * from students where user_id = 1"));
  }


}

$StudentsModel = new Students();

$students = $StudentsModel->findAllStudents(1);
//foreach($students as $student) {
  //var_dump($student->findData());
//}







?>

<?php 

namespace Core;
use \PDO;
use \PDOException;
use Core\Helpers;

class Database {
	// Instansiate some private variables
	private static $_instance = null;
	private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_lastInsertID = null;

	private function __construct() {
		// Create a PDO Object when the class is being initiated
		try {
			$this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';',DB_USERNAME, DB_PASSWORD);
			$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance() {
		// check if $_instance variable is empty
		if (!isset(self::$_instance)) {
			// we assign the $_instance variable as a new Database Object
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function bind($param, $value, $type=null) {
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
					break;
			}
		}
  	return $this->_query->bindValue($param, $value, $type);
	}

  public function query($sql, $params = [], $class = []) {
  	// set the $_error variable to false;
    $this->_error = false;
    // prepare the sql statement that we took from the argument
    // assign it to $_query variable
    if ($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;
      // check if the params contains number
      if (count($params)) {
      	// for each element inside of params variables
        foreach($params as $param) {
        	// bind it the bind() method
        	$this->bind($x,$param);
          $x++;
        }
      }
      // execute the query
      if ($this->_query->execute()) {
      	if ($class) {
          $this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS, $class);
      	} else {
	      	// store all the result into $_result
	        $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
      	}
      	// store the number of count into $_count
        $this->_count = $this->_query->rowCount();
      	// store the last inserted row into $_lastInsertID
        $this->_lastInsertID = $this->_pdo->lastInsertId();

      } else {
      	// otherwise this will return true
        $this->_error = true;
      }
    }
    return $this;
  }

 // $db->insert("student", [
 //   "student_id" => 8,
 //   "name" => "Karl Urban",
 //   "major" => "Butcher Science"
 // ]);

  public function insert($table, $fields = []) {
  	$fieldsString = ""; 
  	$valueString = ""; 
  	$values = []; 

		 // [
		 //   "student_id" => 8,
		 //   "name" => "Karl Urban",
		 //   "major" => "Butcher Science"
		 // ]

  	foreach ($fields as $field => $value) {
  		$fieldsString .= ' `'. $field . '`,';
  	  // fieldsString = `student_id, name, major, `
  		$valueString  .= '?,';
  		// valueString = ' ?, ?, ?, '
  		$values[] = $value;
  		// values = [8, "Karl Urban", "Butcher Science"]
  	}

  	$fieldsString = rtrim($fieldsString, ',');
  	// delete the coma at the very end
 	  // fieldsString = `student_id, name, major `
  	$valueString = rtrim($valueString, ',');
  	// delete the coma at the very end
 	  // valueString = `?, ?, ? `

  	$sql = "INSERT INTO {$table} ({$fieldsString}) VALUES ({$valueString})";
  	// $sql = INSERT INTO student (`student_id, name, major`) VALUES `?, ?, ?`;

	 	if (!$this->query($sql, $values)->error()) {
	 		return true;
	 	}
	 	return false;
	}

	public function update($table, $id ,$fields = []) {
  	$fieldString = ""; 
  	$values = []; 

		 // [
		 //   "student_id" => 8,
		 //   "name" => "Karl Urban",
		 //   "major" => "Computer Science"
		 // ]

  	foreach ($fields as $field => $value) {
  		$fieldString .= ' ' . $field . ' = ? ,';
  	  // fieldsString = `student_id = ?, name = ?, major = ?, `
  		$values[] = $value;
  		// values = [8, "Karl Urban", "Butcher Science"]
  	}

  	$fieldString = trim($fieldString);
  	  // fieldsString = `student_id = ?, name = ?, major = ?`
  	$fieldString = rtrim($fieldString, ",");
  	  // fieldsString = `student_id = ?,name = ?,major = ?`


  	$sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
  	// $sql = UPDATE student SET student_id = ?, name = ?, major = ? WHERE student_id = 8;


	 	if (!$this->query($sql, $values)->error()) {
	 		return true;
	 	}
     return false;
	}

	public function delete($table, $id) {
		$sql = "DELETE FROM {$table} WHERE id = {$id}";

	 	if (!$this->query($sql)->error()) {
	 		return "Deleting Data Success";
	 	}
	 	return "Deleting Data Failed";

	}

	protected function _read($table, $params = [], $class = []) {
		$conditionString = '';
		$bind = [];
		$order = '';
		$limit = '';
		$joins = '';

		// $db->find(
		// 	"student", [
    //        "conditions" => ["major LIKE ?", "name LIKE ?"],
	  //        "bind" => ['%'."Science".'%'],
	  //      ]
	  //  );	

		// condition
		// check if we have the the params array with "conditions" as key
		if (isset($params['conditions'])) {
	   	// check if the conditions is an array
			if (is_array($params['conditions'])) {
				foreach ($params['conditions'] as $condition) {
					$conditionString .= ' ' . $condition . ' AND ';
					// conditionString = 'major LIKE ? AND name LIKE ? AND'
				}
				$conditionString = trim($conditionString);
				// conditionString = 'major LIKE ? AND name LIKE ? AND'
				$conditionString = rtrim($conditionString, ' AND');
				// conditionString = 'major LIKE ? AND name LIKE ?'

			} else {
				// if the $params array is not an array;
			  $conditionString = $params["conditions"];
				// conditionString = 'major LIKE ?'
		  } 

		  if ($conditionString != '') {
		  	// if the conditionString is not empty
   		  $conditionString = ' WHERE '.$conditionString;
				// conditionString = 'WHERE major LIKE ?'
		  }
		}

		// binding
		if (array_key_exists('bind', $params)) {
			// check if we have the array with the key of bind
			$bind = $params['bind'];
		}

		// order
		if (array_key_exists('order', $params)) {
			// check if we have the array with the key of order
			$order = ' ORDER BY '. $params['order'];
		}

		// limit 
		if (array_key_exists('limit', $params)) {
			// check if we have the array with the key of limit
			$limit = ' LIMIT '. $params['limit'];
		}

		$sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
		// sql = SELECT * FROM student WHERE major LIKE ? AND name LIKE ?


		if ($this->query($sql, $bind, $class)) {
			if (!count($this->_result)) return false;
			return true;
		}
	}

	public function find($table, $params = [], $class = false ) {
		if ($this->_read($table, $params, $class)) {
			return $this->results();
		}
		return false;
	}

	public function findFirst($table, $params = [], $class = false) {
		if ($this->_read($table, $params, $class)) {
			return $this->first();
		}
		return false;

	}


  // Migrations


  // Getter
	public function results() {
		return $this->_result;
	}

	public function first() {
		return (!empty($this->_result[0])) ? $this->_result[0] : [];
	}

	public function count() {
		return $this->_count;
	}

	public function lastId() {
		return $this->_lastInsertID;
	}

	public function get_columns($table) {
		return $this->query("SHOW COLUMNS FROM {$table}")->results();
	}

  public function error() {
	 	return $this->_error;
  }


}


?>

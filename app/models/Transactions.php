<?php 

namespace App\Models;

use Core\Model;
use Core\Helpers;

use Core\Validators\RequiredValidator;

class Transactions extends Model {
	protected static $_table = "transactions";
	protected static $_softDelete = true;

	public $id, $created_at, $update_at;

}











 ?>
<?php 

namespace App\Models;

use Core\Model;
use Core\Helpers;

use Core\Validators\RequiredValidator;

class Transactions extends Model {

	protected static $_table = "transactions";
	protected static $_softDelete = true;

	public $id, $created_at, $update_at, $cart_id, $gateway, $type, $amount, $success = 0;
	public $charge_id, $reason, $card_brand, $last4, $name, $shipping_address1, $shipping_address2;
	public $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $deleted = 0;

	public function beforeSave() {
		$this->timeStamps();
	}

	public function validateShipping() {
		$this->runValidation(new RequiredValidator($this, ['field' => 'name', 'message' => 'Name is required']));
		$this->runValidation(new RequiredValidator($this, ['field' => 'shipping_address1', 'message' => 'Address is required']));
		$this->runValidation(new RequiredValidator($this, ['field' => 'shipping_city', 'message' => 'City is required']));
		$this->runValidation(new RequiredValidator($this, ['field' => 'shipping_state', 'message' => 'State is required']));
		$this->runValidation(new RequiredValidator($this, ['field' => 'shipping_zip', 'message' => 'State is required']));
	}

	


}











 ?>
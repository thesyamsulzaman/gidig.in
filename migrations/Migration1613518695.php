<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1613518695 extends Migration {
    public function up() {
    	$table = 'transactions';
    	$this->createTable($table);
    	$this->addTimeStamps($table);
    	$this->addColumn($table, "cart_id", 'int');
    	$this->addColumn($table, "gateway", 'varchar', ['size' => 15]);
    	$this->addColumn($table, "type", 'varchar', ['size' => 25]);
    	$this->addColumn($table, "amount", 'decimal', ['precision' => 10, 'scale' => 2]);
    	$this->addColumn($table, "charge_id", 'varchar', ['size' => 255]);
    	$this->addColumn($table, "success", 'tinyint');
    	$this->addColumn($table, "reason", 'varchar', ['size' => 155]);
    	$this->addColumn($table, "card_brand", 'varchar', ['size' => 25]);
    	$this->addColumn($table, "last4", 'varchar', ['size' => 4]);
    	$this->addColumn($table, "name", 'varchar', ['size' => 255]);
    	$this->addColumn($table, "shipping_address1", 'varchar', ['size' => 255]);
    	$this->addColumn($table, "shipping_address2", 'varchar', ['size' => 255]);
    	$this->addColumn($table, "shipping_state", 'varchar', ['size' => 255]);
    	$this->addColumn($table, "shipping_city", 'varchar', ['size' => 255]);
    	$this->addColumn($table, "shipping_zip", 'varchar', ['size' => 55]);
    	$this->addColumn($table, "shipping_country", 'varchar', ['size' => 15]);
    	$this->addSoftDelete($table);
    	$this->addIndex($table, 'cart_id');
    	$this->addIndex($table, 'success');


    }
  }
  
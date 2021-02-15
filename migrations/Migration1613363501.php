<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1613363501 extends Migration {
    public function up() {
    	$table = 'carts';
    	$this->createTable($table);
    	$this->addTimeStamps($table);
    	$this->addColumn($table, 'purchased', 'tinyint');
    	$this->addSoftDelete($table);
    	$this->addIndex($table, 'purchased');

    	$table = 'cart_items';
    	$this->createTable($table);
    	$this->addTimeStamps($table);
    	$this->addColumn($table, 'cart_id', 'int');
    	$this->addColumn($table, 'product_id', 'int');
    	$this->addColumn($table, 'quantity', 'int');
    	$this->addSoftDelete($table);
    	$this->addIndex($table, 'cart_id');
    	$this->addIndex($table, 'product_id');
    }
  }
  
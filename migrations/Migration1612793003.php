<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1612793003 extends Migration {
    public function up() {
      $table = "products";
      $this->addColumn($table, 'sort', 'int', ['after' => 'url']);
      $this->addIndex($table, 'sort');
    }
  }
  

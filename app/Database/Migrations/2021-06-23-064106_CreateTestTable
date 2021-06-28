<?php

use CodeIgniter\Database\Migration;

class CreateTestTable extends Migration
{
    public function up() {
       $this->forge->addField([
          'id' => [
              'type' => 'INT',
              'constraint' => 5,
              'unsigned' => true,
              'auto_increment' => true,
          ],
          'name' => [
              'type' => 'VARCHAR',
              'constraint' => '100',
          ],
          'email' => [
              'type' => 'VARCHAR',
              'constraint' => '100',
          ],
          'city' => [
              'type' => 'VARCHAR',
              'constraint' => '100',
          ],
          'status' => [
              'type' => 'INT',
              'constraint' => '2',
          ],
       ]);
       $this->forge->addKey('id', true);
       $this->forge->createTable('test');
    }

    //--------------------------------------------------------------------

    public function down() {
       $this->forge->dropTable('test');
    }
}
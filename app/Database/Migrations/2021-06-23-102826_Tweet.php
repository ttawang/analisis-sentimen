<?php

use CodeIgniter\Database\Migration;

class Tweet extends Migration
{
    public function up() {
       $this->forge->addField([
          'id' => [
              'type' => 'INT',
              'constraint' => 1,
              #'unsigned' => true,
              'auto_increment' => true,
          ],
          'tanggal' => [
              'type' => 'DATE',
          ],
          'kalimat' => [
              'type' => 'VARCHAR',
              'constraint' => '500',
          ],
          'ket' => [
              'type' => 'BOOLEAN',
          ],
       ]);
       $this->forge->addKey('id', true);
       $this->forge->createTable('tweet');
    }

    //--------------------------------------------------------------------

    public function down() {
       $this->forge->dropTable('tweet');
    }
}
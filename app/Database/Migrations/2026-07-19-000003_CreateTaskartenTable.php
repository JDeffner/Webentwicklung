<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskartenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'taskart' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'taskartenicon' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('taskarten');
    }

    public function down()
    {
        $this->forge->dropTable('taskarten');
    }
}

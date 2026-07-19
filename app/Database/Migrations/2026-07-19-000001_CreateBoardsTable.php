<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBoardsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'board' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('boards');
    }

    public function down()
    {
        $this->forge->dropTable('boards');
    }
}

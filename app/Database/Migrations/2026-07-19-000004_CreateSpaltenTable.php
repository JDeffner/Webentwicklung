<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpaltenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'boardsid' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'sortid' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'spalte' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'spaltenbeschreibung' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('boardsid', 'boards', 'id');
        $this->forge->createTable('spalten');
    }

    public function down()
    {
        $this->forge->dropTable('spalten');
    }
}

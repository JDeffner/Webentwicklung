<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTasksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'personenid' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'taskartenid' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'spaltenid' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'sortid' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'task' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'erstelldatum' => [
                'type' => 'DATE',
            ],
            'erinnerungsdatum' => [
                'type' => 'DATETIME',
            ],
            'erinnerung' => [
                'type'       => 'SMALLINT',
                'constraint' => 6,
                'default'    => 0,
            ],
            'notizen' => [
                'type' => 'TEXT',
            ],
            'erledigt' => [
                'type'       => 'SMALLINT',
                'constraint' => 6,
                'default'    => 0,
                'null'       => true,
            ],
            'geloescht' => [
                'type'       => 'SMALLINT',
                'constraint' => 6,
                'default'    => 0,
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('spaltenid', 'spalten', 'id');
        $this->forge->addForeignKey('taskartenid', 'taskarten', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('personenid', 'personen', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tasks');
    }

    public function down()
    {
        $this->forge->dropTable('tasks');
    }
}

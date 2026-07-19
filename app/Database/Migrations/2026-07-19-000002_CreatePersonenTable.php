<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'vorname' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nachname' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'permission' => [
                'type'       => 'SMALLINT',
                'constraint' => 6,
                'default'    => 1,
            ],
            'passwort' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('personen');
    }

    public function down()
    {
        $this->forge->dropTable('personen');
    }
}

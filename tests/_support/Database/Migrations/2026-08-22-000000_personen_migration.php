<?php

namespace Tests\Support\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Mirrors the personen table of databaseStructure.sql so the registration
 * boundary can be tested against the tests database group.
 */
class PersonenMigration extends Migration
{
    protected $DBGroup = 'tests';

    public function up()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'vorname'    => ['type' => 'varchar', 'constraint' => 50],
            'nachname'   => ['type' => 'varchar', 'constraint' => 50],
            'email'      => ['type' => 'varchar', 'constraint' => 100],
            'permission' => ['type' => 'smallint', 'default' => 1],
            'passwort'   => ['type' => 'varchar', 'constraint' => 255],
        ]);
        $this->forge->createTable('personen');
    }

    public function down()
    {
        $this->forge->dropTable('personen');
    }
}

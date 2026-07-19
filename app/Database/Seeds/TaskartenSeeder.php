<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeds the default Taskarten (task types).
 *
 * At least one Taskart MUST exist, because every Task requires a
 * `taskartenid` (NOT NULL foreign key) and Taskarten can only be
 * created by an administrator. Without this seed data it is impossible
 * to create any Task on a fresh installation.
 *
 * The icons are Font Awesome CSS classes (Font Awesome is loaded
 * globally in the Head template).
 */
class TaskartenSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'taskart'       => 'Aufgabe',
                'taskartenicon' => 'fa-solid fa-list-check',
            ],
            [
                'taskart'       => 'Bug',
                'taskartenicon' => 'fa-solid fa-bug',
            ],
            [
                'taskart'       => 'Feature',
                'taskartenicon' => 'fa-solid fa-lightbulb',
            ],
            [
                'taskart'       => 'Meeting',
                'taskartenicon' => 'fa-solid fa-users',
            ],
        ];

        $this->db->table('taskarten')->insertBatch($data);
    }
}

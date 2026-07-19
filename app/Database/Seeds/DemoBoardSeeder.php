<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeds a starter board with three classic Kanban columns so the
 * application is usable right after installation. Feel free to rename
 * or delete the board through the UI afterwards.
 */
class DemoBoardSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('boards')->insert(['board' => 'Mein Board']);
        $boardId = $this->db->insertID();

        $spalten = [
            [
                'boardsid'            => $boardId,
                'sortid'              => 1,
                'spalte'              => 'To Do',
                'spaltenbeschreibung' => 'Aufgaben, die noch nicht begonnen wurden',
            ],
            [
                'boardsid'            => $boardId,
                'sortid'              => 2,
                'spalte'              => 'In Arbeit',
                'spaltenbeschreibung' => 'Aufgaben, die gerade bearbeitet werden',
            ],
            [
                'boardsid'            => $boardId,
                'sortid'              => 3,
                'spalte'              => 'Erledigt',
                'spaltenbeschreibung' => 'Abgeschlossene Aufgaben',
            ],
        ];

        $this->db->table('spalten')->insertBatch($spalten);
    }
}

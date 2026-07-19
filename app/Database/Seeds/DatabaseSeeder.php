<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Master seeder — runs all seeders required for a working installation.
 *
 * Usage:
 *   php spark db:seed DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(TaskartenSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(DemoBoardSeeder::class);
    }
}

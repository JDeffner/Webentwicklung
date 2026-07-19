<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeds the initial administrator account.
 *
 * The registration form always creates users with permission level 1
 * (Benutzer). Admin-only areas (Taskarten and Personen management)
 * require permission level 2, so the very first admin account has to
 * be created directly in the database — that is what this seeder does.
 *
 * Default credentials (CHANGE THE PASSWORD AFTER THE FIRST LOGIN!):
 *   E-Mail:   admin@example.com
 *   Passwort: admin1234
 */
class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'vorname'    => 'Admin',
            'nachname'   => 'Admin',
            'email'      => 'admin@example.com',
            'permission' => 2,
            'passwort'   => password_hash('admin1234', PASSWORD_DEFAULT),
        ];

        $this->db->table('personen')->insert($data);
    }
}

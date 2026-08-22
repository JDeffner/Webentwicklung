<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * Audit H2: registration must not let the request choose its own permission.
 *
 * @internal
 */
final class BenutzerErstellenTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $namespace   = 'Tests\Support';

    public function testRegistrationIgnoresAPostedPermission()
    {
        $this->post('benutzer/erstellen', [
            csrf_token()  => csrf_hash(),
            'vorname'     => 'Eve',
            'nachname'    => 'Attacker',
            'email'       => 'eve@example.com',
            'passwort'    => 'geheim',
            'permission'  => '2',
        ]);

        $this->seeInDatabase('personen', ['email' => 'eve@example.com', 'permission' => 1]);
        $this->dontSeeInDatabase('personen', ['email' => 'eve@example.com', 'permission' => 2]);
    }
}

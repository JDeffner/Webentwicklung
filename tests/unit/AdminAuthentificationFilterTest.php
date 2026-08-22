<?php

use App\Filters\adminAuthentification;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Services;

/**
 * Audit C1: the admin gate must not believe anything the client can write.
 *
 * @internal
 */
final class AdminAuthentificationFilterTest extends CIUnitTestCase
{
    public function testForgedPermissionCookieIsRejected()
    {
        $_COOKIE['permissionLevel'] = '2';

        $result = (new adminAuthentification())->before(Services::request());

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertStringContainsString('denied', $result->getHeaderLine('Location'));

        unset($_COOKIE['permissionLevel']);
    }

    public function testAdminSessionIsAccepted()
    {
        session()->set('permissionLevel', '2');

        $this->assertNull((new adminAuthentification())->before(Services::request()));

        session()->remove('permissionLevel');
    }
}

<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class benutzerAuthentification implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Guests (permissionLevel 0) may read the boards but not change them.
        if (session()->get('permissionLevel') < 1) {
            return redirect()->to('/denied');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}

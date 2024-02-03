<?php

namespace App\Controllers;



class ErrorController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Zugriff verweigert',
        ];
        echo view('errors/AccessDenied', $data);
    }


}
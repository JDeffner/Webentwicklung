<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Startseite',
        ];
        echo view('pages/index', $data);
    }


}

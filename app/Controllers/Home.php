<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Startseite',
        ];
        echo view('templates/Header', $data);
        echo view('pages/index');
        echo view('templates/Footer');
    }

    public function getgruppennummer(){
        var_dump(04);
    }

}

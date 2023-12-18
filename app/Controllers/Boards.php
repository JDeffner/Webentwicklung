<?php

namespace App\Controllers;

class Boards extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Boards',
        ];
        echo view('templates/Header', $data);
        echo view('pages/Boards');
        echo view('templates/Footer');
    }

    public function getgruppennummer(){
        var_dump(04);
    }

}

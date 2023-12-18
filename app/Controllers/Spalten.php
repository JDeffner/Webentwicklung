<?php

namespace App\Controllers;

class Spalten extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Spalten',
        ];
        echo view('pages/Spalten', $data);
    }

    public function getSpalteErstellen(){
        $data = [
            'title' => 'Spalte Erstellen',
        ];
        echo view('pages/SpalteErstellen', $data);
    }

}

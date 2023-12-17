<?php

namespace App\Controllers;

class Spalten extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Spalten',
        ];
        echo view('templates/Header', $data);
        echo view('pages/Spalten');
        echo view('templates/Footer');
    }

    public function getSpalteErstellen(){
        $data = [
            'title' => 'Spalte Erstellen',
        ];
        echo view('templates/Header', $data);
        echo view('pages/SpalteErstellen');
        echo view('templates/Footer');
    }

    public function getgruppennummer(){
        var_dump(04);
    }
}

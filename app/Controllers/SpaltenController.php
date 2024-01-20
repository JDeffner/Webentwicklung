<?php

namespace App\Controllers;
use App\Models\Spalten;

class SpaltenController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Spalten',
        ];
        $spaltenModel = new SpaltenController();
        echo view('pages/Spalten', $data);
    }

    public function getSpalteErstellen(){
        $data = [
            'title' => 'Spalte Erstellen',
        ];
        echo view('pages/SpalteErstellen', $data);
    }

}

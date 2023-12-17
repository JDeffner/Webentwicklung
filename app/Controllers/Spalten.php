<?php

namespace App\Controllers;

class Spalten extends BaseController
{
    public function index(): string
    {
        return view('templates/Spalten');
    }

    public function getSpalteErstellen(){
        return view('templates/SpalteErstellen');
    }
}

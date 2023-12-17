<?php

namespace App\Controllers;

class viewGruppennummer extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function getgruppennummer(){
        var_dump(04);
    }

    public function getviews(){
        return view('templates/index');
    }


}
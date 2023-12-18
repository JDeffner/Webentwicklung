<?php

namespace App\Controllers;

class Welcome extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function viewGruppennummer(){
        var_dump(04);
    }


}
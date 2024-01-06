<?php

namespace App\Controllers;
use App\Models\Tasks;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Startseite',
        ];
        echo view('pages/Startseite', $data);
    }



    public function newUser(){
        $data = [
            'title' => 'Neuer Benutzer',

        ];
//        if($this->request->getMethod() == 'post')
        echo view('pages/NewUser', $data);
    }

}

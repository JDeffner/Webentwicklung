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

    public function NewUser(){
        $data = [
            'title' => 'Neuer Benutzer',

        ];
//        if($this->request->getMethod() == 'post')
        echo view('pages/NewUser', $data);
    }

}

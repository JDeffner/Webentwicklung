<?php

namespace App\Controllers;

class Boards extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Boards',
        ];
        echo view('pages/Boards', $data);
    }


}

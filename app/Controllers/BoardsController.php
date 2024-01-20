<?php

namespace App\Controllers;

class BoardsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Boards',
        ];
        echo view('pages/Boards', $data);
    }


}

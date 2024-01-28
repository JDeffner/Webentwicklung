<?php

namespace App\Controllers;
use App\Models\TasksModel;


class DeveloperController extends BaseController
{
    public function index()
    {
        echo view('pages/dev/welcome_message');
    }

    public function viewGruppennummer(){
        var_dump(04);
    }

    public function test()
    {
        var_dump('test');
    }

    public function abweisung()
    {
        $data = [
            'title' => 'Login',
        ];
        echo view('pages/dev/Abweisung', $data);
    }

}
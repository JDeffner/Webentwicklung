<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PersonenModel;
use ReflectionException;

class AdminController extends BaseController
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

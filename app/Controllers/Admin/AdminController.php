<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PersonenModel;
use ReflectionException;

class AdminController extends BaseController
{
    public function viewGruppennummer(){
        return '04';
    }

    public function abweisung()
    {
        $data = [
            'title' => 'Login',
        ];
        echo view('pages/dev/Abweisung', $data);
    }
}

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

public function testDatabase() {
        $testTasksModel = new TasksModel();
        $data['tasks'] = $testTasksModel->getCuratedData();
        echo view('pages/dev/TestDatabase', $data);
}

public function test($string)
{
    var_dump($string);
}

public function abweisung()
{
    $data = [
        'title' => 'Login',
    ];
    echo view('pages/dev/Abweisung', $data);
}

}